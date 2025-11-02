<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Resumate - AI Resume Builder' }}</title>

    {{-- Include Tailwind + your styles via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@500;600&family=Inter:wght@400&display=swap" rel="stylesheet">
</head>
<body x-data x-cloak class="font-[Poppins] text-[#1C1C3C] min-h-screen flex flex-col">

<div x-data="{
    currentPage: 'choice',
    selectedOption: null,
    currentSection: 0,
    currentStep: 0,

    allSections: [
        {
            name: 'Personal Info',
            bgColor: 'from-[#F2E9FF] to-[#FFE9F5]',
            steps: [
                { id: 'firstName', label: 'What\'s your first name?', type: 'text', placeholder: 'John', required: true },
                { id: 'lastName', label: 'And your last name?', type: 'text', placeholder: 'Doe', required: true },
                { id: 'email', label: 'Your email address?', type: 'email', placeholder: 'john.doe@example.com', required: true },
                { id: 'phone', label: 'Phone number?', type: 'tel', placeholder: '+1 (555) 123-4567', required: true },
                { id: 'city', label: 'Which city are you in?', type: 'text', placeholder: 'New York', required: false }
            ]
        },
        {
            name: 'Education',
            bgColor: 'from-[#FFE9D1] to-[#FFF5E9]',
            steps: [
                { id: 'degree', label: 'What\'s your degree?', type: 'text', placeholder: 'Bachelor of Science', required: true },
                { id: 'school', label: 'Which school?', type: 'text', placeholder: 'University of California', required: true },
                { id: 'graduationYear', label: 'Graduation year?', type: 'text', placeholder: '2020', required: true },
                { id: 'major', label: 'Your major?', type: 'text', placeholder: 'Computer Science', required: false }
            ]
        },
        {
            name: 'Experience',
            bgColor: 'from-[#E9F5FF] to-[#F0F9FF]',
            steps: [
                { id: 'jobTitle', label: 'Most recent job title?', type: 'text', placeholder: 'Software Engineer', required: true },
                { id: 'company', label: 'Company name?', type: 'text', placeholder: 'Tech Corp', required: true },
                { id: 'duration', label: 'How long? (e.g., 2 years)', type: 'text', placeholder: '2 years', required: true },
                { id: 'responsibilities', label: 'Key responsibilities?', type: 'textarea', placeholder: 'Led development of web applications...', required: false }
            ]
        },
        {
            name: 'Skills',
            bgColor: 'from-[#E9FFE9] to-[#F0FFF0]',
            steps: [
                { id: 'technicalSkills', label: 'Technical skills?', type: 'text', placeholder: 'Python, JavaScript, React', required: true },
                { id: 'softSkills', label: 'Soft skills?', type: 'text', placeholder: 'Communication, Leadership', required: false },
                { id: 'languages', label: 'Languages you speak?', type: 'text', placeholder: 'English, Spanish', required: false }
            ]
        }
    ],

    formData: {},

    get currentSectionData() {
        return this.allSections[this.currentSection];
    },

    get currentStepData() {
        return this.currentSectionData.steps[this.currentStep];
    },

    get totalStepsInSection() {
        return this.currentSectionData.steps.length;
    },

    selectOption(option) {
        this.selectedOption = option;
    },

    proceedToBuilder() {
        if (this.selectedOption === 'create') {
            this.currentPage = 'builder';
        } else if (this.selectedOption === 'upload') {
            alert('Upload functionality will be implemented');
        }
    },

    canContinue() {
        const step = this.currentStepData;
        if (!step.required) return true;
        return this.formData[step.id] && this.formData[step.id].trim() !== '';
    },

    nextStep() {
        if (!this.canContinue()) return;

        if (this.currentStep < this.totalStepsInSection - 1) {
            this.currentStep++;
        } else {
            // Move to next section
            if (this.currentSection < this.allSections.length - 1) {
                this.currentSection++;
                this.currentStep = 0;
            } else {
                // All done!
                this.completeResume();
            }
        }
    },

    prevStep() {
        if (this.currentStep > 0) {
            this.currentStep--;
        } else if (this.currentSection > 0) {
            this.currentSection--;
            this.currentStep = this.allSections[this.currentSection].steps.length - 1;
        }
    },

    getSectionProgress() {
        return Math.round(((this.currentStep + 1) / this.totalStepsInSection) * 100);
    },

    completeResume() {
        console.log('Resume Data:', this.formData);
        alert('Resume completed! Data: ' + JSON.stringify(this.formData, null, 2));
        // TODO: Send to backend or AI
    }
}" class="min-h-screen bg-white relative overflow-hidden">

    <!-- Close Button -->
    <button
        @click="window.location.href = '{{ url('/templates') }}'"
        class="fixed top-6 right-6 z-50 w-12 h-12 flex items-center justify-center rounded-full bg-white shadow-lg hover:bg-[#FFB8C6] transition-all duration-300 group">
        <svg class="w-6 h-6 text-gray-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

<!-- PAGE 1: Choice Screen -->
    <div x-show="currentPage === 'choice'"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#F2E9FF] to-[#FFE9F5] px-6">

        <div class="max-w-2xl w-full">
            <div class="text-center mb-12">
                <h1 class="font-['Playfair_Display'] text-5xl font-bold text-[#3A2F6A] mb-4">
                    Let's Get Started
                </h1>
                <p class="font-['Inter'] text-xl text-[#3A2F6A]/70">
                    Choose how you'd like to begin
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Create New -->
                <button
                    @click="selectOption('create')"
                    class="bg-white rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl border-4"
                    :class="selectedOption === 'create' ? 'border-[#6A6CFF] shadow-xl' : 'border-transparent shadow-lg'">
                    <div class="w-20 h-20 mx-auto mb-5 rounded-full flex items-center justify-center"
                         :class="selectedOption === 'create' ? 'bg-[#6A6CFF]' : 'bg-[#F2E9FF]'">
                        <svg class="w-10 h-10 transition-colors"
                             :class="selectedOption === 'create' ? 'text-white' : 'text-[#6A6CFF]'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <h3 class="font-['Poppins'] text-2xl font-semibold text-[#3A2F6A] mb-3">
                        Create New
                    </h3>
                    <p class="font-['Inter'] text-base text-[#3A2F6A]/70">
                        Start fresh with guided steps
                    </p>
                </button>

                <!-- Upload Existing -->
                <button
                    @click="selectOption('upload')"
                    class="bg-white rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl border-4"
                    :class="selectedOption === 'upload' ? 'border-[#FFB8C6] shadow-xl' : 'border-transparent shadow-lg'">
                    <div class="w-20 h-20 mx-auto mb-5 rounded-full flex items-center justify-center"
                         :class="selectedOption === 'upload' ? 'bg-[#FFB8C6]' : 'bg-[#FFE9F5]'">
                        <svg class="w-10 h-10 transition-colors"
                             :class="selectedOption === 'upload' ? 'text-white' : 'text-[#FFB8C6]'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    <h3 class="font-['Poppins'] text-2xl font-semibold text-[#3A2F6A] mb-3">
                        Upload Existing
                    </h3>
                    <p class="font-['Inter'] text-base text-[#3A2F6A]/70">
                        Import and enhance your resume
                    </p>
                </button>
            </div>

            <div class="text-center">
                <button
                    @click="proceedToBuilder()"
                    :disabled="!selectedOption"
                    class="px-12 py-4 rounded-xl font-['Inter'] font-bold text-xl transition-all duration-300 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    :class="selectedOption ? 'bg-[#6A6CFF] text-white hover:bg-[#5555FF] hover:shadow-xl hover:scale-105' : 'bg-gray-300 text-gray-500'">
                    Proceed
                </button>
            </div>
        </div>
    </div>

    <!-- PAGE 2: Resume Builder -->
    <div x-show="currentPage === 'builder'"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="min-h-screen flex">

        <!-- Left Sidebar: Resume Image & Progress -->
        <div class="w-[35%] p-8 flex flex-col justify-between transition-all duration-700 bg-gradient-to-br"
             :class="currentSectionData.bgColor">

            <!-- Resume Format Image -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
                <h3 class="font-['Poppins'] text-lg font-semibold text-[#3A2F6A] mb-4 text-center">
                    Your Format
                </h3>
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <img src="https://d.novoresume.com/images/doc/reverse-chronological-resume-template.png"
                         alt="Reverse Chronological Resume Format"
                         class="w-full h-auto">
                </div>
                <p class="text-center text-sm text-[#3A2F6A]/70 mt-3 font-['Inter']">
                    Reverse Chronological Format
                </p>
            </div>

            <!-- Progress Section -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-['Poppins'] text-lg font-semibold text-[#3A2F6A]">
                        <span x-text="currentSectionData.name"></span>
                    </h3>
                    <span class="font-['Inter'] text-sm text-[#6A6CFF] font-bold" x-text="getSectionProgress() + '%'"></span>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
                    <div class="bg-[#6A6CFF] h-3 rounded-full transition-all duration-500"
                         :style="`width: ${getSectionProgress()}%`"></div>
                </div>

                <!-- Section List -->
                <div class="space-y-2">
                    <template x-for="(section, index) in allSections" :key="index">
                        <div class="flex items-center p-3 rounded-lg"
                             :class="index === currentSection ? 'bg-[#6A6CFF]/10' : index < currentSection ? 'bg-green-50' : 'bg-gray-50'">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 flex-shrink-0"
                                 :class="index === currentSection ? 'bg-[#6A6CFF] text-white' : index < currentSection ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600'">
                                <span x-show="index < currentSection">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                                <span x-show="index >= currentSection" x-text="index + 1" class="text-sm font-bold"></span>
                            </div>
                            <span class="font-['Inter'] text-sm font-medium"
                                  :class="index === currentSection ? 'text-[#3A2F6A]' : 'text-gray-500'"
                                  x-text="section.name"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Right Side: One Question at a Time -->
        <div class="flex-1 bg-white flex items-center justify-center p-12">
            <div class="max-w-xl w-full">

                <!-- Question Display -->
                <div x-show="currentPage === 'builder'"
                     :key="currentSection + '-' + currentStep"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0">

                    <!-- Question Number -->
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-[#6A6CFF] text-white flex items-center justify-center font-bold text-xl mr-4">
                            <span x-text="currentStep + 1"></span>
                        </div>
                        <div class="text-sm text-gray-500 font-['Inter']">
                            <span x-text="currentSectionData.name"></span> -
                            Question <span x-text="currentStep + 1"></span> of <span x-text="totalStepsInSection"></span>
                        </div>
                    </div>

                    <!-- Question Label -->
                    <h2 class="font-['Playfair_Display'] text-4xl font-bold text-[#3A2F6A] mb-8"
                        x-text="currentStepData.label">
                    </h2>

                    <!-- Input Field -->
                    <template x-if="currentStepData.type !== 'textarea'">
                        <input
                            :type="currentStepData.type"
                            x-model="formData[currentStepData.id]"
                            :placeholder="currentStepData.placeholder"
                            @keydown.enter="nextStep()"
                            class="w-full px-6 py-4 text-2xl rounded-xl border-3 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors font-['Inter'] mb-8"
                            autofocus>
                    </template>

                    <!-- Textarea for longer responses -->
                    <template x-if="currentStepData.type === 'textarea'">
                        <textarea
                            x-model="formData[currentStepData.id]"
                            :placeholder="currentStepData.placeholder"
                            rows="6"
                            class="w-full px-6 py-4 text-xl rounded-xl border-3 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors font-['Inter'] mb-8 resize-none"
                            autofocus></textarea>
                    </template>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center">
                        <button
                            @click="prevStep()"
                            x-show="currentSection > 0 || currentStep > 0"
                            class="px-6 py-3 rounded-xl font-['Inter'] font-semibold text-lg text-gray-600 hover:bg-gray-100 transition-all duration-300">
                            ← Back
                        </button>
                        <div x-show="currentSection === 0 && currentStep === 0"></div>

                        <button
                            @click="nextStep()"
                            :disabled="!canContinue()"
                            class="px-10 py-4 rounded-xl font-['Inter'] font-bold text-xl transition-all duration-300 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            :class="canContinue() ? 'bg-[#6A6CFF] text-white hover:bg-[#5555FF] hover:shadow-xl hover:scale-105' : 'bg-gray-300 text-gray-500'">
                            <span x-show="currentSection < allSections.length - 1 || currentStep < totalStepsInSection - 1">Continue →</span>
                            <span x-show="currentSection === allSections.length - 1 && currentStep === totalStepsInSection - 1">Complete ✓</span>
                        </button>
                    </div>

                    <!-- Skip Option for Optional Fields -->
                    <div x-show="!currentStepData.required" class="text-center mt-4">
                        <button @click="nextStep()"
                                class="text-gray-500 hover:text-[#6A6CFF] font-['Inter'] text-sm transition-colors">
                            Skip this question
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

        {{-- @push('scripts') --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        {{-- @endpush --}}


    </body>
</html>

