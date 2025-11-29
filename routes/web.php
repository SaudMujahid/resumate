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
Route::get('/features', fn() => view('features'));

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
// Resume Builder (step-by-step)
// ---------------------------------------------------------------------
Route::get('/resumebuilder', function (Request $request) {
    // ------------------------------------------------- store template
    if ($request->filled('template')) {
        session(['selected_template' => $request->query('template')]);
    }

    // ------------------------------------------------- initial load → choice page
    if (!$request->has('action')) {
        session(['current_page' => 'choice']);
        return view('resumebuilder');
    }

    // ------------------------------------------------- session state
    $currentPage   = session('current_page', 'choice');
    $currentSection = (int) session('current_section', 0);
    $currentStep    = (int) session('current_step', 0);
    $formData       = session('form_data', []);

    $allSections = [
        ['name' => 'Personal Info', 'steps' => ['firstName', 'lastName', 'email', 'phone', 'city']],
        ['name' => 'Education',    'steps' => ['degree', 'school', 'graduationYear', 'major']],
        ['name' => 'Experience',   'steps' => ['jobTitle', 'company', 'duration', 'responsibilities']],
        ['name' => 'Skills',       'steps' => ['technicalSkills', 'softSkills', 'languages']],
    ];

    $action = $request->input('action');

    // --------------------- CHOICE PAGE ---------------------
    if ($action === 'proceed') {
        $option = $request->input('option');
        session(['selected_option' => $option]);

        if ($option === 'create') {
            session(['current_page' => 'builder']);
        } elseif ($option === 'upload') {
            return redirect()->route('resumebuilder')
                ->with('message', 'Upload coming soon');
        }
        return view('resumebuilder');
    }

    // --------------------- BUILDER NAVIGATION ---------------------
    if (in_array($action, ['next', 'skip'])) {
        // save answer (only on "next")
        if ($action === 'next' && $request->filled('answer')) {
            $stepId = $allSections[$currentSection]['steps'][$currentStep];
            $formData[$stepId] = $request->answer;
            session(['form_data' => $formData]);
        }

        $total = count($allSections[$currentSection]['steps']);

        if ($currentStep < $total - 1) {
            session(['current_step' => $currentStep + 1]);
        } elseif ($currentSection < count($allSections) - 1) {
            session(['current_section' => $currentSection + 1, 'current_step' => 0]);
        } else {
            // Last step completed - don't auto-submit, just stay on the page
            // The JavaScript will handle the final submission
            return view('resumebuilder');
        }

        return view('resumebuilder');
    }

    // --------------------- BACK ---------------------
    if ($action === 'prev') {
        if ($currentStep > 0) {
            session(['current_step' => $currentStep - 1]);
        } elseif ($currentSection > 0) {
            $currentSection--;
            $prevSteps = count($allSections[$currentSection]['steps']);
            session(['current_section' => $currentSection, 'current_step' => $prevSteps - 1]);
        }
        return view('resumebuilder');
    }

    return view('resumebuilder');
})->name('resumebuilder');

// ---------------------------------------------------------------------
// Resume generation & display
// ---------------------------------------------------------------------
Route::post('/resume/generate', [ResumeBuilderController::class, 'generate'])
    ->name('resume.generate');

Route::get('/resume/{template}', [ResumeBuilderController::class, 'show'])
    ->name('resume.show')
    ->where('template', 'modern|chronological|minimal');

// ---------------------------------------------------------------------
// PDF download
// ---------------------------------------------------------------------
Route::get('/resume/download-pdf', [ResumeBuilderController::class, 'downloadPDF'])
    ->name('resume.download');

// CV Analyzer Routes
Route::get('/analyzer', [AnalyzerController::class, 'index'])->name('analyzer.index');
Route::post('/analyzer/analyze', [AnalyzerController::class, 'analyze'])->name('analyzer.analyze');
Route::get('/analyzer/results/{id}', [AnalyzerController::class, 'results'])->name('analyzer.results');
require __DIR__ . '/auth.php';
