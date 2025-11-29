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

            // Analyze with Gemini API
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

    private function analyzeWithGemini($cvText)
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            throw new Exception('GEMINI_API_KEY not configured in .env file');
        }

        $prompt = $this->buildAnalysisPrompt($cvText);

        try {
            $response = Http::timeout(30)->post(
                "https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key={$apiKey}",
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
                        'maxOutputTokens' => 2048,
                    ]
                ]
            );

            if ($response->failed()) {
                throw new Exception('Gemini API request failed: ' . $response->body());
            }

            $result = $response->json();

            // Extract the generated text
            $generatedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Parse the structured response
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

    private function parseGeminiResponse($text)
    {
        // Initialize default structure
        $analysis = [
            'rating' => 0,
            'strengths' => [],
            'improvements' => [],
            'structure_feedback' => '',
            'content_feedback' => '',
            'recommendations' => []
        ];

        try {
            // Extract rating
            if (preg_match('/RATING:\s*(\d+)/i', $text, $matches)) {
                $analysis['rating'] = (int) $matches[1];
            }

            // Extract strengths
            if (preg_match('/STRENGTHS:(.*?)(?=AREAS FOR IMPROVEMENT:|$)/is', $text, $matches)) {
                $analysis['strengths'] = $this->extractBulletPoints($matches[1]);
            }

            // Extract improvements
            if (preg_match('/AREAS FOR IMPROVEMENT:(.*?)(?=STRUCTURE FEEDBACK:|$)/is', $text, $matches)) {
                $analysis['improvements'] = $this->extractBulletPoints($matches[1]);
            }

            // Extract structure feedback
            if (preg_match('/STRUCTURE FEEDBACK:(.*?)(?=CONTENT FEEDBACK:|$)/is', $text, $matches)) {
                $analysis['structure_feedback'] = trim($matches[1]);
            }

            // Extract content feedback
            if (preg_match('/CONTENT FEEDBACK:(.*?)(?=RECOMMENDATIONS:|$)/is', $text, $matches)) {
                $analysis['content_feedback'] = trim($matches[1]);
            }

            // Extract recommendations
            if (preg_match('/RECOMMENDATIONS:(.*?)$/is', $text, $matches)) {
                $analysis['recommendations'] = $this->extractBulletPoints($matches[1]);
            }
        } catch (Exception $e) {
            Log::error('Response Parsing Error: ' . $e->getMessage());
        }

        return $analysis;
    }

    private function extractBulletPoints($text)
    {
        $points = [];
        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $line = trim($line);
            // Match lines starting with -, *, or numbers
            if (preg_match('/^[-*\d.]+\s*(.+)$/', $line, $matches)) {
                $points[] = trim($matches[1]);
            }
        }

        return $points;
    }
}
