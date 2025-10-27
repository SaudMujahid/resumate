@extends('layouts.home')

@section('content')
<div class="bg-[#ddf6d2] min-h-screen">

    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto text-center mb-16"
             x-data
             x-intersect="$el.classList.add('animate-fade-in')">
            <h1 class="text-5xl md:text-6xl font-bold text-[#2d5016] mb-6 font-['Poppins']">
                Our Mission
            </h1>
            <div class="w-24 h-1 bg-[#5a9e3a] mx-auto rounded-full"></div>
        </div>

        <!-- Mission Statement -->
        <div class="max-w-5xl mx-auto space-y-12">

            <!-- Main Statement -->
            <div class="bg-white rounded-3xl shadow-lg p-8 md:p-12 transform transition-all duration-500 hover:shadow-2xl"
                 x-data
                 x-intersect="$el.classList.add('slide-in-up')">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0 w-16 h-16 bg-[#5a9e3a] rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold text-[#2d5016] mb-4 font-['Poppins']">
                            Empowering Your Career Journey
                        </h2>
                        <p class="text-lg text-gray-700 leading-relaxed font-['Inter']">
                            Our mission is to simplify and strengthen the process of resume creation for students, job seekers, and professionals by integrating artificial intelligence and machine learning into one intuitive platform.
                        </p>
                    </div>
                </div>
            </div>

            <!-- The Problem -->
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl shadow-lg p-8 transform transition-all duration-500 hover:shadow-2xl"
                     x-data
                     x-intersect.once="$el.classList.add('slide-in-left')">
                    <div class="w-14 h-14 bg-[#ff6b6b] bg-opacity-20 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-[#ff6b6b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-[#2d5016] mb-4 font-['Poppins']">
                        The Challenge
                    </h3>
                    <p class="text-gray-700 leading-relaxed font-['Inter']">
                        Traditional resume builders often focus only on layout and design, leaving users uncertain about the actual effectiveness of their content. Many struggle to tailor their resumes to specific job descriptions, resulting in missed opportunities despite having strong skills.
                    </p>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-8 transform transition-all duration-500 hover:shadow-2xl"
                     x-data
                     x-intersect.once="$el.classList.add('slide-in-right')">
                    <div class="w-14 h-14 bg-[#5a9e3a] bg-opacity-20 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-[#5a9e3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-[#2d5016] mb-4 font-['Poppins']">
                        Our Solution
                    </h3>
                    <p class="text-gray-700 leading-relaxed font-['Inter']">
                        Resumate addresses these challenges by providing not just smart resume templates, but also intelligent, data-driven feedback. We turn complexity into clarity, empowering you to create resumes that truly stand out.
                    </p>
                </div>
            </div>

            <!-- AI-Powered Features -->
            <div class="bg-gradient-to-br from-[#5a9e3a] to-[#4a8030] rounded-3xl shadow-2xl p-8 md:p-12 text-white"
                 x-data
                 x-intersect.once="$el.classList.add('scale-in')">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0 w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold mb-4 font-['Poppins']">
                            Intelligent AI-Powered Rating System
                        </h2>
                        <p class="text-lg leading-relaxed font-['Inter'] text-white/90">
                            Through our AI-powered rating system, users receive a score based on content quality, keyword relevance, and structure—helping them understand where they stand and how to improve.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Impact Statement -->
            <div class="bg-white rounded-3xl shadow-lg p-8 md:p-12 transform transition-all duration-500 hover:shadow-2xl"
                 x-data
                 x-intersect.once="$el.classList.add('slide-in-up')">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0 w-16 h-16 bg-[#ffd93d] bg-opacity-30 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-[#d4a500]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold text-[#2d5016] mb-4 font-['Poppins']">
                            Actionable Insights, Real Results
                        </h2>
                        <p class="text-lg text-gray-700 leading-relaxed font-['Inter']">
                            By turning feedback into actionable insights, we empower individuals to refine their communication, align their resumes with industry expectations, and enhance their employability with confidence.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- CTA Section -->
        <div class="max-w-4xl mx-auto mt-20 text-center"
             x-data
             x-intersect.once="$el.classList.add('fade-in-up')">
            <div class="bg-white rounded-3xl shadow-2xl p-12 md:p-16">
                <h2 class="text-4xl font-bold text-[#2d5016] mb-6 font-['Poppins']">
                    Ready to Transform Your Career?
                </h2>
                <p class="text-xl text-gray-700 mb-8 font-['Inter']">
                    Join thousands of professionals who are already creating powerful, AI-optimized resumes with Resumate.
                </p>
                <a href="{{ route('register') }}"
                   class="inline-block bg-gradient-to-r from-[#5a9e3a] to-[#4a8030] hover:from-[#4a8030] hover:to-[#3a6020] text-white font-bold text-xl px-12 py-5 rounded-2xl transform transition-all duration-300 hover:scale-105 hover:shadow-2xl font-['Poppins']">
                    Get Started Immediately
                    <svg class="inline-block w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>

    </div>

</div>

@push('styles')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-40px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(40px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }

    .slide-in-up {
        animation: slideInUp 0.6s ease-out forwards;
    }

    .slide-in-left {
        animation: slideInLeft 0.6s ease-out forwards;
    }

    .slide-in-right {
        animation: slideInRight 0.6s ease-out forwards;
    }

    .scale-in {
        animation: scaleIn 0.6s ease-out forwards;
    }

    .fade-in-up {
        animation: fadeIn 1s ease-out forwards;
    }
</style>
@endpush

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@endsection
