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
                // Try multiple methods for PDF parsing
                $text = $this->extractPdfText($contents);
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $text = $this->extractWordText($contents, $extension);
            }

            Log::info('Extracted text stats', [
                'text_length' => strlen($text),
                'is_empty' => empty(trim($text))
            ]);
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
            // Method 1: Using Smalot PDF Parser (simplified)
            $parser = new PdfParser();

            // Try parseContent first
            try {
                $pdf = $parser->parseContent($contents);
                $text = $pdf->getText();
                Log::info('PDF parsed successfully using parseContent');
            } catch (\Exception $e) {
                Log::warning('parseContent failed, trying parseFile: ' . $e->getMessage());

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

            // If still empty, try a different approach
            if (empty(trim($text))) {
                Log::warning('PDF text appears empty after parsing');
                $text = $this->fallbackPdfExtraction($contents);
            }
        } catch (\Exception $e) {
            Log::error('PDF extraction failed: ' . $e->getMessage());
            // Try fallback before throwing
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

        // Remove non-printable characters (keep basic punctuation and symbols)
        $text = preg_replace('/[^\x20-\x7E\x0A\x0D\xC2\xA0-\xEF\xBF\xBD]/u', ' ', $text);

        // Fix common encoding issues
        $text = str_replace(['�', '�', '�'], ['', '', ''], $text);

        return trim($text);
    }

    private function fallbackPdfExtraction($contents)
    {
        $text = '';

        Log::info('Trying fallback PDF extraction');

        try {
            // Simple regex to extract text between parentheses, brackets, or after common PDF commands
            if (preg_match_all('/(?<=\(|\[|\/Text\s*)([^\)\]]+)(?=\)|\]|TJ)/', $contents, $matches)) {
                $text = implode(' ', $matches[1]);
            }

            // If that doesn't work, try to extract ASCII text
            if (empty($text)) {
                // Extract printable ASCII characters
                $text = preg_replace('/[^\x20-\x7E\n\r\t]/', ' ', $contents);
                $text = preg_replace('/\s+/', ' ', $text);
            }
        } catch (\Exception $e) {
            Log::error('Fallback extraction failed: ' . $e->getMessage());
        }

        return trim($text);
    }

    private function extractWordText($contents, $extension)
    {
        $text = '';

        // Create a temporary file
        $tempPath = tempnam(sys_get_temp_dir(), 'cv_') . '.' . $extension;
        file_put_contents($tempPath, $contents);

        Log::info('Word temp file created', ['path' => $tempPath]);

        try {
            if ($extension === 'docx') {
                // For .docx files (Office Open XML format)
                $text = $this->extractDocxText($tempPath);
            } elseif ($extension === 'doc') {
                // For .doc files (older binary format)
                $text = $this->extractDocText($tempPath);
            }
        } catch (\Exception $e) {
            Log::error('Word extraction failed: ' . $e->getMessage());
            throw $e;
        } finally {
            // Always clean up
            if (file_exists($tempPath)) {
                unlink($tempPath);
                Log::info('Word temp file cleaned up');
            }
        }

        return $text;
    }

    private function extractDocxText($filePath)
    {
        $text = '';

        try {
            // Method 1: Use PhpWord
            $phpWord = IOFactory::load($filePath);

            // Extract text from all sections
            foreach ($phpWord->getSections() as $section) {
                $elements = $section->getElements();
                foreach ($elements as $element) {
                    // Handle different element types
                    if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                        foreach ($element->getElements() as $textElement) {
                            if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                $text .= $textElement->getText() . ' ';
                            }
                        }
                        $text .= "\n";
                    } elseif ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                        $text .= $element->getText() . "\n";
                    } elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                        foreach ($element->getRows() as $row) {
                            foreach ($row->getCells() as $cell) {
                                $text .= $this->extractTextFromCell($cell) . "\t";
                            }
                            $text .= "\n";
                        }
                    }
                }
            }

            Log::info('PhpWord extraction completed', ['length' => strlen($text)]);

            // If PhpWord fails, try alternative method
            if (empty(trim($text))) {
                $text = $this->extractDocxViaZip($filePath);
            }
        } catch (\Exception $e) {
            Log::warning('PhpWord failed, trying alternative: ' . $e->getMessage());
            $text = $this->extractDocxViaZip($filePath);
        }

        return $this->cleanText($text);
    }

    private function extractTextFromCell($cell)
    {
        $cellText = '';
        foreach ($cell->getElements() as $element) {
            if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                foreach ($element->getElements() as $textElement) {
                    if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                        $cellText .= $textElement->getText();
                    }
                }
            } elseif ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                $cellText .= $element->getText();
            }
        }
        return $cellText;
    }

    private function extractDocxViaZip($filePath)
    {
        $text = '';

        try {
            // .docx is a ZIP archive containing XML files
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === true) {
                // Get the main document XML
                if (($index = $zip->locateName('word/document.xml')) !== false) {
                    $documentXml = $zip->getFromIndex($index);

                    // Extract text from XML
                    $text = strip_tags($documentXml);

                    // Decode XML entities
                    $text = html_entity_decode($text, ENT_QUOTES | ENT_XML1, 'UTF-8');

                    // Clean up
                    $text = preg_replace('/\s+/', ' ', $text);
                }

                // Also try to get other parts if main document is empty
                if (empty(trim($text))) {
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $filename = $zip->getNameIndex($i);
                        if (str_ends_with($filename, '.xml') || str_ends_with($filename, '.rels')) {
                            $content = $zip->getFromIndex($i);
                            $cleaned = strip_tags($content);
                            $cleaned = html_entity_decode($cleaned, ENT_QUOTES | ENT_XML1, 'UTF-8');
                            $text .= ' ' . $cleaned;
                        }
                    }
                }

                $zip->close();
                Log::info('DOCX extracted via ZIP', ['length' => strlen($text)]);
            }
        } catch (\Exception $e) {
            Log::error('ZIP extraction failed: ' . $e->getMessage());
        }

        return $text;
    }

    private function extractDocText($filePath)
    {
        // For .doc files, we need a different approach
        // This is a simplified version - .doc parsing is complex

        Log::warning('.doc file format detected - limited support');

        // Try to use antiword if available on system
        if (function_exists('shell_exec') && `which antiword`) {
            $text = shell_exec("antiword " . escapeshellarg($filePath) . " 2>/dev/null");
            if ($text) {
                return $this->cleanText($text);
            }
        }

        // Fallback: Try to read as binary and extract strings
        $content = file_get_contents($filePath);

        // Extract sequences of printable characters
        preg_match_all('/[A-Za-z0-9\s\.\,\-\+\=\*\/\(\)\[\]\{\}\@\#\$\%\^\&\*\!\?\'\"\:\;]{4,}/', $content, $matches);

        $text = implode(' ', $matches[0]);

        return $this->cleanText($text);
    }

    private function analyzeWithGemini($cvText)
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            throw new Exception('GEMINI_API_KEY not configured in .env file');
        }

        // Truncate CV text if too long (Gemini has token limits)
        $maxLength = 15000; // Keep it reasonable
        if (strlen($cvText) > $maxLength) {
            $cvText = substr($cvText, 0, $maxLength) . '... [TRUNCATED]';
        }

        $prompt = $this->buildAnalysisPrompt($cvText);

        Log::info('Sending request to Gemini API', [
            'prompt_length' => strlen($prompt),
            'api_key_exists' => !empty($apiKey)
        ]);

        try {
            // Try multiple Gemini endpoints
            $endpoints = [
                "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                "https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key={$apiKey}",
                "https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key={$apiKey}"
            ];

            $response = null;
            $lastError = null;

            foreach ($endpoints as $endpoint) {
                try {
                    Log::info('Trying endpoint: ' . $endpoint);

                    $response = Http::timeout(60)->post($endpoint, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 2048,
                        ]
                    ]);

                    if ($response->successful()) {
                        break;
                    }

                    Log::warning('Endpoint failed', [
                        'endpoint' => $endpoint,
                        'status' => $response->status()
                    ]);
                } catch (\Exception $e) {
                    $lastError = $e;
                    Log::warning('Endpoint error: ' . $e->getMessage());
                }
            }

            if (!$response || !$response->successful()) {
                throw new Exception('All Gemini endpoints failed. Last error: ' . ($lastError ? $lastError->getMessage() : 'Unknown'));
            }

            Log::info('Gemini API Response Status', [
                'status' => $response->status()
            ]);

            $result = $response->json();

            Log::info('Gemini API Response', [
                'has_candidates' => isset($result['candidates']),
                'candidate_count' => count($result['candidates'] ?? [])
            ]);

            // Extract the generated text
            $generatedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

            Log::info('Generated text preview', [
                'length' => strlen($generatedText),
                'preview' => substr($generatedText, 0, 200)
            ]);

            if (empty($generatedText)) {
                throw new Exception('Empty response from Gemini API');
            }

            // Parse the structured response
            return $this->parseGeminiResponse($generatedText);
        } catch (Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            Log::error('API Error trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    private function buildAnalysisPrompt($cvText)
    {
        // Clean and limit the CV text
        $cvText = htmlspecialchars($cvText);
        $cvText = substr($cvText, 0, 10000); // Limit to prevent token overflow

        return <<<PROMPT
You are an expert CV/Resume reviewer with years of experience in recruitment and career counseling. Analyze the following CV and provide detailed, actionable feedback.

CV Content:
{$cvText}

Please analyze this CV and provide your response in the following EXACT format:

RATING: [number from 1-10]

STRENGTHS:
- [strength 1]
- [strength 2]
- [strength 3]

AREAS FOR IMPROVEMENT:
- [improvement 1]
- [improvement 2]
- [improvement 3]

STRUCTURE FEEDBACK:
[2-3 sentences about the overall structure, formatting, and organization]

CONTENT FEEDBACK:
[2-3 sentences about the quality of experiences, skills, and achievements described]

RECOMMENDATIONS:
- [specific recommendation 1]
- [specific recommendation 2]
- [specific recommendation 3]

IMPORTANT: Your entire response must follow this exact format. Do not add any introductory or concluding text.
PROMPT;
    }

    private function parseGeminiResponse($text)
    {
        Log::info('Parsing Gemini response');

        // Initialize default structure
        $analysis = [
            'rating' => 0,
            'strengths' => [],
            'improvements' => [],
            'structure_feedback' => '',
            'content_feedback' => '',
            'recommendations' => [],
            'raw_response' => $text // Keep for debugging
        ];

        try {
            // Extract rating - be flexible with format
            $rating = 0;
            if (preg_match('/RATING:\s*(\d+(?:\.\d+)?)/i', $text, $matches)) {
                $rating = (float) $matches[1];
            } elseif (preg_match('/Rating:\s*(\d+)/i', $text, $matches)) {
                $rating = (int) $matches[1];
            } elseif (preg_match('/(\d+)\s*\/\s*10/i', $text, $matches)) {
                $rating = (int) $matches[1];
            }
            $analysis['rating'] = $rating;

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

            Log::info('Parsed analysis', [
                'rating' => $analysis['rating'],
                'strengths_count' => count($analysis['strengths']),
                'improvements_count' => count($analysis['improvements']),
                'recommendations_count' => count($analysis['recommendations'])
            ]);
        } catch (Exception $e) {
            Log::error('Response Parsing Error: ' . $e->getMessage());
            // Don't throw - return what we have
        }

        return $analysis;
    }

    private function extractBulletPoints($text)
    {
        $points = [];
        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            // Match bullet points with various formats
            if (preg_match('/^[\-\*•‣⁃◦➢⦁]\s*(.+)$/u', $line, $matches)) {
                $points[] = trim($matches[1]);
            } elseif (preg_match('/^\d+[\.\)]\s*(.+)$/', $line, $matches)) {
                $points[] = trim($matches[1]);
            } elseif (!preg_match('/^[A-Z][A-Z\s]+:$/', $line)) {
                // If it looks like a regular sentence (not a section header), add it
                $points[] = $line;
            }
        }

        // Filter out empty or very short points
        $points = array_filter($points, function ($point) {
            $trimmed = trim($point);
            return !empty($trimmed) && strlen($trimmed) > 3;
        });

        return array_values(array_unique($points));
    }

    /**
     * Debug endpoint to test text extraction
     */
    public function debugExtraction(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $file = $request->file('cv_file');
        $extension = $file->getClientOriginalExtension();

        Log::info('Debug extraction called', [
            'filename' => $file->getClientOriginalName(),
            'extension' => $extension
        ]);

        $text = $this->extractText($file, $extension);

        return response()->json([
            'success' => !empty(trim($text)),
            'filename' => $file->getClientOriginalName(),
            'extension' => $extension,
            'text_length' => strlen($text),
            'text_preview' => substr($text, 0, 500),
            'is_empty' => empty(trim($text))
        ]);
    }
}
