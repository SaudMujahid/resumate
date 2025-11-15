<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumeBuilderController extends Controller
{
public function generate(Request $request)
{
    // Get all form data except template
    $formData = $request->except('selected_template', '_token');
    $template = $request->input('selected_template', 'modern');

    // Validate that we have at least some data
    if (empty($formData)) {
        return redirect()->route('resumebuilder')
            ->with('error', 'No data provided. Please fill out the form.');
    }

    // ---------- AI PROMPT ----------
    $prompt = "Generate a **professional resume** in **valid JSON only**. Use this data:\n"
            . json_encode($formData, JSON_PRETTY_PRINT)
            . "\n\nReturn **only** valid JSON with these exact keys:\n"
            . "- name (string): full name\n"
            . "- email (string)\n"
            . "- phone (string)\n"
            . "- city (string)\n"
            . "- summary (string): 2-3 sentence professional summary\n"
            . "- education (array): [{degree, school, year, major}]\n"
            . "- experience (array): [{title, company, duration, responsibilities: [array of strings]}]\n"
            . "- skills (object): {technical: [array], soft: [array], languages: [array]}\n\n"
            . "IMPORTANT: Return ONLY the JSON object, no markdown, no explanations.";

    try {
        $response = Http::timeout(60)->post(
            'https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key='
            . env('GEMINI_API_KEY'),
            ['contents' => [['role' => 'user', 'parts' => [['text' => $prompt]]]]]
        );

        if ($response->failed()) {
            \Log::error('Gemini API failed', ['status' => $response->status(), 'body' => $response->body()]);
            return redirect()->route('resumebuilder')
                ->with('error', 'AI service is currently unavailable. Please try again.');
        }

        $text = $response->json('candidates.0.content.parts.0.text', '');

        // Clean up the response - remove markdown code blocks if present
        $json = preg_replace('/^```json\s*|```$/m', '', trim($text));
        $json = preg_replace('/^```\s*|```$/m', '', $json);

        $resume = json_decode($json, true);

        if (!$resume || json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('AI JSON parse error', [
                'raw' => $text,
                'cleaned' => $json,
                'error' => json_last_error_msg()
            ]);
            return redirect()->route('resumebuilder')
                ->with('error', 'Could not process AI response. Please try again.');
        }

        // Validate required fields
        if (empty($resume['name']) || empty($resume['email'])) {
            \Log::error('Missing required fields in resume', ['resume' => $resume]);
            return redirect()->route('resumebuilder')
                ->with('error', 'Generated resume is incomplete. Please try again.');
        }

        // Store resume and template in session
        session([
            'resume' => $resume,
            'template' => $template
        ]);

        // Clear builder session data
        session()->forget([
            'form_data',
            'current_page',
            'current_section',
            'current_step',
            'selected_option',
            'selected_template'
        ]);

        return redirect()->route('resume.show', ['template' => $template]);

    } catch (\Exception $e) {
        \Log::error('Resume generation exception', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->route('resumebuilder')
            ->with('error', 'An error occurred while generating your resume. Please try again.');
    }
}
    public function show($template)
    {
        $resume = session('resume');

        if (!$resume) {
            return redirect()->route('resumebuilder')
                ->with('error', 'No resume data found. Please create a resume first.');
        }

        $validTemplates = ['modern', 'chronological', 'minimal'];
        $template = in_array($template, $validTemplates) ? $template : 'modern';

        // Keep resume in session for potential PDF download
        return view("resume.$template", compact('resume'));
    }

    public function downloadPDF(Request $request)
    {
        $resume = session('resume');
        $template = session('template', 'modern');

        if (!$resume) {
            return redirect()->route('resumebuilder')
                ->with('error', 'No resume available to download. Please create one first.');
        }

        try {
            $html = view("resume.$template", compact('resume'))->render();
            $pdf = Pdf::loadHTML($html)
                ->setPaper('a4')
                ->setOption('margin-top', 10)
                ->setOption('margin-bottom', 10)
                ->setOption('margin-left', 10)
                ->setOption('margin-right', 10);

            $fileName = 'resume_' . date('Y-m-d') . '.pdf';
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            \Log::error('PDF generation error', ['message' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Failed to generate PDF. Please try again.');
        }
    }
}
