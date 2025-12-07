<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory;
use Exception;
use Illuminate\Support\Facades\URL;

class AnalyzerController extends Controller
{
    public function index()
    {
        return view('analyzer');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        try {
            $file = $request->file('cv_file');
            $extension = $file->getClientOriginalExtension();

            Log::info('File uploaded', [
                'filename' => $file->getClientOriginalName(),
                'extension' => $extension,
                'size' => $file->getSize()
            ]);

            $cvText = $this->extractText($file, $extension);

            Log::info('Text extracted', [
                'text_length' => strlen($cvText),
                'text_preview' => substr($cvText, 0, 100)
            ]);

            if (empty(trim($cvText))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not extract text from the CV. Please ensure the file contains readable text.'
                ], 400);
            }

            $analysis = $this->analyzeWithGemini($cvText);

            Log::info('Analysis completed', [
                'rating' => $analysis['rating'] ?? 0,
                'has_strengths' => !empty($analysis['strengths'])
            ]);

            // Generate unique ID
            $resultId = uniqid('result_', true);

            // Store in cache for 30 minutes
            Cache::put("cv_analysis_{$resultId}", $analysis, now()->addMinutes(30));

            // Generate a temporary signed URL (expires in 30 min)
            $redirectUrl = URL::temporarySignedRoute(
                'analyzer.results',
                now()->addMinutes(30),
                ['id' => $resultId]
            );

            return response()->json([
                'success' => true,
                'redirect' => $redirectUrl
            ]);
        } catch (Exception $e) {
            Log::error('CV Analysis Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while analyzing your CV. Please try again.'
            ], 500);
        }
    }

    public function results($id)
    {
        // If using signed routes, Laravel automatically validates signature
        $analysis = Cache::get("cv_analysis_{$id}");

        if (!$analysis) {
            abort(404, 'Analysis not found or has expired.');
        }

        return view('analyzer.results', [
            'analysis' => $analysis,
            'id' => $id
        ]);
    }

    private function extractText($file, $extension)
    {
        $text = '';

        // Read file contents directly from memory
        $contents = $file->get();

        Log::info('Extracting text for extension', ['extension' => $extension]);

        try {
            if ($extension === 'pdf') {
                // Try two different methods for PDF parsing
                $text = $this->extractPdfText($contents);
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $text = $this->extractWordText($contents, $extension);
            }
        } catch (Exception $e) {
            Log::error('Text Extraction Error: ' . $e->getMessage());
            Log::error('Extraction trace: ' . $e->getTraceAsString());
            throw $e;
        }

        return trim($text);
    }

    private function extractPdfText($contents)
    {
        $text = '';

        try {
            $parser = new PdfParser();

            try {
                $pdf = $parser->parseContent($contents);
                $text = $pdf->getText();
                Log::info('PDF parsed successfully using parseContent');
            } catch (\Exception $e) {
                Log::warning('Smalot parseContent failed, trying parseFile: ' . $e->getMessage());

                // Fallback: Save to temp file
                $tempPath = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';
                file_put_contents($tempPath, $contents);
                $pdf = $parser->parseFile($tempPath);
                $text = $pdf->getText();
                unlink($tempPath);
                Log::info('PDF parsed successfully using parseFile');
            }

            // Clean up the text
            $text = $this->cleanText($text);
        } catch (\Exception $e) {
            Log::error('PDF extraction failed: ' . $e->getMessage());
            // Try fallback
            $text = $this->fallbackPdfExtraction($contents);
        }

        return $text;
    }

    private function cleanText($text)
    {
        if (empty($text)) {
            return '';
        }

        // Remove excessive whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        // Remove non-printable characters
        $text = preg_replace('/[^\x20-\x7E\x0A\x0D\xC2\xA0-\xEF\xBF\xBD]/u', ' ', $text);

        return trim($text);
    }

    private function fallbackPdfExtraction($contents)
    {
        $text = '';

        Log::info('Trying fallback PDF extraction');

        // Extract printable ASCII characters
        $text = preg_replace('/[^\x20-\x7E\n\r\t]/', ' ', $contents);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    private function extractWordText($contents, $extension)
    {
        $text = '';

        // Create a temporary file
        $tempPath = tempnam(sys_get_temp_dir(), 'cv_') . '.' . $extension;
        file_put_contents($tempPath, $contents);

        try {
            $phpWord = IOFactory::load($tempPath);

            // More robust text extraction for Word documents
            foreach ($phpWord->getSections() as $section) {
                $elements = $section->getElements();
                foreach ($elements as $element) {
                    if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                        foreach ($element->getElements() as $textElement) {
                            if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                $text .= $textElement->getText() . ' ';
                            }
                        }
                    } elseif (method_exists($element, 'getText')) {
                        $text .= $element->getText() . ' ';
                    }
                }
                $text .= "\n";
            }
        } catch (\Exception $e) {
            Log::error('Word extraction failed: ' . $e->getMessage());
            throw $e;
        } finally {
            // Always clean up
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
        }

        return $this->cleanText($text);
    }

    private function analyzeWithGemini($cvText)
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            throw new Exception('GEMINI_API_KEY not configured in .env file');
        }

        // Truncate CV text to reasonable length
        $maxLength = 5000;
        if (strlen($cvText) > $maxLength) {
            $cvText = substr($cvText, 0, $maxLength) . '... [TRUNCATED FOR ANALYSIS]';
        }

        $prompt = $this->buildAnalysisPrompt($cvText);

        // Further limit prompt size
        $prompt = substr($prompt, 0, 6000);

        Log::info('Sending request to Gemini API', [
            'prompt_length' => strlen($prompt),
            'api_key_exists' => !empty($apiKey),
            'cv_length_original' => strlen($cvText)
        ]);

        try {
            // Try different model endpoints
            $models = [
                'gemini-2.5-flash',
                'gemini-1.5-flash-8b',  // Try 8B parameter version if available
                'gemini-2.0-pro',       // Pro version if flash fails
            ];

            $lastError = null;
            $response = null;

            foreach ($models as $model) {
                try {
                    Log::info('Trying model: ' . $model);

                    $response = Http::timeout(60)
                        ->retry(1, 1000)
                        ->post(
                            "https://generativelanguage.googleapis.com/v1/models/{$model}:generateContent?key={$apiKey}",
                            [
                                'contents' => [
                                    [
                                        'parts' => [
                                            ['text' => $prompt]
                                        ]
                                    ]
                                ],
                                'generationConfig' => [
                                    'temperature' => 0.7,
                                    'maxOutputTokens' => 1500,
                                    'topP' => 0.95,
                                ]
                            ]
                        );

                    Log::info('API Response for ' . $model, ['status' => $response->status()]);

                    if ($response->successful()) {
                        break; // Success, stop trying other models
                    }

                    $lastError = 'Model ' . $model . ' failed with status: ' . $response->status();
                    Log::warning($lastError);
                } catch (\Exception $e) {
                    $lastError = 'Model ' . $model . ' error: ' . $e->getMessage();
                    Log::warning($lastError);
                    continue; // Try next model
                }
            }

            if (!$response || !$response->successful()) {
                throw new Exception('All models failed. Last error: ' . $lastError);
            }

            $result = $response->json();

            Log::info('Gemini API Response Data', [
                'keys' => array_keys($result),
                'has_candidates' => isset($result['candidates']),
                'has_parts' => isset($result['candidates'][0]['content']['parts']),
                'full_response_debug' => json_encode($result, JSON_PRETTY_PRINT) // For debugging
            ]);

            // Check for prompt feedback blocking
            if (isset($result['promptFeedback']['blockReason'])) {
                Log::error('Prompt blocked: ' . $result['promptFeedback']['blockReason']);
                throw new Exception('Content blocked by safety filters: ' . $result['promptFeedback']['blockReason']);
            }

            // Extract the generated text - handle different response formats
            $generatedText = '';

            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                // Standard format
                $generatedText = $result['candidates'][0]['content']['parts'][0]['text'];
            } elseif (isset($result['candidates'][0]['content']['text'])) {
                // Alternative format
                $generatedText = $result['candidates'][0]['content']['text'];
            } elseif (isset($result['text'])) {
                // Another possible format
                $generatedText = $result['text'];
            }

            // Clean the text
            $generatedText = trim($generatedText);

            Log::info('Generated text extracted', [
                'length' => strlen($generatedText),
                'preview' => substr($generatedText, 0, 200),
                'is_empty' => empty($generatedText)
            ]);

            if (empty($generatedText)) {
                // Log the full response for debugging
                Log::warning('Empty response from Gemini API. Full response:', $result);

                // Check if there's an error message
                if (isset($result['error']['message'])) {
                    throw new Exception('API Error: ' . $result['error']['message']);
                }

                // Try to get any text from the response
                $generatedText = $this->extractAnyTextFromResponse($result);

                if (empty($generatedText)) {
                    Log::warning('No text could be extracted, using fallback analysis');
                    return $this->generateFallbackAnalysis($cvText);
                }
            }

            // Parse the structured response
            $analysis = $this->parseGeminiResponse($generatedText);

            // If parsing failed, use fallback
            if (empty($analysis['strengths']) && empty($analysis['improvements'])) {
                Log::warning('Parsing returned empty analysis, using fallback');
                return $this->generateFallbackAnalysis($cvText);
            }

            return $analysis;
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection timeout to Gemini API: ' . $e->getMessage());
            return $this->generateFallbackAnalysis($cvText);
        } catch (Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());

            // Provide fallback analysis
            return $this->generateFallbackAnalysis($cvText);
        }
    }

    private function extractAnyTextFromResponse($result)
    {
        $text = '';

        // Try to find text anywhere in the response
        if (isset($result['candidates'])) {
            foreach ($result['candidates'] as $candidate) {
                if (isset($candidate['content']['parts'])) {
                    foreach ($candidate['content']['parts'] as $part) {
                        if (isset($part['text'])) {
                            $text .= $part['text'] . "\n";
                        }
                    }
                }
            }
        }

        // If still empty, try to JSON encode and search for text
        if (empty($text)) {
            $jsonString = json_encode($result);
            // Extract anything that looks like sentences
            preg_match_all('/[A-Z][^.!?]*[.!?]/', $jsonString, $matches);
            $text = implode(' ', $matches[0]);
        }

        return trim($text);
    }
    private function generateFallbackAnalysis($cvText)
    {
        // Generate a simple analysis when API fails
        $wordCount = str_word_count($cvText);
        $lines = explode("\n", $cvText);
        $hasEmail = preg_match('/\S+@\S+\.\S+/', $cvText);
        $hasPhone = preg_match('/[\d\s\+\-\(\)]{7,}/', $cvText);

        // Calculate a basic rating
        $rating = 5; // Base

        if ($wordCount > 200) $rating += 1;
        if ($hasEmail) $rating += 1;
        if ($hasPhone) $rating += 1;
        if (str_contains($cvText, 'experience') || str_contains($cvText, 'Experience')) $rating += 1;
        if (str_contains($cvText, 'education') || str_contains($cvText, 'Education')) $rating += 1;

        $rating = min(max($rating, 1), 10);

        return [
            'rating' => $rating,
            'strengths' => array_filter([
                $wordCount > 200 ? 'Good amount of content (' . $wordCount . ' words)' : null,
                $hasEmail ? 'Includes professional email address' : null,
                $hasPhone ? 'Includes contact phone number' : null,
                'Text successfully extracted for analysis'
            ]),
            'improvements' => [
                'For detailed AI analysis, please ensure stable internet connection',
                'Consider reducing file size if experiencing timeout issues',
                'Make sure your CV has clear section headings'
            ],
            'structure_feedback' => 'Basic text structure detected. For comprehensive formatting feedback, please retry when API connectivity is stable.',
            'content_feedback' => 'Content extracted successfully. Full AI-powered analysis requires stable connection to Google Gemini API.',
            'recommendations' => [
                'Retry analysis with stable internet connection',
                'Ensure CV has clear contact information',
                'Include quantifiable achievements where possible'
            ],
            'is_fallback' => true,
            'note' => 'Note: This is a basic analysis due to API connectivity issues.'
        ];
    }

    private function buildAnalysisPrompt($cvText)
    {
        // Clean and limit the CV text
        $cvText = htmlspecialchars($cvText, ENT_QUOTES, 'UTF-8');
        $cvText = substr($cvText, 0, 4000); // Strict limit for API

        return <<<PROMPT
Analyze this CV and provide feedback in this EXACT format:

CV Content:
{$cvText}

RATING: [number 1-10]

STRENGTHS:
- [strength 1]
- [strength 2]

AREAS FOR IMPROVEMENT:
- [improvement 1]
- [improvement 2]

STRUCTURE FEEDBACK:
[2 sentences max]

CONTENT FEEDBACK:
[2 sentences max]

RECOMMENDATIONS:
- [recommendation 1]
- [recommendation 2]

Only output in the above format, nothing else.
PROMPT;
    }

    private function parseGeminiResponse($text)
    {
        Log::info('Parsing Gemini response', ['response_length' => strlen($text)]);

        // Initialize default structure
        $analysis = [
            'rating' => 0,
            'strengths' => [],
            'improvements' => [],
            'structure_feedback' => '',
            'content_feedback' => '',
            'recommendations' => [],
            'raw_response' => $text
        ];

        try {
            // Extract rating
            if (preg_match('/RATING:\s*(\d+(?:\.\d+)?)/i', $text, $matches)) {
                $analysis['rating'] = (float) $matches[1];
            } elseif (preg_match('/Rating:\s*(\d+)/i', $text, $matches)) {
                $analysis['rating'] = (int) $matches[1];
            } elseif (preg_match('/(\d+)\s*\/\s*10/i', $text, $matches)) {
                $analysis['rating'] = (int) $matches[1];
            }

            // Extract strengths
            if (preg_match('/STRENGTHS:(.*?)(?=AREAS FOR IMPROVEMENT:|IMPROVEMENTS:|WEAKNESSES:|STRUCTURE FEEDBACK:|$)/is', $text, $matches)) {
                $analysis['strengths'] = $this->extractBulletPoints($matches[1]);
            }

            // Extract improvements
            if (preg_match('/(?:AREAS FOR IMPROVEMENT|IMPROVEMENTS|WEAKNESSES):(.*?)(?=STRUCTURE FEEDBACK:|CONTENT FEEDBACK:|RECOMMENDATIONS:|$)/is', $text, $matches)) {
                $analysis['improvements'] = $this->extractBulletPoints($matches[1]);
            }

            // Extract structure feedback
            if (preg_match('/STRUCTURE FEEDBACK:(.*?)(?=CONTENT FEEDBACK:|RECOMMENDATIONS:|$)/is', $text, $matches)) {
                $analysis['structure_feedback'] = trim(preg_replace('/\s+/', ' ', $matches[1]));
            }

            // Extract content feedback
            if (preg_match('/CONTENT FEEDBACK:(.*?)(?=RECOMMENDATIONS:|$)/is', $text, $matches)) {
                $analysis['content_feedback'] = trim(preg_replace('/\s+/', ' ', $matches[1]));
            }

            // Extract recommendations
            if (preg_match('/RECOMMENDATIONS:(.*?)$/is', $text, $matches)) {
                $analysis['recommendations'] = $this->extractBulletPoints($matches[1]);
            }

            // Clean up arrays
            $analysis['strengths'] = array_values(array_filter($analysis['strengths'], function ($item) {
                return !empty(trim($item));
            }));

            $analysis['improvements'] = array_values(array_filter($analysis['improvements'], function ($item) {
                return !empty(trim($item));
            }));

            $analysis['recommendations'] = array_values(array_filter($analysis['recommendations'], function ($item) {
                return !empty(trim($item));
            }));

            Log::info('Parsed analysis', [
                'rating' => $analysis['rating'],
                'strengths_count' => count($analysis['strengths']),
                'improvements_count' => count($analysis['improvements']),
                'recommendations_count' => count($analysis['recommendations'])
            ]);
        } catch (Exception $e) {
            Log::error('Response Parsing Error: ' . $e->getMessage());
            // Return what we have
        }

        return $analysis;
    }

    private function extractBulletPoints($text)
    {
        $points = [];
        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Match bullet points
            if (preg_match('/^[\-\*•]\s*(.+)$/u', $line, $matches)) {
                $points[] = trim($matches[1]);
            } elseif (preg_match('/^\d+[\.\)]\s*(.+)$/', $line, $matches)) {
                $points[] = trim($matches[1]);
            } elseif (strlen($line) > 10 && !preg_match('/^[A-Z\s]+:$/', $line)) {
                // Add as point if it looks like content
                $points[] = $line;
            }
        }

        return array_values(array_unique(array_filter($points, function ($point) {
            return !empty(trim($point)) && strlen(trim($point)) > 3;
        })));
    }

    // Add this method for debugging
    public function testConnection(Request $request)
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API key not configured'], 400);
        }

        try {
            // Simple test request
            $response = Http::timeout(10)
                ->post(
                    "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => 'Say "Hello World"']
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'maxOutputTokens' => 10,
                        ]
                    ]
                );

            return response()->json([
                'success' => $response->successful(),
                'status' => $response->status(),
                'response' => $response->successful() ? $response->json() : $response->body(),
                'api_key_length' => strlen($apiKey),
                'endpoint' => 'gemini-2.5-flash'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'type' => get_class($e)
            ], 500);
        }
    }
}
