<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CV Analyzer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">CV Analyzer</h1>
            <p class="text-gray-600">Get AI-powered feedback on your CV/Resume</p>
        </div>

        <!-- Upload Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <form id="analyzerForm" enctype="multipart/form-data">
                @csrf
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

        <!-- Results Section -->
        <div id="resultsSection" class="hidden">
            <!-- Rating Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Your CV Rating</h2>
                <div class="flex items-center justify-center">
                    <div class="relative">
                        <div class="text-6xl font-bold text-blue-600" id="ratingNumber">0</div>
                        <div class="text-gray-500 text-xl">/10</div>
                    </div>
                </div>
                <div class="mt-4 bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div id="ratingBar" class="bg-blue-600 h-full transition-all duration-1000" style="width: 0%"></div>
                </div>
            </div>

            <!-- Strengths -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-green-700 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Strengths
                </h3>
                <ul id="strengthsList" class="space-y-2"></ul>
            </div>

            <!-- Areas for Improvement -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-orange-700 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Areas for Improvement
                </h3>
                <ul id="improvementsList" class="space-y-2"></ul>
            </div>

            <!-- Feedback Cards -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Structure Feedback</h3>
                    <p id="structureFeedback" class="text-gray-700"></p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Content Feedback</h3>
                    <p id="contentFeedback" class="text-gray-700"></p>
                </div>
            </div>

            <!-- Recommendations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-blue-700 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    Recommendations
                </h3>
                <ul id="recommendationsList" class="space-y-2"></ul>
            </div>

            <!-- Action Button -->
            <div class="mt-6 text-center">
                <button onclick="location.reload()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                    Analyze Another CV
                </button>
            </div>
        </div>
    </div>

    <script>
        // File upload handling
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('cv_file');
        const fileName = document.getElementById('fileName');

        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                fileName.textContent = e.target.files[0].name;
                fileName.classList.remove('hidden');
            }
        });

        // Drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-blue-500', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');

            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                fileName.textContent = e.dataTransfer.files[0].name;
                fileName.classList.remove('hidden');
            }
        });

        // Form submission
        document.getElementById('analyzerForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const loadingIndicator = document.getElementById('loadingIndicator');
            const errorMessage = document.getElementById('errorMessage');
            const resultsSection = document.getElementById('resultsSection');
            const analyzeBtn = document.getElementById('analyzeBtn');

            // Reset UI
            loadingIndicator.classList.remove('hidden');
            errorMessage.classList.add('hidden');
            resultsSection.classList.add('hidden');
            analyzeBtn.disabled = true;

            try {
                const response = await fetch('{{ route("analyzer.analyze") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    displayResults(data.analysis);
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

        function displayResults(analysis) {
            // Rating
            document.getElementById('ratingNumber').textContent = analysis.rating;
            document.getElementById('ratingBar').style.width = (analysis.rating * 10) + '%';

            // Strengths
            const strengthsList = document.getElementById('strengthsList');
            strengthsList.innerHTML = analysis.strengths.map(strength =>
                `<li class="flex items-start"><span class="text-green-500 mr-2">✓</span><span class="text-gray-700">${strength}</span></li>`
            ).join('');

            // Improvements
            const improvementsList = document.getElementById('improvementsList');
            improvementsList.innerHTML = analysis.improvements.map(improvement =>
                `<li class="flex items-start"><span class="text-orange-500 mr-2">•</span><span class="text-gray-700">${improvement}</span></li>`
            ).join('');

            // Feedback
            document.getElementById('structureFeedback').textContent = analysis.structure_feedback;
            document.getElementById('contentFeedback').textContent = analysis.content_feedback;

            // Recommendations
            const recommendationsList = document.getElementById('recommendationsList');
            recommendationsList.innerHTML = analysis.recommendations.map(rec =>
                `<li class="flex items-start"><span class="text-blue-500 mr-2">→</span><span class="text-gray-700">${rec}</span></li>`
            ).join('');

            // Show results
            document.getElementById('resultsSection').classList.remove('hidden');

            // Scroll to results
            document.getElementById('resultsSection').scrollIntoView({ behavior: 'smooth' });
        }

        function showError(message) {
            document.getElementById('errorText').textContent = message;
            document.getElementById('errorMessage').classList.remove('hidden');
        }
    </script>
</body>
</html>
