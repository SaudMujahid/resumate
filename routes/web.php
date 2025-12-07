<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeBuilderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AnalyzerController;

// ---------------------------------------------------------------------
// Public pages
// ---------------------------------------------------------------------
Route::get('/', fn() => view('landing'))->name('home');
Route::get('/mission', fn() => view('mission'));
Route::get('/templates', fn() => view('templates'));
Route::get('/features', fn() => view('features'));
Route::get('/analyzer', [AnalyzerController::class, 'index'])->name('analyzer.index');

// ---------------------------------------------------------------------
// Auth dashboard
// ---------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------------------------------------------------------
// Resume Builder (step-by-step) – PROTECTED (auth only)
// ---------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/resumebuilder', function (Request $request) {
        // Store selected template from URL
        if ($request->filled('template')) {
            session(['selected_template' => $request->query('template')]);
        }

        // Initial load → show choice screen
        if (!$request->has('action')) {
            session(['current_page' => 'choice']);
            return view('resumebuilder');
        }

        $currentPage     = session('current_page', 'choice');
        $currentSection  = (int) session('current_section', 0);
        $currentStep     = (int) session('current_step', 0);
        $formData        = session('form_data', []);

        // Updated list of steps with ALL new IDs
        $allSections = [
            ['name' => 'Personal Info', 'steps' => ['firstName', 'lastName', 'email', 'phone', 'city']],
            [
                'name' => 'Education',
                'steps' => [
                    'degree',
                    'university',        // new
                    'graduationYear',
                    'major',
                    'cgpa',             // new – optional
                    'ssc_school',       // new – optional
                    'ssc_grade',        // new – optional
                    'hsc_college',      // new – optional
                    'hsc_grade',        // new – optional
                ]
            ],
            ['name' => 'Experience', 'steps' => ['jobTitle', 'company', 'duration', 'responsibilities']],
            ['name' => 'Skills', 'steps' => ['technicalSkills', 'softSkills', 'languages']],
        ];

        $action = $request->input('action');

        // --------------------- CHOICE PAGE ---------------------
        if ($action === 'proceed') {
            $option = $request->input('option', 'create');
            session(['selected_option' => $option]);

            if ($option === 'create') {
                session(['current_page' => 'builder']);
            } elseif ($option === 'upload') {
                return back()->with('message', 'Upload feature coming soon!');
            }
            return view('resumebuilder');
        }

        // --------------------- NEXT / SKIP ---------------------
        if (in_array($action, ['next', 'skip'])) {
            // Only save answer when pressing "Continue" (not when skipping)
            if ($action === 'next' && $request->filled('answer')) {
                $stepId = $allSections[$currentSection]['steps'][$currentStep];
                $formData[$stepId] = $request->input('answer');
                session(['form_data' => $formData]);
            }

            // Move forward
            $totalStepsInSection = count($allSections[$currentSection]['steps']);

            if ($currentStep < $totalStepsInSection - 1) {
                session(['current_step' => $currentStep + 1]);
            } elseif ($currentSection < count($allSections) - 1) {
                session([
                    'current_section' => $currentSection + 1,
                    'current_step'    => 0
                ]);
            }
            // If it's the very last step → just render (JS will handle final submit)
            return view('resumebuilder');
        }

        // --------------------- BACK ---------------------
        if ($action === 'prev') {
            if ($currentStep > 0) {
                session(['current_step' => $currentStep - 1]);
            } elseif ($currentSection > 0) {
                $currentSection--;
                $prevSectionSteps = count($allSections[$currentSection]['steps']);
                session([
                    'current_section' => $currentSection,
                    'current_step'    => $prevSectionSteps - 1
                ]);
            }
            return view('resumebuilder');
        }

        // Fallback
        return view('resumebuilder');
    })->name('resumebuilder');

    // Resume generation & display (auth only)
    Route::post('/resume/generate', [ResumeBuilderController::class, 'generate'])
        ->name('resume.generate');

    Route::get('/resume/{template}', [ResumeBuilderController::class, 'show'])
        ->name('resume.show')
        ->where('template', 'modern|chronological|minimal');

    // PDF download (auth only)
    Route::get('/resume/download-pdf', [ResumeBuilderController::class, 'downloadPDF'])
        ->name('resume.download');

    // Analyzer analyze action (auth only)
    Route::post('/analyzer/analyze', [AnalyzerController::class, 'analyze'])->name('analyzer.analyze');
    Route::get('/analyzer/results/{id}', [AnalyzerController::class, 'results'])
        ->name('analyzer.results')
        ->middleware('signed');
});

require __DIR__ . '/auth.php';
