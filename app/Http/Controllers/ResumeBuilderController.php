<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumeBuilderController extends Controller
{

    public function generate(Request $request)
    {
        $data = $request->except(['selected_template', '_token']);
        $template = $request->input('selected_template', 'modern');

        $name = trim(($data['firstName'] ?? '') . ' ' . ($data['lastName'] ?? ''));
        $email = $data['email'] ?? '';
        $phone = $data['phone'] ?? '';
        $city = $data['city'] ?? 'Bangladesh';

        if (!$name || !$email) {
            return back()->with('error', 'Name and email are required.');
        }

        // ─────────────────────────────────────
        // Build EDUCATION
        // ─────────────────────────────────────
        $education = [];

        if (!empty($data['degree']) || !empty($data['university'])) {
            $education[] = [
                'level'  => 'Undergraduate',
                'degree' => $data['degree'] ?? null,
                'school' => $data['university'] ?? null,
                'major'  => $data['major'] ?? null,
                'cgpa'   => $data['cgpa'] ?? null,
                'year'   => $data['graduationYear'] ?? null,
            ];
        }

        if (!empty($data['hsc_college'])) {
            $education[] = [
                'level'  => 'HSC / A-Level',
                'school' => $data['hsc_college'],
                'year'   => $data['hsc_year'] ?? $data['graduationYear'] ?? null,
                'grade'  => $data['hsc_grade'] ?? null,
            ];
        }

        if (!empty($data['ssc_school'])) {
            $education[] = [
                'level'  => 'SSC / O-Level',
                'school' => $data['ssc_school'],
                'year'   => $data['ssc_year'] ?? null,
                'grade'  => $data['ssc_grade'] ?? null,
            ];
        }

        if (empty($education)) {
            $education[] = [
                'level'  => 'Education',
                'degree' => $data['degree'] ?? 'Student',
                'school' => $data['university'] ?? 'Not Provided',
                'year'   => $data['graduationYear'] ?? null,
            ];
        }

        // ─────────────────────────────────────
        // EXPERIENCE
        // ─────────────────────────────────────
        $experience = [];
        if (!empty($data['jobTitle']) || !empty($data['company'])) {
            $responsibilities = !empty($data['responsibilities'])
                ? array_filter(explode("\n", trim($data['responsibilities'])))
                : [];

            $experience[] = [
                'title'           => $data['jobTitle'] ?? '',
                'company'         => $data['company'] ?? '',
                'duration'        => $data['duration'] ?? '',
                'responsibilities' => $responsibilities
            ];
        }

        // ─────────────────────────────────────
        // EXTRACT SKILLS
        // ─────────────────────────────────────
        $technical = !empty($data['technicalSkills'])
            ? array_map('trim', explode(',', $data['technicalSkills']))
            : [];

        $soft = !empty($data['softSkills'])
            ? array_map('trim', explode(',', $data['softSkills']))
            : [];

        $languages = !empty($data['languages'])
            ? array_map('trim', explode(',', $data['languages']))
            : [];

        // ─────────────────────────────────────
        // BUILD PROMPT FOR GEMINI
        // ─────────────────────────────────────
        $prompt = <<<PROMPT
Generate a professional summary (2-3 sentences) for a resume for:
Name: {$name}
Education: {$data['degree']} from {$data['university']}
Skills: {$data['technicalSkills']}

Just return the summary text, nothing else.
PROMPT;

        try {
            $response = Http::timeout(90)->post(
                'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
                [
                    'contents' => [['role' => 'user', 'parts' => [['text' => $prompt]]]]
                ]
            );

            if ($response->failed()) {
                \Log::error('Gemini failed', ['response' => $response->body()]);
                $summary = 'Professional with strong background in ' . ($data['technicalSkills'] ?? 'technology') . '.';
            } else {
                $raw = $response->json('candidates.0.content.parts.0.text', '');
                $summary = trim($raw) ?: 'Professional with strong background in ' . ($data['technicalSkills'] ?? 'technology') . '.';
            }

            $resume = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'city' => $city,
                'summary' => $summary,
                'education' => $education,
                'experience' => $experience,
                'skills' => [
                    'technical' => $technical,
                    'soft' => $soft,
                    'languages' => $languages,
                ]
            ];

            session([
                'resume'   => $resume,
                'template' => $template
            ]);

            session()->forget(['form_data', 'current_page', 'current_section', 'current_step', 'selected_option']);

            return redirect()->route('resume.show', ['template' => $template]);
        } catch (\Exception $e) {
            \Log::error('Generate error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong. Please try again.');
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
                ->with('error', 'No resume available to download.');
        }

        try {
            $html = view("resume.$template", compact('resume'))->render();

            $pdf = Pdf::loadHTML($html)
                ->setPaper('a4', 'portrait')
                ->setOption('margin-top', 0)
                ->setOption('margin-bottom', 0)
                ->setOption('margin-left', 0)
                ->setOption('margin-right', 0)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('defaultFont', 'Inter');

            $fileName = 'resume_' . date('Y-m-d') . '.pdf';
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            \Log::error('PDF generation error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to generate PDF.');
        }
    }
}
