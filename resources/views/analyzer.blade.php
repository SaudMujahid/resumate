<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CV Analyzer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@extends('layouts.home')
@section('content')
<div class="bg-[#FFFFF7] min-h-screen">
    <!-- Hero Section -->
    <section class="py-12 md:py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                <!-- Left Content -->
                <div class="flex flex-col justify-center">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                        Discover Your Resume Score
                    </h2>
                    <p class="text-lg text-gray-600 mb-4">
                        <span class="font-semibold">– Free, Fast, Brutally Honest</span>
                    </p>
                    <p class="text-base md:text-lg text-gray-700 mb-8 leading-relaxed">
                        No more wondering why you're not getting interviews – we tell you exactly what's holding you back
                    </p>
                    <div>
                        @guest
                            <button onclick="openLoginPrompt()" class="bg-amber-400 hover:bg-amber-500 text-black font-semibold py-3 px-8 rounded-full transition duration-200 transform hover:scale-105 w-full sm:w-auto">
                                Upload Resume
                            </button>
                        @endguest
                        @auth
                            <button onclick="openModal()" class="bg-amber-400 hover:bg-amber-500 text-black font-semibold py-3 px-8 rounded-full transition duration-200 transform hover:scale-105 w-full sm:w-auto">
                                Upload Resume
                            </button>
                        @endauth
                    </div>
                </div>

                <!-- Right Image -->
                <div class="hidden md:block">
                    <div class="bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center overflow-hidden">
                        <div class="w-full h-64 bg-gradient-to-br from-amber-200 to-orange-200 flex items-center justify-center">
                            <img src="{{ asset('images/analyzer-img.jpg') }}" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 md:py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <h3 class="text-2xl md:text-3xl font-bold text-center text-gray-900 mb-12">
                What You'll Discover
            </h3>

            <!-- Cards Grid - Fixed Responsive Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 mb-16">
                <!-- Card 1: Strengths -->
                <div class="bg-[#F1F3E0] rounded-[29px] p-6 flex flex-col items-center text-center min-w-0 transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-2xl font-bold leading-7 text-black font-['Inter'] break-words">
                        Strengths
                    </h3>
                    <p class="mt-4 text-lg md:text-xl font-normal leading-6 text-black/60 font-['Inter']">
                        Discover your shining superstar qualities that make recruiters stop scrolling
                    </p>
                </div>

                <!-- Card 2: Areas of Improvement -->
                <div class="bg-orange-100 rounded-[29px] p-6 flex flex-col items-center text-center min-w-0 transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-2xl font-bold leading-7 text-black font-['Inter'] break-words">
                        Areas of Improvement
                    </h3>
                    <p class="mt-4 text-lg md:text-xl font-normal leading-6 text-black/60 font-['Inter']">
                        Spot the sneaky weaknesses quietly sabotaging your applications
                    </p>
                </div>

                <!-- Card 3: Structure & Content -->
                <div class="bg-orange-200 rounded-[29px] p-6 flex flex-col items-center text-center min-w-0 transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-2xl font-bold leading-7 text-black font-['Inter'] break-words">
                        Structure & Content Feedback
                    </h3>
                    <p class="mt-4 text-lg md:text-xl font-normal leading-6 text-black/60 font-['Inter']">
                        Get an X-ray of your layout, wording and ATS readiness
                    </p>
                </div>

                <!-- Card 4: Recommendations -->
                <div class="bg-orange-300 rounded-[29px] p-6 flex flex-col items-center text-center min-w-0 transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-2xl font-bold leading-7 text-black font-['Inter'] break-words">
                        Recommendations
                    </h3>
                    <p class="mt-4 text-lg md:text-xl font-normal leading-6 text-black/60 font-['Inter']">
                        Receive brutally honest, recruiter-level fixes that actually move the needle
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">
                Why wait longer?
            </h3>
            <p class="text-lg text-gray-600 mb-12">
                Uncover Hidden Strengths in Your Resume Today
            </p>
            @guest
                <button onclick="openLoginPrompt()" class="bg-amber-400 hover:bg-amber-500 text-black font-semibold py-4 px-10 rounded-full text-lg transition duration-200 transform hover:scale-105 inline-block">
                    Get Your Resume Score Now
                </button>
            @endguest
            @auth
                <button onclick="openModal()" class="bg-amber-400 hover:bg-amber-500 text-black font-semibold py-4 px-10 rounded-full text-lg transition duration-200 transform hover:scale-105 inline-block">
                    Get Your Resume Score Now
                </button>
            @endauth
        </div>
    </section>

    <!-- Login Prompt Modal (For Guests) -->
    <div id="loginPromptModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full relative">
            <button onclick="closeLoginPrompt()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 z-10 bg-white rounded-full p-2 hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Get Started Now</h2>
                    <p class="text-gray-600">Sign in to analyze your resume and unlock your potential</p>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('login') }}" class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                        Sign In
                    </a>
                    <p class="text-center text-gray-600">Don't have an account?</p>
                    <a href="{{ route('register') }}" class="w-full block text-center bg-amber-400 hover:bg-amber-500 text-black font-bold py-3 px-6 rounded-lg transition-colors">
                        Create Account
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Analyzer Modal (For Authenticated Users) -->
    <div id="analyzerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto relative">
            <!-- Close Button -->
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 z-10 bg-white rounded-full p-2 hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">CV Analyzer</h1>
                    <p class="text-gray-600">Get AI-powered feedback on your CV/Resume</p>
                </div>

                <!-- Upload Section -->
                <div class="bg-gray-50 rounded-lg p-8 mb-6">
                    <form id="analyzerForm" enctype="multipart/form-data">
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="cv_file">
                                Upload your CV (PDF, DOC, DOCX)
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition-colors cursor-pointer" id="dropZone">
                                <input type="file" name="cv_file" id="cv_file" accept=".pdf,.doc,.docx" class="hidden" required>
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="text-gray-600 mb-1">Click to upload or drag and drop</p>
                                <p class="text-gray-500 text-sm">PDF, DOC, or DOCX (Max 5MB)</p>
                                <p id="fileName" class="mt-3 text-blue-600 font-medium hidden"></p>
                            </div>
                        </div>

                        <button type="submit" id="analyzeBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                            Analyze CV
                        </button>
                    </form>

                    <!-- Loading Indicator -->
                    <div id="loadingIndicator" class="hidden mt-6">
                        <div class="flex items-center justify-center">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mr-3"></div>
                            <span class="text-gray-700">Analyzing your CV... This may take a few moments.</span>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div id="errorMessage" class="hidden mt-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <p class="font-bold">Error</p>
                        <p id="errorText"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Login Prompt Modal functions (for guests)
        function openLoginPrompt() {
            document.getElementById('loginPromptModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLoginPrompt() {
            document.getElementById('loginPromptModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close login prompt when clicking outside
        document.getElementById('loginPromptModal')?.addEventListener('click', (e) => {
            if (e.target.id === 'loginPromptModal') {
                closeLoginPrompt();
            }
        });

        // Analyzer Modal functions (for authenticated users)
        function openModal() {
            document.getElementById('analyzerModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('analyzerModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            resetForm();
        }

        // Close analyzer modal when clicking outside
        document.getElementById('analyzerModal')?.addEventListener('click', (e) => {
            if (e.target.id === 'analyzerModal') {
                closeModal();
            }
        });

        // File upload handling
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('cv_file');
        const fileName = document.getElementById('fileName');

        dropZone?.addEventListener('click', () => fileInput?.click());

        fileInput?.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                fileName.textContent = e.target.files[0].name;
                fileName.classList.remove('hidden');
            }
        });

        // Drag and drop
        dropZone?.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-blue-500', 'bg-blue-50');
        });

        dropZone?.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        });

        dropZone?.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');

            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                fileName.textContent = e.dataTransfer.files[0].name;
                fileName.classList.remove('hidden');
            }
        });

        // Form submission
        document.getElementById('analyzerForm')?.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const loadingIndicator = document.getElementById('loadingIndicator');
            const errorMessage = document.getElementById('errorMessage');
            const analyzeBtn = document.getElementById('analyzeBtn');

            // Reset UI
            loadingIndicator.classList.remove('hidden');
            errorMessage.classList.add('hidden');
            analyzeBtn.disabled = true;

            try {
                const response = await fetch('/analyzer/analyze', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Redirect to results page instead of displaying results
                    window.location.href = data.redirect;
                } else {
                    showError(data.message || 'An error occurred while analyzing your CV.');
                }
            } catch (error) {
                showError('An unexpected error occurred. Please try again.');
                console.error('Error:', error);
            } finally {
                loadingIndicator.classList.add('hidden');
                analyzeBtn.disabled = false;
            }
        });

        function showError(message) {
            const errorMessage = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');
            errorText.textContent = message;
            errorMessage.classList.remove('hidden');
        }

        function resetForm() {
            document.getElementById('analyzerForm')?.reset();
            document.getElementById('fileName').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }
    </script>
</div>
@endsection
</html>
