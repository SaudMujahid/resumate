@extends('layouts.home')

@section('content')
<div class="bg-[#FFFFF7] min-h-screen relative overflow-hidden">
    <!-- Container (857px wide on desktop) -->
    <div class="max-w-[857px] mx-auto px-4 py-12 md:py-20">

        <!-- Main Heading -->
        <h1 class="text-3xl md:text-[40px] font-bold leading-[39px] text-cyan-700 max-w-[542px] mb-4 text-center mx-auto"
            x-data
            x-intersect.once="$el.classList.add('slide-in-up')">
            AI Resume Builder & Rating System
        </h1>

        <!-- Subheading -->
        <p class="text-lg md:text-2xl font-normal leading-7 text-black/60 max-w-[649px] mb-12 text-center mx-auto"
            x-data
            x-intersect.once="$el.classList.add('fade-in-up')">
            Create professional resumes quickly with our AI-powered builder and get instant ratings to improve your resume
        </p>

        <!-- Feature Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16"
             x-data
             x-intersect.once="$el.classList.add('animate-fade-in')">

            <!-- Card 1: Smart Templates -->
            <div class="bg-[#E8F9FF] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1"
                 x-data
                 x-intersect.once="$el.classList.add('slide-in-left')">
                <h3 class="text-2xl font-bold leading-7 text-black font-['Inter']">Smart Templates</h3>
                <p class="mt-4 text-xl font-normal leading-6 text-black/60 max-w-[370px] font-['Inter']">
                    Choose from a variety of professional resume templates optimized for different industries
                </p>
            </div>

            <!-- Card 2: AI-Powered Ratings -->
            <div class="bg-[#A1E3F9] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1"
                 x-data
                 x-intersect.once="$el.classList.add('scale-in')">
                <h3 class="text-2xl font-bold leading-7 text-black font-['Inter']">AI-Powered Ratings</h3>
                <p class="mt-4 text-xl font-normal leading-6 text-black/60 max-w-[227px] font-['Inter']">
                    Get instant feedback on your resume with our AI-powered rating system
                </p>
            </div>

            <!-- Card 3: Tailored Suggestions -->
            <div class="bg-[#9EC6F3] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1"
                 x-data
                 x-intersect.once="$el.classList.add('slide-in-right')">
                <h3 class="text-2xl font-bold leading-7 text-black font-['Inter']">Tailored Suggestions</h3>
                <p class="mt-4 text-xl font-normal leading-6 text-black/60 max-w-[201px] font-['Inter']">
                    Receive personalized recommendations to improve your resume each time you use it
                </p>
            </div>
        </div>

        <!-- CTA Button (Optional - Centered Below Cards) -->
        <div class="mb-6 text-center"
             x-data
             x-intersect.once="$el.classList.add('fade-in-up')">
            <a href="{{ route('register') }}"
               class="inline-block bg-gradient-to-r from-[#7FA1C3] to-[#6482AD] hover:from-[#3674B5] hover:to-[#3674B5] text-white font-bold text-xl px-10 py-4 rounded-2xl transform transition-all duration-300 hover:scale-105 hover:shadow-xl font-['Poppins']">
                Start Building Now
            </a>
        </div>
        <!-- Supporting Text -->
        <p class="text-lg md:text-2xl font-normal leading-7 text-black/60 max-w-[649px] mb-12 text-center mx-auto">
            AI resumes that beat ATS. Modern. Free. Done in minutes.
        </p>
    </div>


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
