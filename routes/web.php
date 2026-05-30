<?php

use App\Http\Controllers\AnalyzerController;
use App\Http\Controllers\ResumeBuilderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', fn () => view('landing'))->name('home');
Route::get('/mission', fn () => view('mission'));
Route::get('/templates', fn () => view('templates'));
Route::get('/features', fn () => view('features'));

// Analyzer — open, rate limited (10 uploads per hour per IP)
Route::get('/analyzer', [AnalyzerController::class, 'index'])->name('analyzer.index');
Route::post('/analyzer/analyze', [AnalyzerController::class, 'analyze'])
    ->middleware('throttle:10,60')
    ->name('analyzer.analyze');
Route::get('/analyzer/results/{id}', [AnalyzerController::class, 'results'])
    ->name('analyzer.results');

Route::get('/resumebuilder', [ResumeBuilderController::class, 'index'])->name('resumebuilder');
Route::post('/resumebuilder', [ResumeBuilderController::class, 'navigate'])->name('resumebuilder.navigate');

// Resume Builder — open, rate limited (20 generations per hour per IP)
/* Route::get('/resumebuilder', function (Request $request) { */
/*     if ($request->filled('template')) { */
/*         session(['selected_template' => $request->query('template')]); */
/*     } */
/**/
/*     if (!$request->has('action')) { */
/*         session(['current_page' => 'choice']); */
/*         return view('resumebuilder'); */
/*     } */
/**/
/*     $currentPage     = session('current_page', 'choice'); */
/*     $currentSection  = (int) session('current_section', 0); */
/*     $currentStep     = (int) session('current_step', 0); */
/*     $formData        = session('form_data', []); */
/**/
/*     $allSections = [ */
/*         ['name' => 'Personal Info', 'steps' => ['firstName', 'lastName', 'email', 'phone', 'city']], */
/*         [ */
/*             'name' => 'Education', */
/*             'steps' => [ */
/*                 'degree', */
/*                 'university', */
/*                 'graduationYear', */
/*                 'major', */
/*                 'cgpa', */
/*                 'ssc_school', */
/*                 'ssc_grade', */
/*                 'hsc_college', */
/*                 'hsc_grade', */
/*             ] */
/*         ], */
/*         ['name' => 'Experience', 'steps' => ['jobTitle', 'company', 'duration', 'responsibilities']], */
/*         ['name' => 'Skills', 'steps' => ['technicalSkills', 'softSkills', 'languages']], */
/*     ]; */
/**/
/*     $action = $request->input('action'); */
/**/
/*     if ($action === 'proceed') { */
/*         $option = $request->input('option', 'create'); */
/*         session(['selected_option' => $option]); */
/**/
/*         if ($option === 'create') { */
/*             session(['current_page' => 'builder']); */
/*         } elseif ($option === 'upload') { */
/*             return back()->with('message', 'Upload feature coming soon!'); */
/*         } */
/*         return view('resumebuilder'); */
/*     } */
/**/
/*     if (in_array($action, ['next', 'skip'])) { */
/*         if ($action === 'next' && $request->filled('answer')) { */
/*             $stepId = $allSections[$currentSection]['steps'][$currentStep]; */
/*             $formData[$stepId] = $request->input('answer'); */
/*             session(['form_data' => $formData]); */
/*         } */
/**/
/*         $totalStepsInSection = count($allSections[$currentSection]['steps']); */
/**/
/*         if ($currentStep < $totalStepsInSection - 1) { */
/*             session(['current_step' => $currentStep + 1]); */
/*         } elseif ($currentSection < count($allSections) - 1) { */
/*             session([ */
/*                 'current_section' => $currentSection + 1, */
/*                 'current_step'    => 0 */
/*             ]); */
/*         } */
/*         return view('resumebuilder'); */
/*     } */
/**/
/*     if ($action === 'prev') { */
/*         if ($currentStep > 0) { */
/*             session(['current_step' => $currentStep - 1]); */
/*         } elseif ($currentSection > 0) { */
/*             $currentSection--; */
/*             $prevSectionSteps = count($allSections[$currentSection]['steps']); */
/*             session([ */
/*                 'current_section' => $currentSection, */
/*                 'current_step'    => $prevSectionSteps - 1 */
/*             ]); */
/*         } */
/*         return view('resumebuilder'); */
/*     } */
/**/
/*     return view('resumebuilder'); */
/* })->name('resumebuilder'); */

Route::post('/resume/ai-enhance', [ResumeBuilderController::class, 'aiEnhance'])
    ->middleware('throttle:10,1')
    ->name('resume.ai-enhance');

Route::post('/resume/generate', [ResumeBuilderController::class, 'generate'])
    ->middleware('throttle:20,60')
    ->name('resume.generate');

Route::get('/resume/{template}', [ResumeBuilderController::class, 'show'])
    ->name('resume.show')
    ->where('template', 'modern|chronological|minimal');

Route::get('/resume/download-pdf', [ResumeBuilderController::class, 'downloadPDF'])
    ->name('resume.download');

// Ready-made resume editor
Route::get('/readyresume/{template}', [ResumeBuilderController::class, 'readyResume'])
    ->name('readyresume.show')
    ->where('template', 'modern|minimal|chronological');

Route::post('/readyresume/save', [ResumeBuilderController::class, 'readyResumeSave'])
    ->name('readyresume.save');
