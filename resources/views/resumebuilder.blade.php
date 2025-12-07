<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Resumate - AI Resume Builder' }}</title>

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            'playfair': ['Playfair Display', 'serif'],
                            'poppins': ['Poppins', 'sans-serif'],
                            'inter': ['Inter', 'sans-serif'],
                        },
                        colors: {
                            'primary': '#1C1C3C',
                            'secondary': '#FF6F61',
                            'accent-blue': '#6497b1',
                            'accent-purple': '#a64d79',
                            'accent-green': '#6aa84f',
                        }
                    }
                }
            }
        </script>
    @endif

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@500;600&family=Inter:wght@400&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-[Poppins] text-[#1C1C3C] min-h-screen flex flex-col">
@php
    // ... (your PHP logic stays exactly the same)
    $currentPage = session('current_page', 'choice');
    $selectedOption = session('selected_option', null);
    $currentSection = (int) session('current_section', 0);
    $currentStep = (int) session('current_step', 0);
    $formData = session('form_data', []);
    $selectedTemplate = session('selected_template', 'modern');
    $allSections = [ /* ... your sections array ... */ ];
    $currentSectionData = $allSections[$currentSection] ?? $allSections[0];
    $totalStepsInSection = count($currentSectionData['steps']);
    $currentStepData = $currentSectionData['steps'][$currentStep] ?? $currentSectionData['steps'][0];
    $sectionProgress = round((($currentStep + 1) / $totalStepsInSection) * 100);
    $isLastStep = ($currentSection === count($allSections) - 1) && ($currentStep === $totalStepsInSection - 1);
@endphp

<div class="min-h-screen bg-white relative overflow-hidden flex flex-col">
    <!-- Close Button - Always visible -->
    <a href="{{ url('/templates') }}" class="fixed top-4 right-4 z-50 w-12 h-12 flex items-center justify-center rounded-full bg-white shadow-lg hover:bg-[#FFB8C6] transition-all duration-300 group md:top-6 md:right-6">
        <svg class="w-6 h-6 text-gray-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </a>

    @if($currentPage === 'choice')
    <!-- PAGE 1: Choice Screen (Mobile Friendly) -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#F2E9FF] to-[#FFE9F5] px-6 py-12">
        <div class="max-w-2xl w-full">
            <div class="text-center mb-10">
                <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl font-bold text-[#3A2F6A] mb-4">
                    Let's Get Started
                </h1>
                <p class="font-['Inter'] text-lg md:text-xl text-[#3A2F6A]/70">
                    Choose how you'd like to begin
                </p>
            </div>

            <form action="{{ route('resumebuilder') }}" method="GET">
                <input type="hidden" name="template" value="{{ $selectedTemplate }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    <!-- Create New -->
                    <label class="cursor-pointer block">
                        <input type="radio" name="option" value="create" class="hidden peer" {{ $selectedOption === 'create' ? 'checked' : '' }}>
                        <div class="bg-white rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl border-4 border-transparent peer-checked:border-[#6A6CFF] peer-checked:shadow-xl shadow-lg">
                            <div class="w-20 h-20 mx-auto mb-5 rounded-full flex items-center justify-center bg-[#F2E9FF] peer-checked:bg-[#6A6CFF]">
                                <svg class="w-10 h-10 text-[#6A6CFF] peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <h3 class="font-['Poppins'] text-2xl font-semibold text-[#3A2F6A] mb-3">Create New</h3>
                            <p class="font-['Inter'] text-base text-[#3A2F6A]/70">Start fresh with guided steps</p>
                        </div>
                    </label>

                    <!-- Upload Existing -->
                    <label class="cursor-pointer block">
                        <input type="radio" name="option" value="upload" class="hidden peer" {{ $selectedOption === 'upload' ? 'checked' : '' }}>
                        <div class="bg-white rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl border-4 border-transparent peer-checked:border-[#FFB8C6] peer-checked:shadow-xl shadow-lg">
                            <div class="w-20 h-20 mx-auto mb-5 rounded-full flex items-center justify-center bg-[#FFE9F5] peer-checked:bg-[#FFB8C6]">
                                <svg class="w-10 h-10 text-[#FFB8C6] peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <h3 class="font-['Poppins'] text-2xl font-semibold text-[#3A2F6A] mb-3">Upload Existing</h3>
                            <p class="font-['Inter'] text-base text-[#3A2F6A]/70">Import and enhance your resume</p>
                        </div>
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" name="action" value="proceed"
                            class="w-full md:w-auto px-12 py-5 rounded-xl font-['Inter'] font-bold text-xl transition-all duration-300 shadow-lg bg-[#6A6CFF] text-white hover:bg-[#5555FF] hover:shadow-xl hover:scale-105">
                        Proceed
                    </button>
                </div>
            </form>
        </div>
    </div>

    @elseif($currentPage === 'builder')
    <!-- PAGE 2: Resume Builder – Mobile-First Layout -->
    <div class="flex-1 flex flex-col lg:flex-row">

        <!-- MOBILE: Progress Bar at Top -->
        <div class="lg:hidden bg-gradient-to-br {{ $currentSectionData['bgColor'] }} p-5 shadow-lg">
            <div class="flex items-center justify-between text-white">
                <div>
                    <h3 class="font-['Poppins'] font-semibold">{{ $currentSectionData['name'] }}</h3>
                    <p class="text-sm opacity-90">{{ $sectionProgress }}% Complete</p>
                </div>
                <div class="text-right">
                    <div class="w-32 bg-white/30 rounded-full h-3">
                        <div class="bg-white h-3 rounded-full transition-all duration-500" style="width: {{ $sectionProgress }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DESKTOP: Full Sidebar -->
        <div class="hidden lg:block w-full lg:w-[35%] xl:w-[32%] 2xl:w-[30%] p-8 flex flex-col justify-between bg-gradient-to-br {{ $currentSectionData['bgColor'] }} transition-all duration-700">
            <div>
                <!-- Format Image
                <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
                    <h3 class="font-['Poppins'] text-lg font-semibold text-[#3A2F6A] mb-4 text-center">Your Format</h3>
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <img src="https://d.novoresume.com/images/doc/reverse-chronological-resume-template.png" alt="Template" class="w-full h-auto">
                    </div>
                    <p class="text-center text-sm text-[#3A2F6A]/70 mt-3 font-['Inter']">{{ ucfirst($selectedTemplate) }} Template</p>
                </div>

                <!-- Desktop Progress -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-['Poppins'] text-lg font-semibold text-[#3A2F6A]">{{ $currentSectionData['name'] }}</h3>
                        <span class="font-['Inter'] text-sm text-[#6A6CFF] font-bold">{{ $sectionProgress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
                        <div class="bg-[#6A6CFF] h-3 rounded-full transition-all" style="width: {{ $sectionProgress }}%"></div>
                    </div>
                    <div class="space-y-2">
                        @foreach($allSections as $index => $section)
                        <div class="flex items-center p-3 rounded-lg {{ $index === $currentSection ? 'bg-[#6A6CFF]/10' : ($index < $currentSection ? 'bg-green-50' : 'bg-gray-50') }}">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 {{ $index === $currentSection ? 'bg-[#6A6CFF] text-white' : ($index < $currentSection ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                                @if($index < $currentSection)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <span class="text-sm font-bold">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <span class="font-['Inter'] text-sm font-medium {{ $index === $currentSection ? 'text-[#3A2F6A]' : 'text-gray-500' }}">{{ $section['name'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Question Area (Full width on mobile) -->
        <div class="flex-1 bg-white flex items-center justify-center p-6 md:p-12">
            <div class="max-w-xl w-full mx-auto">
                <form action="{{ route('resumebuilder') }}" method="GET" id="stepForm">
                    @csrf
                    <input type="hidden" name="template" value="{{ $selectedTemplate }}">

                    <!-- Question Number -->
                    <div class="flex items-center mb-8">
                        <div class="w-12 h-12 rounded-full bg-[#6A6CFF] text-white flex items-center justify-center font-bold text-xl mr-4 flex-shrink-0">
                            {{ $currentStep + 1 }}
                        </div>
                        <div class="text-sm md:text-base text-gray-500 font-['Inter']">
                            {{ $currentSectionData['name'] }} — Question {{ $currentStep + 1 }} of {{ $totalStepsInSection }}
                        </div>
                    </div>

                    <!-- Question -->
                    <h2 class="font-['Playfair_Display'] text-3xl md:text-4xl font-bold text-[#3A2F6A] mb-8 leading-tight">
                        {{ $currentStepData['label'] }}
                    </h2>

                    <!-- Input Field -->
                    @if($currentStepData['type'] !== 'textarea')
                        <input
                            type="{{ $currentStepData['type'] }}"
                            name="answer"
                            id="answerInput"
                            value="{{ $formData[$currentStepData['id']] ?? '' }}"
                            placeholder="{{ $currentStepData['placeholder'] }}"
                            {{ $currentStepData['required'] ? 'required' : '' }}
                            class="w-full px-6 py-5 text-xl md:text-2xl rounded-xl border-2 border-gray-300 focus:border-[#6A6CFF] focus:outline-none transition-all font-['Inter'] mb-10"
                            autofocus>
                    @else
                        <textarea
                            name="answer"
                            id="answerInput"
                            placeholder="{{ $currentStepData['placeholder'] }}"
                            rows="6"
                            {{ $currentStepData['required'] ? 'required' : '' }}
                            class="w-full px-6 py-5 text-lg md:text-xl rounded-xl border-2 border-gray-300 focus:border-[#6A6CFF] focus:outline-none transition-all font-['Inter'] mb-10 resize-none"
                            autofocus>{{ $formData[$currentStepData['id']] ?? '' }}</textarea>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        @if($currentSection > 0 || $currentStep > 0)
                            <button type="submit" name="action" value="prev"
                                    class="w-full sm:w-auto px-8 py-4 rounded-xl font-['Inter'] font-semibold text-lg text-gray-700 hover:bg-gray-100 transition">
                                ← Back
                            </button>
                        @else
                            <div></div>
                        @endif

                        <div class="w-full sm:w-auto">
                            @if($isLastStep)
                                <button type="button" id="generateResumeBtn"
                                        class="w-full px-10 py-5 rounded-xl font-['Inter'] font-bold text-xl shadow-lg bg-[#6A6CFF] text-white hover:bg-[#5555FF] hover:scale-105 transition-all duration-300">
                                    Generate Resume →
                                </button>
                            @else
                                <button type="submit" name="action" value="next"
                                        class="w-full px-10 py-5 rounded-xl font-['Inter'] font-bold text-xl shadow-lg bg-[#6A6CFF] text-white hover:bg-[#5555FF] hover:scale-105 transition-all">
                                    Continue →
                                </button>
                            @endif
                        </div>
                    </div>

                    @if(!$currentStepData['required'])
                    <div class="text-center mt-6">
                        <button type="submit" name="action" value="skip"
                                class="text-gray-500 hover:text-[#6A6CFF] font-['Inter'] underline transition">
                            Skip this question
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Loading Overlay (unchanged) -->
<div id="loadingOverlay" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-10 md:p-12 max-w-md text-center shadow-2xl">
        <div class="animate-spin rounded-full h-16 w-16 border-4 border-[#6A6CFF] border-t-transparent mx-auto mb-6"></div>
        <h3 class="font-['Poppins'] text-2xl font-bold text-[#3A2F6A] mb-3">Generating Your Resume</h3>
        <p class="font-['Inter'] text-gray-600">Please wait while we craft your professional resume...</p>
    </div>
</div>

<!-- Your existing scripts (unchanged) -->
<script>
// ... (both scripts you had – generate resume + enter key support)
</script>

</body>
</html>
