@extends('layouts.home')

@section('content')
<div x-data="{
    activeTab: 'business',
    templates: {
        business: [
            {
                title: 'Business Portfolio',
                description: 'A professional business layout with a modern design.',
                popular: true,
                previewUrl: '#',
                useUrl: '#'
            },
            {
                title: 'Consulting Firm',
                description: 'A sleek and reliable layout for consulting firms.',
                popular: false,
                previewUrl: '#',
                useUrl: '#'
            },
            {
                title: 'Startup',
                description: 'A clean and simple layout for new businesses.',
                popular: false,
                previewUrl: '#',
                useUrl: '#'
            }
        ],
        personal: [
            {
                title: 'Creative Portfolio',
                description: 'Minimal layout for designers and photographers.',
                new: true,
                previewUrl: '#',
                useUrl: '#'
            },
            {
                title: 'Showcase Portfolio',
                description: 'Perfect for artists, illustrators and creatives.',
                new: false,
                previewUrl: '#',
                useUrl: '#'
            },
            {
                title: 'Personal Portfolio',
                description: 'Write, share and grow your voice online.',
                new: false,
                previewUrl: '#',
                useUrl: '#'
            }
        ]
    }
}"
class="min-h-screen transition-colors duration-500"
:class="activeTab === 'business' ? 'bg-[#FFE9D1]' : 'bg-[#F2E9FF]'">

    <!-- Header Section -->
    <div class="container mx-auto px-4 py-12">
        <!-- Toggle Buttons -->
        <div class="flex justify-center mb-8">
            <div class="inline-flex rounded-2xl p-2 shadow-lg"
                :class="activeTab === 'business' ? 'bg-white/40' : 'bg-white/30'">
                <button
                    @click="activeTab = 'business'"
                    class="px-8 py-3 rounded-xl font-semibold text-lg transition-all duration-300 transform"
                    :class="activeTab === 'business'
                        ? 'bg-[#FDB058] text-white shadow-md scale-105'
                        : 'text-[#4B3B00] hover:bg-white/30'">
                    For Businesses
                </button>
                <button
                    @click="activeTab = 'personal'"
                    class="px-8 py-3 rounded-xl font-semibold text-lg transition-all duration-300 transform"
                    :class="activeTab === 'personal'
                        ? 'bg-[#6A6CFF] text-white shadow-md scale-105'
                        : 'text-[#3A2F6A] hover:bg-white/30'">
                    For Personal
                </button>
            </div>
        </div>

        <!-- Business Templates Section -->
        <div x-show="activeTab === 'business'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="text-center">
            <h1 class="font-['Poppins'] font-bold text-[44px] leading-[66px] text-[#4B3B00] mb-4">
                Business Templates
            </h1>
            <p class="font-['Inter'] font-normal text-2xl leading-[29px] text-[#5C4E12] mb-16">
                Perfect for startups and companies.
            </p>

            <!-- Business Template Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto px-8">
                <template x-for="(template, index) in templates.business" :key="index">
                    <div class="relative group">
                        <!-- Outer Container -->
                        <div class="bg-[rgba(253,176,88,0.3)] rounded-lg p-8 h-[460px] flex flex-col justify-between transition-transform duration-300 hover:scale-105">
                            <!-- Popular Badge -->
                            <div class="absolute -top-3 left-6" x-show="template.popular">
                                <div class="bg-[#FD9D58] rounded-2xl px-5 py-2">
                                    <span class="font-['Inter'] font-bold text-xl text-white">Popular</span>
                                </div>
                            </div>

                            <!-- Image Placeholder -->
                            <div class="bg-[rgba(253,203,88,0.69)] rounded-2xl h-[193px] mb-auto mt-8 flex items-center justify-center transition-all duration-300 group-hover:shadow-xl">
                                <svg class="w-16 h-16 text-[#4B3B00] opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>

                            <!-- Content -->
                            <div class="text-left mt-6">
                                <h3 class="font-['Poppins'] font-semibold text-[28px] leading-[42px] text-[#4B3B00] mb-2"
                                    x-text="template.title"></h3>
                                <p class="font-['Inter'] font-medium text-2xl leading-[29px] text-[#5C4E12] mb-6"
                                   x-text="template.description"></p>

                                <!-- Action Buttons -->
                                <div class="flex gap-4">
                                    <a :href="template.previewUrl"
                                       class="bg-[rgba(106,141,255,0.83)] hover:bg-[rgba(106,141,255,1)] rounded-2xl px-6 py-2.5 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                        <span class="font-['Inter'] font-bold text-xl text-white">Preview</span>
                                    </a>
                                    <a :href="template.useUrl"
                                       class="bg-[#FFAD60] hover:bg-[#FF9A40] rounded-2xl px-6 py-2.5 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                        <span class="font-['Inter'] font-bold text-xl text-white">Use Template</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Personal/Portfolio Templates Section -->
        <div x-show="activeTab === 'personal'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="text-center">
            <h1 class="font-['Poppins'] font-bold text-[44px] leading-[66px] text-[#3A2F6A] mb-4">
                Portfolio Templates
            </h1>
            <p class="font-['Inter'] font-normal text-2xl leading-[29px] text-[#1E1E1E] mb-16">
                Showcase your work beautifully.
            </p>

            <!-- Portfolio Template Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto px-8">
                <template x-for="(template, index) in templates.personal" :key="index">
                    <div class="relative group">
                        <!-- Outer Container -->
                        <div class="bg-[rgba(106,47,88,0.19)] rounded-lg p-8 h-[460px] flex flex-col justify-between transition-transform duration-300 hover:scale-105">
                            <!-- New Badge -->
                            <div class="absolute -top-3 left-6" x-show="template.new">
                                <div class="bg-[#6A6CFF] rounded-2xl px-5 py-2">
                                    <span class="font-['Inter'] font-bold text-xl text-white">New</span>
                                </div>
                            </div>

                            <!-- Image Placeholder -->
                            <div class="bg-[rgba(255,107,139,0.22)] rounded-2xl h-[180px] mb-auto mt-8 flex items-center justify-center transition-all duration-300 group-hover:shadow-xl">
                                <svg class="w-16 h-16 text-[#3A2F6A] opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>

                            <!-- Content -->
                            <div class="text-left mt-6">
                                <h3 class="font-['Poppins'] font-semibold text-[32px] leading-[48px] text-[#1E1E1E] mb-2"
                                    x-text="template.title"></h3>
                                <p class="font-['Inter'] font-medium text-2xl leading-[29px] text-[#1E1E1E] mb-6"
                                   x-text="template.description"></p>

                                <!-- Action Buttons -->
                                <div class="flex gap-4">
                                    <a :href="template.previewUrl"
                                       class="bg-[#6A6CFF] hover:bg-[#5555FF] rounded-2xl px-6 py-2.5 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                        <span class="font-['Inter'] font-bold text-xl text-white">Preview</span>
                                    </a>
                                    <a :href="template.useUrl"
                                       class="bg-[rgba(255,107,139,0.81)] hover:bg-[rgba(255,107,139,1)] rounded-2xl px-6 py-2.5 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                        <span class="font-['Inter'] font-bold text-xl text-white">Use Template</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@endsection
