@extends('layouts.home')

@section('content')
<div class="min-h-screen bg-[rgba(251,241,255,0.98)] py-12">
    <div class="max-w-[1440px] mx-auto px-6">

        <!-- Header Section -->
        <div class="text-center mb-16">
            <h1 class="font-['Poppins'] font-bold text-[44px] leading-[66px] text-[#222222] mb-4">
                Explore Our Templates
            </h1>
            <p class="font-['Inter'] font-normal text-[18px] leading-[22px] text-[#555555]">
                Choose from a variety of designs to get started instantly.
            </p>
        </div>


        <!-- Templates Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-[1200px] mx-auto">

            <!-- Template 1: Chronological -->
            <div class="relative">
                <div class="bg-[rgba(217,182,255,0.61)] rounded-2xl p-8 h-[320px] flex flex-col justify-between">

                    <!-- Popular Badge -->
                    <div class="absolute -top-3 left-6">
                        <div class="bg-[rgba(195,106,255,0.86)] rounded-2xl px-6 py-2">
                            <span class="font-['Inter'] font-bold text-[20px] leading-[24px] text-[#FFFFFF]">Popular</span>
                        </div>
                    </div>

                    <!-- Image Placeholder -->
                    <div class="bg-white/30 rounded-2xl h-[120px] mb-4 mt-12 flex items-center justify-center">
                    <svg class="w-16 h-16 text-[#222222] opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        </div>

                    <!-- Content -->
                    <div>
                        <h3 class="font-['Poppins'] font-bold text-[26px] leading-[39px] text-[#222222] mb-2">
                            Chronological
                        </h3>
                        <p class="font-['Inter'] font-medium text-[20px] leading-[24px] text-[#1E1E1E] mb-4">
                            A content-focused layout for showing projects.
                        </p>

                        <!-- Use Template Button -->
                        <form action="{{ route('resumebuilder') }}" method="GET">
    <input type="hidden" name="template" value="chronological">
    <button type="submit" class="...">Use Template</button>
</form>
                    </div>
                </div>
            </div>

            <!-- Template 2: Modern -->
            <div class="relative">
                <div class="bg-[#E1E4FF] rounded-2xl p-8 h-[320px] flex flex-col justify-between">

                    <!-- New Badge -->
                    <div class="absolute -top-3 left-6">
                        <div class="bg-[rgba(106,136,255,0.89)] rounded-2xl px-6 py-2">
                            <span class="font-['Inter'] font-bold text-[20px] leading-[24px] text-[#FFFFFF]">New</span>
                        </div>
                    </div>

                    <!-- Image Placeholder -->
                    <div class="bg-white/30 rounded-2xl h-[120px] mb-4 mt-12 flex items-center justify-center">
<svg class="w-16 h-16 text-[#222222] opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>

                    <!-- Content -->
                    <div>
                        <h3 class="font-['Poppins'] font-bold text-[26px] leading-[39px] text-[#222222] mb-2">
                            Modern
                        </h3>
                        <p class="font-['Inter'] font-medium text-[20px] leading-[24px] text-[#1E1E1E] mb-4">
                            A professional layout with a modern design.
                        </p>

                        <!-- Use Template Button -->
                <form action="{{ route('resumebuilder') }}" method="GET">
                    <input type="hidden" name="template" value="modern">
                    <button type="submit" class="...">Use Template</button>
                </form>
                    </div>
                </div>
            </div>

            <!-- Template 3: Minimalistic -->
            <div class="relative">
                <div class="bg-[#FCE3E3] rounded-2xl p-8 h-[320px] flex flex-col justify-between">

                    <!-- Free Badge -->
                    <div class="absolute -top-3 left-6">
                        <div class="bg-[rgba(255,107,139,0.79)] rounded-2xl px-6 py-2">
                            <span class="font-['Inter'] font-bold text-[20px] leading-[24px] text-[#FFFFFF]">Basic</span>
                        </div>
                    </div>

                    <!-- Image Placeholder -->
                    <div class="bg-white/30 rounded-2xl h-[120px] mb-4 mt-12 flex items-center justify-center">
     <svg class="w-16 h-16 text-[#222222] opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"></path>
                        </svg>
                    </div>

                    <!-- Content -->
                    <div>
                        <h3 class="font-['Poppins'] font-bold text-[26px] leading-[39px] text-[#222222] mb-2">
                            Minimalistic
                        </h3>
                        <p class="font-['Inter'] font-medium text-[20px] leading-[24px] text-[#1E1E1E] mb-4">
                            A simple, clean layout to highlight your profile.
                        </p>

                        <!-- Use Template Button -->
                <form action="{{ route('resumebuilder') }}" method="GET">
                    <input type="hidden" name="template" value="minimal">
                    <button type="submit" class="...">Use Template</button>
                </form>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

@endsection
