@extends('layouts.home')

@section('content')
<div class="bg-white min-h-screen relative overflow-hidden">
    <!-- Container -->
    <div class="max-w-[857px] mx-auto px-4 py-12 md:py-20">

        <!-- Main Heading -->
        <h1 class="text-3xl md:text-[40px] font-bold leading-tight text-emerald-700 max-w-[700px] mb-6 text-center mx-auto">
            Resumate's Mission
        </h1>

        <!-- Subheading -->
        <p class="text-lg md:text-2xl font-normal leading-7 text-black/60 max-w-[649px] mb-12 text-center mx-auto">
            Our mission is to simplify and strengthen the process of resume creation for students, job seekers, and professionals by integrating artificial intelligence and machine learning into one intuitive platform.
        </p>

        <!-- Feature Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 mb-16">

            <!-- Card 1: The Challenge -->
            <div class="bg-[#F1F3E0] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                <h3 class="text-2xl font-bold leading-7 text-black font-['Inter']">
                    The Challenge
                </h3>
                <p class="mt-4 text-xl font-normal leading-6 text-black/60 max-w-[201px] font-['Inter']">
                    Traditional builders: rigid formats, overwhelming options, paywalls, zero design freedom.
                </p>
            </div>

            <!-- Card 2: Our Solution -->
            <div class="bg-[#D2DCB6] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                <h3 class="text-2xl font-bold leading-7 text-black font-['Inter']">
                    Real Results
                </h3>
                <p class="mt-4 text-xl font-normal leading-6 text-black/60 max-w-[201px] font-['Inter']">
                    You give us your experience. We build resumes that get interviews
                </p>
            </div>

            <!-- Card 3: What You Get -->
            <div class="bg-[#A1BC98] rounded-[29px] p-6 flex flex-col items-center text-center h-[226px] relative transform transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                <h3 class="text-2xl font-bold leading-7 text-black font-['Inter']">
                    Transform Your Career?
                </h3>
                <p class="mt-4 text-xl font-normal leading-6 text-black/60 max-w-[201px] font-['Inter']">
                    Pick a template, customize freely, see your score—instantly. No fees
                </p>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="text-center mb-6">
            <a href="{{ route('register') }}"
               class="inline-block bg-gradient-to-r from-[#5D866C] to-[#5D866C] hover:from-[#72BF78] hover:to-[#72BF78] text-white font-bold text-xl px-10 py-4 rounded-2xl transform transition-all duration-300 hover:scale-105 hover:shadow-xl font-['Poppins']">
                Get Started Immediately
            </a>
        </div>

        <!-- Supporting Text -->
        <p class="text-lg md:text-2xl font-normal leading-7 text-black/60 max-w-[649px] mb-12 text-center mx-auto">
            We win only when you get hired. No paywalls. Ever.
        </p>
    </div>
</div>
@endsection
