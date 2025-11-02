<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/landing', function () {
    return view('landingTest');
});

Route::get('/mission', function () {
    return view('mission');
});

Route::get('/templates', function () {
    return view('test');
});

Route::get('/resumebuilder', function () {
    return view('resumeBuilder');
});

Route::get('/resumebuilderv2', function () {
    return view('resumebuilderv2');
});

Route::get('/features', function () {
    return view('features');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
