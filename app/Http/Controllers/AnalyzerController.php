<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory;
use Exception;

class AnalyzerController extends Controller
{
    public function index()
    {
        return view('analyzer');
    }

    // THIS IS THE METHOD THAT CHANGES
    public function analyze(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        try {
            $file = $request->file('cv_file');
            $extension = $file->getClientOriginalExtension();

            // Extract text based on file type
            $cvText = $this->extractText($file, $extension);

            if (empty($cvText)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not extract text from the CV. Please ensure the file contains readable text.'
                ], 400);
            }

            $analysis = $this->analyzeWithGemini($cvText);

            // CHANGE 1: Store analysis in session
            // This creates a unique key and stores the analysis data
            $resultId = uniqid('result_', true);
            session(["analysis_{$resultId}" => $analysis]);

            // CHANGE 2: Return JSON with redirect URL instead of analysis data
            // The frontend JavaScript receives this and redirects the user
            return response()->json([
                'success' => true,
                'redirect' => route('analyzer.results', ['id' => $resultId])
                // Example: returns "/analyzer/results/result_6758e2c4c67bd1.23456789"
            ]);
        } catch (Exception $e) {
            Log::error('CV Analysis Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while analyzing your CV. Please try again.'
            ], 500);
        }
    }

    // NEW METHOD: Add this to handle the results page
    public function results($id)
    {
        // STEP 1: Retrieve analysis from session using the ID
        $analysis = session("analysis_{$id}");

        // STEP 2: If analysis doesn't exist, show 404 error
        // This prevents people from accessing invalid URLs
        if (!$analysis) {
            abort(404, 'Analysis not found');
        }

        // STEP 3: Return the results view with the analysis data
        // The view receives the $analysis array and displays it
        return view('analyzer.results', ['analysis' => $analysis, 'id' => $id]);
    }

    private function extractText($file, $extension)
    {
        $text = '';

        try {
            if ($extension === 'pdf') {
                $parser = new PdfParser();
                $pdf = $parser->parseFile($file->getPathname());
                $text = $pdf->getText();
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $phpWord = IOFactory::load($file->getPathname());
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . "\n";
                        } elseif (method_exists($element, 'getElements')) {
                            foreach ($element->getElements() as $childElement) {
                                if (method_exists($childElement, 'getText')) {
                                    $text .= $childElement->getText() . "\n";
                                }
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            Log::error('Text Extraction Error: ' . $e->getMessage());
            throw $e;
        }

        return trim($text);
    }

    private function analyzeWithGemini(string $cvText): array
    {
        $apiKey = config('services.gemini.key');

        if (!$apiKey) {
            throw new Exception('GEMINI_API_KEY not configured in .env file');
        }

        $prompt = $this->buildAnalysisPrompt($cvText);

        try {
            $response = Http::timeout(60)->post(
                "https://generativelanguage.googleapis.com/v1/models/gemini-3.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 2048,
                    ],
                ]
            );

            if ($response->failed()) {
                $body = $response->json();
                $msg = $body['error']['message'] ?? $response->body();
                Log::error('Gemini API failed', ['response' => $msg]);

                throw new Exception('Service temporarily unavailable. Please try again later.');
            }

            $generatedText = $this->extractGeneratedText($response->json());

            if (empty($generatedText)) {
                $finishReason = $response->json('candidates.0.finishReason');
                Log::error('Gemini empty content', [
                    'finishReason' => $finishReason,
                    'response'     => $response->json(),
                ]);
                throw new Exception('Gemini returned an empty response.');
            }

            return $this->parseGeminiResponse($generatedText);
        } catch (Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            throw $e;
        }
    }
    private function buildAnalysisPrompt($cvText)
    {
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

Consider these aspects in your analysis:
1. Overall structure and formatting
2. Clarity and conciseness
3. Relevant skills and experiences
4. Achievement quantification
5. Professional summary/objective
6. Education and certifications
7. Keywords for ATS (Applicant Tracking Systems)
8. Grammar and spelling
9. Contact information completeness
10. Tailoring to target roles

Be specific, constructive, and actionable in your feedback.
PROMPT;
    }

    private function extractGeneratedText(?array $result): string
    {
        if (empty($result['candidates'][0]['content']['parts'])) {
            return '';
        }

        $text = '';
        foreach ($result['candidates'][0]['content']['parts'] as $part) {
            if (!empty($part['text'])) {
                $text .= $part['text'];
            }
        }

        return trim($text);
    }

    private function normalizeGeminiText(string $text): string
    {
        // Strip markdown bold/italic and heading markers so section regexes match reliably
        $text = preg_replace('/\*\*([^*]+)\*\*/', '$1', $text);
        $text = preg_replace('/\*([^*]+)\*/', '$1', $text);
        $text = preg_replace('/^#+\s*/m', '', $text);

        return $text;
    }

    private function parseGeminiResponse(string $text): array
    {
        $analysis = [
            'rating'              => 0,
            'strengths'           => [],
            'improvements'        => [],
            'structure_feedback'  => '',
            'content_feedback'    => '',
            'recommendations'     => [],
        ];

        $text = $this->normalizeGeminiText($text);

        try {
            if (preg_match('/RATING:\s*(\d+)(?:\s*\/\s*10)?/i', $text, $matches)) {
                $analysis['rating'] = min(10, max(1, (int) $matches[1]));
            }

            if (preg_match('/STRENGTHS:\s*(.*?)(?=\n\s*(?:AREAS FOR IMPROVEMENT|IMPROVEMENTS|WEAKNESSES):|$)/is', $text, $matches)) {
                $analysis['strengths'] = $this->extractBulletPoints($matches[1]);
            }

            if (preg_match('/(?:AREAS FOR IMPROVEMENT|IMPROVEMENTS|WEAKNESSES):\s*(.*?)(?=\n\s*STRUCTURE FEEDBACK:|$)/is', $text, $matches)) {
                $analysis['improvements'] = $this->extractBulletPoints($matches[1]);
            }

            if (preg_match('/STRUCTURE FEEDBACK:\s*(.*?)(?=\n\s*CONTENT FEEDBACK:|$)/is', $text, $matches)) {
                $analysis['structure_feedback'] = $this->cleanParagraph($matches[1]);
            }

            if (preg_match('/CONTENT FEEDBACK:\s*(.*?)(?=\n\s*RECOMMENDATIONS:|$)/is', $text, $matches)) {
                $analysis['content_feedback'] = $this->cleanParagraph($matches[1]);
            }

            if (preg_match('/RECOMMENDATIONS:\s*(.*?)$/is', $text, $matches)) {
                $analysis['recommendations'] = $this->extractBulletPoints($matches[1]);
            }

            if ($analysis['rating'] === 0 && $analysis['strengths'] === [] && $analysis['structure_feedback'] === '') {
                Log::warning('Gemini response did not match expected format', [
                    'preview' => substr($text, 0, 500),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Response Parsing Error: ' . $e->getMessage());
        }

        return $analysis;
    }

    private function cleanParagraph(string $text): string
    {
        $text = trim(preg_replace('/\s+/', ' ', $text));

        return trim($text, '* ');
    }

    private function extractBulletPoints(string $text): array
    {
        $points = [];

        foreach (explode("\n", $text) as $line) {
            $line = trim($line);
            if ($line === '' || $line === '*' || preg_match('/^\*+$/', $line)) {
                continue;
            }

            if (preg_match('/^[-•*]\s+(.+)$/', $line, $matches)) {
                $point = trim($matches[1], '* ');
                if ($point !== '') {
                    $points[] = $point;
                }
                continue;
            }

            if (preg_match('/^\d+[.)]\s+(.+)$/', $line, $matches)) {
                $points[] = trim($matches[1]);
            }
        }

        return $points;
    }
}
