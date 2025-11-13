<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeBuilderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/mission', function () {
    return view('mission');
});

Route::get('/templates', function () {
    return view('templates');
});

Route::get('/resumebuilder', function () {
    return view('resumebuilder');
})->name('resumebuilder');

Route::get('/features', function () {
    return view('features');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('ResumeBuilder', ResumeBuilderController::class);

// New routes for resume processing
Route::post('/generate-resume', [ResumeBuilderController::class, 'generate'])->name('resume.generate');

Route::get('/resume/modern', [ResumeBuilderController::class, 'showModern'])->name('resume.modern');
Route::get('/resume/chronological', [ResumeBuilderController::class, 'showChronological'])->name('resume.chronological');
Route::get('/resume/minimal', [ResumeBuilderController::class, 'showMinimal'])->name('resume.minimal');

Route::post('/resume/update', [ResumeBuilderController::class, 'update'])->name('resume.update');
Route::post('/resume/download-pdf', [ResumeBuilderController::class, 'downloadPDF'])->name('resume.download');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
