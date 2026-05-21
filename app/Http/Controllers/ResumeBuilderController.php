<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class ResumeBuilderController extends Controller
{
    // ── Single source of truth for all sections & fields ──────────────────
    private function sections(): array
    {
        return [
            [
                'id'     => 'personal',
                'name'   => 'Personal Info',
                'desc'   => 'Your basic contact details',
                'color'  => 'from-[#F2E9FF] to-[#FFE9F5]',
                'fields' => [
                    ['id' => 'firstName', 'label' => 'First Name',     'type' => 'text',  'placeholder' => 'John',             'required' => true,  'span' => 1, 'ai' => false],
                    ['id' => 'lastName',  'label' => 'Last Name',      'type' => 'text',  'placeholder' => 'Doe',              'required' => false, 'span' => 1, 'ai' => false],
                    ['id' => 'email',     'label' => 'Email Address',  'type' => 'email', 'placeholder' => 'john@example.com', 'required' => true,  'span' => 1, 'ai' => false],
                    ['id' => 'phone',     'label' => 'Phone Number',   'type' => 'tel',   'placeholder' => '01712345678',      'required' => false, 'span' => 1, 'ai' => false],
                    ['id' => 'city',      'label' => 'City / Location','type' => 'text',  'placeholder' => 'Dhaka, Remote',    'required' => false, 'span' => 2, 'ai' => false],
                ],
            ],
            [
                'id'     => 'education',
                'name'   => 'Education',
                'desc'   => 'Academic background',
                'color'  => 'from-[#FFE9D1] to-[#FFF5E9]',
                'fields' => [
                    ['id' => 'degree',         'label' => 'Highest Degree',         'type' => 'text', 'placeholder' => 'B.Sc. Computer Science',    'required' => true,  'span' => 1, 'ai' => false],
                    ['id' => 'university',     'label' => 'University / College',   'type' => 'text', 'placeholder' => 'University of Dhaka',        'required' => true,  'span' => 1, 'ai' => false],
                    ['id' => 'graduationYear', 'label' => 'Graduation Year',        'type' => 'text', 'placeholder' => '2024',                       'required' => true,  'span' => 1, 'ai' => false],
                    ['id' => 'major',          'label' => 'Major / Subject',        'type' => 'text', 'placeholder' => 'Computer Science',            'required' => false, 'span' => 1, 'ai' => false],
                    ['id' => 'cgpa',           'label' => 'CGPA / Grade',           'type' => 'text', 'placeholder' => '3.85 / 4.00',                'required' => false, 'span' => 2, 'ai' => false],
                    ['id' => '_sep',           'type' => 'separator', 'label' => 'Earlier Education', 'span' => 2, 'ai' => false],
                    ['id' => 'ssc_school',     'label' => 'Secondary School (SSC / O-Level)', 'type' => 'text', 'placeholder' => 'Scholastica, Viqarunnisa', 'required' => false, 'span' => 1, 'ai' => false],
                    ['id' => 'ssc_grade',      'label' => 'SSC Result',             'type' => 'text', 'placeholder' => 'GPA 5.00  /  9 A*',          'required' => false, 'span' => 1, 'ai' => false],
                    ['id' => 'hsc_college',    'label' => 'Higher Secondary (HSC / A-Level)', 'type' => 'text', 'placeholder' => 'Notre Dame, Hurdco', 'required' => false, 'span' => 1, 'ai' => false],
                    ['id' => 'hsc_grade',      'label' => 'HSC Result',             'type' => 'text', 'placeholder' => 'GPA 5.00  /  3 A* 1 A',      'required' => false, 'span' => 1, 'ai' => false],
                ],
            ],
            [
                'id'     => 'experience',
                'name'   => 'Experience',
                'desc'   => 'Work history — AI can expand your bullets',
                'color'  => 'from-[#E9F5FF] to-[#F0F9FF]',
                'fields' => [
                    ['id' => 'jobTitle',         'label' => 'Job Title',        'type' => 'text',     'placeholder' => 'Software Engineer, Intern',       'required' => false, 'span' => 1, 'ai' => 'title'],
                    ['id' => 'company',          'label' => 'Company',          'type' => 'text',     'placeholder' => 'bKash, Daraz, Freelance',          'required' => false, 'span' => 1, 'ai' => false],
                    ['id' => 'duration',         'label' => 'Duration',         'type' => 'text',     'placeholder' => '2022 – Present  /  2 years',       'required' => false, 'span' => 2, 'ai' => false],
                    ['id' => 'responsibilities', 'label' => 'Key Achievements', 'type' => 'textarea', 'placeholder' => "• Built features used by 100K+ users\n• Reduced load time by 40%", 'required' => false, 'span' => 2, 'rows' => 5, 'ai' => 'responsibilities'],
                ],
            ],
            [
                'id'     => 'skills',
                'name'   => 'Skills',
                'desc'   => 'AI can suggest related skills and ATS keywords',
                'color'  => 'from-[#E9FFE9] to-[#F0FFF0]',
                'fields' => [
                    ['id' => 'technicalSkills', 'label' => 'Technical Skills', 'type' => 'text', 'placeholder' => 'JavaScript, Python, Laravel, MySQL, Figma', 'required' => false, 'span' => 2, 'ai' => 'skills'],
                    ['id' => 'softSkills',      'label' => 'Soft Skills',      'type' => 'text', 'placeholder' => 'Leadership, Communication, Teamwork',        'required' => false, 'span' => 1, 'ai' => false],
                    ['id' => 'languages',       'label' => 'Languages',        'type' => 'text', 'placeholder' => 'Bangla (Native), English (Fluent)',           'required' => false, 'span' => 1, 'ai' => false],
                ],
            ],
        ];
    }

    // ── Display builder ───────────────────────────────────────────────────
    public function index(Request $request)
    {
        if ($request->filled('template')) {
            session(['selected_template' => $request->query('template')]);
        }

        return view('resumebuilder', [
            'sections'         => $this->sections(),
            'currentPage'      => session('current_page', 'choice'),
            'currentSection'   => (int) session('current_section', 0),
            'formData'         => session('form_data', []),
            'selectedTemplate' => session('selected_template', 'modern'),
            'selectedOption'   => session('selected_option', null),
        ]);
    }

    // ── Navigation (POST) ─────────────────────────────────────────────────
    public function navigate(Request $request)
    {
        $action   = $request->input('action');
        $section  = (int) $request->input('current_section', 0);
        $sections = $this->sections();

        if ($action === 'proceed') {
            session([
                'selected_option' => $request->input('option', 'create'),
                'current_page'    => 'builder',
                'current_section' => 0,
                'form_data'       => [],
            ]);
            return redirect()->route('resumebuilder');
        }

        if ($action === 'next') {
            $skip = ['_token', 'action', 'current_section', 'selected_template'];
            $incoming = array_filter(
                $request->except($skip),
                fn($v) => $v !== null && $v !== ''
            );
            session(['form_data'       => array_merge(session('form_data', []), $incoming)]);
            session(['current_section' => min($section + 1, count($sections) - 1)]);
        }

        if ($action === 'prev') {
            session(['current_section' => max($section - 1, 0)]);
        }

        return redirect()->route('resumebuilder');
    }

    // ── AI Enhancement Endpoint (AJAX) ────────────────────────────────────
    public function aiEnhance(Request $request)
    {
        $field   = $request->input('field');
        $content = $request->input('content', '');
        $context = $request->input('context', []);
        $tone    = $request->input('tone', 'corporate');
        $mode    = $request->input('mode', 'rewrite');

        if (empty($content) && $mode !== 'suggest') {
            return response()->json(['success' => false, 'error' => 'Content is empty']);
        }

        $apiKey = config('services.gemini.key');
        if (!$apiKey) {
            return response()->json(['success' => false, 'error' => 'AI service not configured']);
        }

        $prompt = $this->buildPrompt($field, $content, $context, $tone, $mode);

        try {
            $response = Http::timeout(90)->post(
                'https://generativelanguage.googleapis.com/v1/models/gemini-3.5-flash:generateContent?key=' . $apiKey,
                [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.65,
                        'maxOutputTokens' => 600,
                    ],
                ]
            );

            if ($response->successful()) {
                $result = trim($response->json('candidates.0.content.parts.0.text', ''));

                $result = preg_replace('/^["\']|["\']$/', '', $result);

                if ($result !== '') {
                    return response()->json(['success' => true, 'result' => $result]);
                }
            }

            Log::warning('Gemini enhance empty/failed', ['body' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('AI enhance exception', ['message' => $e->getMessage()]);
        }

        return response()->json(['success' => false, 'error' => 'Enhancement failed. Please try again.']);
    }

    // ── Prompt Engineering ────────────────────────────────────────────────
    private function buildPrompt(string $field, string $content, array $context, string $tone, string $mode): string
    {
        $toneMap = [
            'corporate'   => 'Use formal, polished corporate language suitable for Fortune 500 companies. Focus on leadership and business impact.',
            'modern'      => 'Use energetic, concise startup language with strong action verbs. Focus on speed, growth, and innovation.',
            'academic'    => 'Use scholarly, research-oriented language. Focus on methodology, publications, and intellectual rigor.',
            'minimalist'  => 'Use extremely concise, punchy language. One clause per bullet. No fluff.',
            'executive'   => 'Use strategic, high-level leadership language. Focus on vision, ROI, and organizational scale.',
        ];
        $toneText = $toneMap[$tone] ?? $toneMap['corporate'];

        $ctx = '';
        if (!empty($context['jobTitle']))  $ctx .= "Job Title: " . $context['jobTitle'] . "\n";
        if (!empty($context['industry']))  $ctx .= "Industry: " . $context['industry'] . "\n";
        if (!empty($context['degree']))    $ctx .= "Degree: " . $context['degree'] . "\n";

        // Pre-compute fallback values to avoid ?? inside string interpolation
        $jobTitleFallback = $context['jobTitle'] ?? 'professional';

        $instructions = match ($field) {
            'responsibilities' => match ($mode) {
                'expand' => "Expand the following rough note into 3 professional resume bullet points with metrics and impact. " . $toneText . "\n\n" . $ctx . "Input:\n" . $content . "\n\nReturn ONLY the 3 bullet points, one per line, starting with '•'.",
                'ats'    => "Rewrite the following with strong ATS keywords for a " . $jobTitleFallback . " role. " . $toneText . "\n\n" . $ctx . "Input:\n" . $content . "\n\nReturn ONLY the rewritten content.",
                default  => "Rewrite the following into professional, achievement-oriented resume bullets. " . $toneText . "\n\n" . $ctx . "Input:\n" . $content . "\n\nReturn ONLY the improved content.",
            },
            'skills' => match ($mode) {
                'suggest' => "Based on these skills: '" . $content . "', suggest 6-8 related professional technical skills that would strengthen a resume. Return ONLY a comma-separated list.",
                'ats'     => "Optimize the following skill list for ATS scanners for a " . $jobTitleFallback . " role. Use industry-standard terms. " . $toneText . "\n\nInput:\n" . $content . "\n\nReturn ONLY the optimized comma-separated list.",
                default   => "Improve the following skill list to sound more professional and current. " . $toneText . "\n\nInput:\n" . $content . "\n\nReturn ONLY the improved comma-separated list.",
            },
            'title' => "Rewrite the following job title to be more professional and ATS-friendly. " . $toneText . "\n\nInput:\n" . $content . "\n\nReturn ONLY the improved title.",
            'summary' => "Write a professional resume summary (2-3 sentences). " . $toneText . "\n\n" . $ctx . "Background:\n" . $content . "\n\nReturn ONLY the summary.",
            default => "Improve the following for a professional resume. " . $toneText . "\n\nInput:\n" . $content . "\n\nReturn ONLY the improved content.",
        };

        return $instructions . "\nDo not add explanations, markdown formatting, or quotation marks around the output.";
    }

    // ── Final Generation (POST) ─────────────────────────────────────────
    public function generate(Request $request)
    {
        $data     = $request->except(['selected_template', '_token']);
        $template = $request->input('selected_template', 'modern');

        $name  = trim(($data['firstName'] ?? '') . ' ' . ($data['lastName'] ?? ''));
        $email = $data['email'] ?? '';
        $phone = $data['phone'] ?? '';
        $city  = $data['city'] ?? 'Bangladesh';

        if (!$name || !$email) {
            return back()->with('error', 'Name and email are required.');
        }

        // ── Education ─────────────────────────────────────────────────────
        $education = [];
        if (!empty($data['degree']) || !empty($data['university'])) {
            $education[] = [
                'level'  => 'Undergraduate',
                'degree' => $data['degree']         ?? null,
                'school' => $data['university']     ?? null,
                'major'  => $data['major']          ?? null,
                'cgpa'   => $data['cgpa']           ?? null,
                'year'   => $data['graduationYear'] ?? null,
            ];
        }
        if (!empty($data['hsc_college'])) {
            $education[] = [
                'level'  => 'HSC / A-Level',
                'school' => $data['hsc_college'],
                'year'   => $data['hsc_year']  ?? null,
                'grade'  => $data['hsc_grade'] ?? null,
            ];
        }
        if (!empty($data['ssc_school'])) {
            $education[] = [
                'level'  => 'SSC / O-Level',
                'school' => $data['ssc_school'],
                'year'   => $data['ssc_year']  ?? null,
                'grade'  => $data['ssc_grade'] ?? null,
            ];
        }
        if (empty($education)) {
            $education[] = [
                'level'  => 'Education',
                'degree' => $data['degree']     ?? 'Student',
                'school' => $data['university'] ?? 'Not Provided',
                'year'   => $data['graduationYear'] ?? null,
            ];
        }

        // ── Experience ────────────────────────────────────────────────────
        $experience = [];
        if (!empty($data['jobTitle']) || !empty($data['company'])) {
            $responsibilities = !empty($data['responsibilities'])
                ? array_values(array_filter(explode("\n", trim($data['responsibilities']))))
                : [];
            $experience[] = [
                'title'            => $data['jobTitle'] ?? '',
                'company'          => $data['company']  ?? '',
                'duration'         => $data['duration'] ?? '',
                'responsibilities' => $responsibilities,
            ];
        }

        // ── Skills ────────────────────────────────────────────────────────
        $technical = !empty($data['technicalSkills'])
            ? array_map('trim', explode(',', $data['technicalSkills'])) : [];
        $soft = !empty($data['softSkills'])
            ? array_map('trim', explode(',', $data['softSkills']))      : [];
        $languages = !empty($data['languages'])
            ? array_map('trim', explode(',', $data['languages']))       : [];

        // ── AI Summary (enhanced context) ─────────────────────────────────
        $degree  = $data['degree']          ?? 'their degree';
        $uni     = $data['university']      ?? 'their institution';
        $skills  = $data['technicalSkills'] ?? 'technology';
        $job     = $data['jobTitle']        ?? null;

        $summaryContext = "Name: " . $name . "\nDegree: " . $degree . " from " . $uni . "\nSkills: " . $skills;
        if ($job) {
            $summaryContext .= "\nExperience: " . $job . " at " . ($data['company'] ?? 'a company');
        }

        $prompt  = "Write a professional resume summary (2–3 sentences) for:\n" . $summaryContext . "\n\nReturn ONLY the summary text. No labels, no quotes.";
        $summary = "Professional with a strong background in " . $skills . ".";

        $apiKey = config('services.gemini.key');
        if ($apiKey) {
            try {
                $response = Http::timeout(90)->post(
                    'https://generativelanguage.googleapis.com/v1/models/gemini-3.5-flash:generateContent?key=' . $apiKey,
                    [
                        'contents' => [['parts' => [['text' => $prompt]]]],
                        'generationConfig' => ['temperature' => 0.7, 'maxOutputTokens' => 300],
                    ]
                );

                if ($response->successful()) {
                    $generated = trim($response->json('candidates.0.content.parts.0.text', ''));
                    if ($generated !== '') {
                        $summary = $generated;
                    }
                }
            } catch (\Exception $e) {
                Log::error('Gemini summary error', ['message' => $e->getMessage()]);
            }
        }

        // ── Store & Redirect ────────────────────────────────────────────
        session([
            'resume' => [
                'name'       => $name,
                'email'      => $email,
                'phone'      => $phone,
                'city'       => $city,
                'summary'    => $summary,
                'education'  => $education,
                'experience' => $experience,
                'skills'     => [
                    'technical' => $technical,
                    'soft'      => $soft,
                    'languages' => $languages,
                ],
            ],
            'template' => $template,
        ]);
        session()->forget(['form_data', 'current_page', 'current_section', 'selected_option', 'selected_template']);

        return redirect()->route('resume.show', ['template' => $template]);
    }

    // ── Show rendered resume ──────────────────────────────────────────────
    public function show($template)
    {
        $resume = session('resume');
        if (!$resume) {
            return redirect()->route('resumebuilder')->with('error', 'No resume data found. Please start over.');
        }
        $template = in_array($template, ['modern', 'chronological', 'minimal']) ? $template : 'modern';
        return view("resume.$template", compact('resume'));
    }

    // ── PDF download ─────────────────────────────────────────────────────
    public function downloadPDF(Request $request)
    {
        $resume   = session('resume');
        $template = session('template', 'modern');
        if (!$resume) {
            return redirect()->route('resumebuilder')->with('error', 'No resume available to download.');
        }
        try {
            $html = view("resume.$template", [
                'resume' => $resume,
                'forPdf' => true,
            ])->render();

            $path = storage_path('app/public/resume.pdf');

            Browsershot::html($html)
                ->format('A4')
                ->showBackground()
                ->margins(0, 0, 0, 0)
                ->waitUntilNetworkIdle()
                ->savePdf($path);

            return response()->download($path);
        } catch (\Exception $e) {
            Log::error('PDF generation error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to generate PDF.');
        }
    }
}
