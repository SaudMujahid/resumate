@extends('layouts.home')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-[#FFFFF7]">
    <div class="max-w-[857px] mx-auto px-4 py-12 md:py-20">

        <!-- Header Section -->
        <h1 class="text-3xl md:text-[40px] font-bold leading-[39px] text-rose-400 max-w-[542px] mb-4 text-center mx-auto">
            Explore Our Templates
        </h1>
        <p class="text-lg md:text-2xl font-normal leading-7 text-black/60 max-w-[649px] mb-12 text-center mx-auto">
            Choose from a variety of designs to get started instantly.
        </p>

        <!-- SINGLE Alpine.js component wrapping both templates AND button -->
        <div x-data="{ selectedTemplate: '' }" x-intersect.once="$el.classList.add('animate-fade-in')">

            <!-- Templates Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16">

                <!-- Template 1: Chronological -->
                <div class="relative cursor-pointer"
                     @click="selectedTemplate = 'chronological'">
                    <div class="bg-[rgba(217,182,255,0.61)] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1"
                         :class="selectedTemplate === 'chronological' ? 'ring-4 ring-[rgba(195,106,255,0.86)] scale-105' : ''">

                        <!-- Popular Badge -->
                        <div class="absolute -top-3 left-6">
                            <div class="bg-[rgba(195,106,255,0.86)] rounded-2xl px-6 py-2">
                                <span class="font-['Inter'] font-bold text-[20px] leading-[24px] text-[#FFFFFF]">Popular</span>
                            </div>
                        </div>

                        <!-- Selected Checkmark -->
                        <div class="absolute top-4 right-4"
                             x-show="selectedTemplate === 'chronological'"
                             x-transition>
                            <svg class="w-8 h-8 text-[rgba(195,106,255,0.86)]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="mt-6">
                            <h3 class="font-['Poppins'] font-bold text-[26px] leading-[39px] text-[#222222] mb-2">
                                Chronological
                            </h3>
                            <p class="font-['Inter'] font-medium text-[20px] leading-[24px] text-[#1E1E1E]">
                                A content-focused layout for showing projects.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Template 2: Modern -->
                <div class="relative cursor-pointer"
                     @click="selectedTemplate = 'modern'">
                    <div class="bg-[#E1E4FF] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1"
                         :class="selectedTemplate === 'modern' ? 'ring-4 ring-[rgba(106,136,255,0.89)] scale-105' : ''">

                        <!-- New Badge -->
                        <div class="absolute -top-3 left-6">
                            <div class="bg-[rgba(106,136,255,0.89)] rounded-2xl px-6 py-2">
                                <span class="font-['Inter'] font-bold text-[20px] leading-[24px] text-[#FFFFFF]">New</span>
                            </div>
                        </div>

                        <!-- Selected Checkmark -->
                        <div class="absolute top-4 right-4"
                             x-show="selectedTemplate === 'modern'"
                             x-transition>
                            <svg class="w-8 h-8 text-[rgba(106,136,255,0.89)]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="mt-6">
                            <h3 class="font-['Poppins'] font-bold text-[26px] leading-[39px] text-[#222222] mb-2">
                                Modern
                            </h3>
                            <p class="font-['Inter'] font-medium text-[20px] leading-[24px] text-[#1E1E1E]">
                                A professional layout with a modern design.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Template 3: Minimalistic -->
                <div class="relative cursor-pointer"
                     @click="selectedTemplate = 'minimal'">
                    <div class="bg-[#FCE3E3] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1"
                         :class="selectedTemplate === 'minimal' ? 'ring-4 ring-[rgba(255,107,139,0.79)] scale-105' : ''">

                        <!-- Basic Badge -->
                        <div class="absolute -top-3 left-6">
                            <div class="bg-[rgba(255,107,139,0.79)] rounded-2xl px-6 py-2">
                                <span class="font-['Inter'] font-bold text-[20px] leading-[24px] text-[#FFFFFF]">Basic</span>
                            </div>
                        </div>

                        <!-- Selected Checkmark -->
                        <div class="absolute top-4 right-4"
                             x-show="selectedTemplate === 'minimal'"
                             x-transition>
                            <svg class="w-8 h-8 text-[rgba(255,107,139,0.79)]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="mt-6">
                            <h3 class="font-['Poppins'] font-bold text-[26px] leading-[39px] text-[#222222] mb-2">
                                Minimalistic
                            </h3>
                            <p class="font-['Inter'] font-medium text-[20px] leading-[24px] text-[#1E1E1E]">
                                A simple, clean layout to highlight your profile.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Proceed Button (now inside the same Alpine component) -->
            <div class="text-center">
                <form action="{{ route('resumebuilder') }}" method="GET"
                      x-ref="proceedForm"
                      @submit.prevent="if(selectedTemplate) { $refs.templateInput.value = selectedTemplate; $refs.proceedForm.submit(); } else { alert('Please select a template first'); }">
                    <input type="hidden" name="template" x-ref="templateInput">

                    <button type="submit"
                            class="inline-block bg-rose-400 hover:bg-rose-500 text-white font-['Poppins'] font-semibold text-[24px] px-16 py-4 rounded-[42px] transform transition-all duration-300 hover:scale-105 hover:shadow-2xl disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!selectedTemplate"
                            :class="selectedTemplate ? 'opacity-100' : 'opacity-60'">
                        Proceed
                        <svg class="inline-block w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </form>

                <!-- Helper text -->
                <p class="mt-4 text-sm text-black/60"
                   x-show="!selectedTemplate"
                   x-transition>
                    Select a template to continue
                </p>
                <p class="mt-4 text-sm text-rose-400 font-medium"
                   x-show="selectedTemplate"
                   x-transition>
                    <span x-text="selectedTemplate.charAt(0).toUpperCase() + selectedTemplate.slice(1)"></span> template selected
                </p>
            </div>

        </div><!-- End of single Alpine component -->

    </div>
</div>

@endsection

@push('styles')
<style>
    @import url('https://rsms.me/inter/inter.css');
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    body { font-family: 'Inter', system-ui, sans-serif; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
</style>
@endpush

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
