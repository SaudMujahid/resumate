@extends('layouts.home')

@section('content')
<div class="bg-[#FFFFF7] min-h-screen relative overflow-hidden">
    <!-- Container (857px wide on desktop) -->
    <div class="max-w-[857px] mx-auto px-4 py-12 md:py-20">

        <!-- Features Badge -->
        <div class="inline-block bg-[#E4F3E3] rounded-[24px] px-6 py-3 mb-8"
             x-data
             x-intersect.once="$el.classList.add('slide-in-left')">
            <span class="text-3xl font-semibold text-black font-['Inter']">Features</span>
        </div>

        <!-- Main Heading -->
        <h1 class="text-3xl md:text-[32px] font-semibold leading-[39px] text-black max-w-[542px] mb-4"
            x-data
            x-intersect.once="$el.classList.add('slide-in-up')">
            AI Resume Builder & Rating System
        </h1>

        <!-- Subheading -->
        <p class="text-lg md:text-2xl font-normal leading-7 text-black/60 max-w-[649px] mb-12"
            x-data
            x-intersect.once="$el.classList.add('fade-in-up')">
            Create professional resumes quickly with our AI-powered builder and get instant ratings to improve your resume
        </p>

        <!-- Feature Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6"
             x-data
             x-intersect.once="$el.classList.add('animate-fade-in')">

            <!-- Card 1: Smart Templates -->
            <div class="bg-[#E8F4FC] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1"
                 x-data
                 x-intersect.once="$el.classList.add('slide-in-left')">
                <img src="{{ asset('images/stack.png') }}" alt="Smart Templates" class="w-10 h-10 absolute -top-4 left-4">
                <h3 class="mt-12 text-2xl font-normal leading-7 text-black font-['Inter']">Smart Templates</h3>
                <p class="mt-4 text-xl font-normal leading-6 text-black/60 max-w-[370px] font-['Inter']">
                    Choose from a variety of professional resume templates optimized for different industries
                </p>
            </div>

            <!-- Card 2: AI-Powered Ratings -->
            <div class="bg-[#FEF0DD] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1"
                 x-data
                 x-intersect.once="$el.classList.add('scale-in')">
                <img src="{{ asset('images/interest.png') }}" alt="AI Ratings" class="w-10 h-10 absolute -top-4 left-4">
                <h3 class="mt-12 text-2xl font-normal leading-7 text-black font-['Inter']">AI-Powered Ratings</h3>
                <p class="mt-4 text-xl font-normal leading-6 text-black/60 max-w-[227px] font-['Inter']">
                    Get instant feedback on your resume with our AI-powered rating system
                </p>
            </div>

            <!-- Card 3: Tailored Suggestions -->
            <div class="bg-[#E4F3E3] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1"
                 x-data
                 x-intersect.once="$el.classList.add('slide-in-right')">
                <img src="{{ asset('images/solution.png') }}" alt="Suggestions" class="w-10 h-10 absolute -top-4 left-4">
                <h3 class="mt-12 text-2xl font-normal leading-7 text-black font-['Inter']">Tailored Suggestions</h3>
                <p class="mt-4 text-xl font-normal leading-6 text-black/60 max-w-[201px] font-['Inter']">
                    Receive personalized recommendations to improve your resume each time you use it
                </p>
            </div>
        </div>

        <!-- CTA Button (Optional - Centered Below Cards) -->
        <div class="mt-16 text-center"
             x-data
             x-intersect.once="$el.classList.add('fade-in-up')">
            <a href="{{ route('register') }}"
               class="inline-block bg-gradient-to-r from-[#5a9e3a] to-[#4a8030] hover:from-[#4a8030] hover:to-[#3a6020] text-white font-bold text-xl px-10 py-4 rounded-2xl transform transition-all duration-300 hover:scale-105 hover:shadow-xl font-['Poppins']">
                Start Building Now
                <svg class="inline-block w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Decorative Background Shapes -->
    <!-- Left Large Shape -->
    <div class="absolute -left-40 top-[638px] w-96 h-84 bg-[#E8F5FB] rounded-[29px] -z-10 hidden md:block"></div>
    <!-- Right Large Shape -->
    <div class="absolute left-full -ml-40 top-[592px] w-96 h-84 bg-[#0088FF]/19 rounded-[29px] -z-10 hidden md:block"></div>
</div>
@endsection

@push('styles')
<style>
    @import url('https://rsms.me/inter/inter.css');
    body { font-family: 'Inter', system-ui, sans-serif; }

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
    .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    .slide-in-up { animation: slideInUp 0.6s ease-out forwards; }
    .slide-in-left { animation: slideInLeft 0.6s ease-out forwards; }
    .slide-in-right { animation: slideInRight 0.6s ease-out forwards; }
    .scale-in { animation: scaleIn 0.6s ease-out forwards; }
    .fade-in-up { animation: fadeIn 1s ease-out forwards; }
</style>
@endpush

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
