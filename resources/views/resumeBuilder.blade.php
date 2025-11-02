@extends('layouts.home')

@section('content')
<div x-data="{
    currentPage: 'choice', // 'choice' or 'builder'
    selectedOption: null, // 'create' or 'upload'
    currentSection: 0,
    sections: ['Personal Info', 'Education', 'Experience', 'Skills', 'Summary'],
    formData: {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        dateOfBirth: '',
        address: '',
        city: '',
        country: '',
        linkedin: '',
        website: ''
    },
    selectOption(option) {
        this.selectedOption = option;
    },
    proceedToBuilder() {
        if (this.selectedOption === 'create') {
            this.currentPage = 'builder';
        } else if (this.selectedOption === 'upload') {
            // Handle upload logic here
            alert('Upload functionality will be implemented');
        }
    },
    nextSection() {
        if (this.currentSection < this.sections.length - 1) {
            this.currentSection++;
        }
    },
    prevSection() {
        if (this.currentSection > 0) {
            this.currentSection--;
        }
    },
    goToSection(index) {
        this.currentSection = index;
    }
}" class="min-h-screen bg-white relative">

    <!-- Close Button (Always Visible) -->
    <button
        @click="window.location.href = '{{ url('/test') }}'"
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
         class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#F2E9FF] to-[#FFE9F5] px-6 py-20">

        <div class="max-w-2xl w-full">
            <div class="text-center mb-12">
                <h1 class="font-['Playfair_Display'] text-5xl font-bold text-[#3A2F6A] mb-4">
                    Let's Get Started
                </h1>
                <p class="font-['Inter'] text-xl text-[#3A2F6A]/70">
                    Choose how you'd like to begin building your resume
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Create New Option -->
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
                        Create New Resume
                    </h3>
                    <p class="font-['Inter'] text-base text-[#3A2F6A]/70">
                        Start fresh with our guided builder and AI-powered suggestions
                    </p>
                </button>

                <!-- Upload Existing Option -->
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
                        Upload Existing Resume
                    </h3>
                    <p class="font-['Inter'] text-base text-[#3A2F6A]/70">
                        Import your current resume and enhance it with our tools
                    </p>
                </button>
            </div>

            <!-- Proceed Button -->
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
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="min-h-screen flex">

        <!-- Left Sidebar: Preview & Progress -->
        <div class="w-[35%] bg-gradient-to-br from-[#F2E9FF] to-[#FFE9F5] p-8 flex flex-col">
            <!-- Resume Preview -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 flex-shrink-0">
                <h3 class="font-['Poppins'] text-lg font-semibold text-[#3A2F6A] mb-4 text-center">
                    Preview
                </h3>
                <div class="bg-gray-50 rounded-lg p-6 min-h-[400px] border-2 border-dashed border-[#6A6CFF]/30">
                    <!-- Mini Resume Preview -->
                    <div class="space-y-4 text-sm">
                        <div class="text-center border-b pb-4">
                            <div class="font-bold text-xl text-[#3A2F6A]" x-text="formData.firstName || formData.lastName ? (formData.firstName + ' ' + formData.lastName) : 'Your Name'"></div>
                            <div class="text-xs text-gray-600 mt-2" x-show="formData.email" x-text="formData.email"></div>
                            <div class="text-xs text-gray-600" x-show="formData.phone" x-text="formData.phone"></div>
                            <div class="text-xs text-gray-600" x-show="formData.city || formData.country" x-text="(formData.city ? formData.city + ', ' : '') + formData.country"></div>
                        </div>
                        <div x-show="formData.linkedin || formData.website" class="text-xs space-y-1">
                            <div x-show="formData.linkedin" class="text-[#6A6CFF]">🔗 <span x-text="formData.linkedin"></span></div>
                            <div x-show="formData.website" class="text-[#6A6CFF]">🌐 <span x-text="formData.website"></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Indicator -->
            <div class="bg-white rounded-2xl shadow-xl p-6 flex-grow">
                <h3 class="font-['Poppins'] text-lg font-semibold text-[#3A2F6A] mb-6">
                    Your Progress
                </h3>
                <div class="space-y-3">
                    <template x-for="(section, index) in sections" :key="index">
                        <button
                            @click="goToSection(index)"
                            class="w-full flex items-center p-3 rounded-lg transition-all duration-300"
                            :class="index === currentSection ? 'bg-[#6A6CFF] text-white shadow-md' : index < currentSection ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 flex-shrink-0"
                                 :class="index === currentSection ? 'bg-white/20' : index < currentSection ? 'bg-green-500' : 'bg-gray-300'">
                                <span x-show="index < currentSection">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                                <span x-show="index >= currentSection" x-text="index + 1"></span>
                            </div>
                            <span class="font-['Inter'] font-medium" x-text="section"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="flex-1 bg-white p-12 overflow-y-auto">
            <div class="max-w-2xl mx-auto">
                <!-- Personal Info Section -->
                <div x-show="currentSection === 0"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-4"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="font-['Playfair_Display'] text-4xl font-bold text-[#3A2F6A] mb-3">
                        Personal Information
                    </h2>
                    <p class="font-['Inter'] text-lg text-gray-600 mb-8">
                        Let's start with the basics. Fill in your personal details below.
                    </p>

                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" x-model="formData.firstName"
                                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors"
                                       placeholder="John">
                            </div>
                            <div>
                                <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" x-model="formData.lastName"
                                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors"
                                       placeholder="Doe">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" x-model="formData.email"
                                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors"
                                       placeholder="john.doe@example.com">
                            </div>
                            <div>
                                <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" x-model="formData.phone"
                                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors"
                                       placeholder="+1 (555) 123-4567">
                            </div>
                        </div>

                        <div>
                            <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                Date of Birth
                            </label>
                            <input type="date" x-model="formData.dateOfBirth"
                                   class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors">
                        </div>

                        <div>
                            <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                Address
                            </label>
                            <input type="text" x-model="formData.address"
                                   class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors"
                                   placeholder="123 Main Street">
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                    City
                                </label>
                                <input type="text" x-model="formData.city"
                                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors"
                                       placeholder="New York">
                            </div>
                            <div>
                                <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                    Country
                                </label>
                                <input type="text" x-model="formData.country"
                                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors"
                                       placeholder="United States">
                            </div>
                        </div>

                        <div>
                            <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                LinkedIn Profile
                            </label>
                            <input type="url" x-model="formData.linkedin"
                                   class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors"
                                   placeholder="linkedin.com/in/johndoe">
                        </div>

                        <div>
                            <label class="block font-['Inter'] font-medium text-[#3A2F6A] mb-2">
                                Personal Website
                            </label>
                            <input type="url" x-model="formData.website"
                                   class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-[#6A6CFF] focus:outline-none transition-colors"
                                   placeholder="www.johndoe.com">
                        </div>
                    </form>
                </div>

                <!-- Placeholder for other sections -->
                <div x-show="currentSection > 0"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-4"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    <h2 class="font-['Playfair_Display'] text-4xl font-bold text-[#3A2F6A] mb-3"
                        x-text="sections[currentSection]">
                    </h2>
                    <p class="font-['Inter'] text-lg text-gray-600 mb-8">
                        This section is coming soon. For now, navigate through the sections to see the flow.
                    </p>
                    <div class="bg-[#F2E9FF] rounded-2xl p-12 text-center">
                        <svg class="w-24 h-24 mx-auto mb-4 text-[#6A6CFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <p class="text-[#3A2F6A] font-['Inter'] text-lg">
                            Form fields for <span class="font-bold" x-text="sections[currentSection]"></span> will be added here.
                        </p>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-12 pt-8 border-t-2 border-gray-100">
                    <button
                        @click="prevSection()"
                        x-show="currentSection > 0"
                        class="px-8 py-3 rounded-xl font-['Inter'] font-semibold text-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-all duration-300">
                        ← Previous
                    </button>
                    <div x-show="currentSection === 0"></div>

                    <button
                        @click="nextSection()"
                        x-show="currentSection < sections.length - 1"
                        class="px-8 py-3 rounded-xl font-['Inter'] font-semibold text-lg bg-[#6A6CFF] text-white hover:bg-[#5555FF] transition-all duration-300 shadow-lg hover:shadow-xl">
                        Next →
                    </button>
                    <button
                        x-show="currentSection === sections.length - 1"
                        class="px-8 py-3 rounded-xl font-['Inter'] font-semibold text-lg bg-green-500 text-white hover:bg-green-600 transition-all duration-300 shadow-lg hover:shadow-xl">
                        Complete Resume ✓
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@endsection
