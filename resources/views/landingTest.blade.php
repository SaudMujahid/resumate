@extends('layouts.home')

@section('content')
    {{-- Hero Section --}}
<section
    class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-center px-6 py-20 md:py-24"
>
    <div
        class="max-w-[550px] text-center md:text-left space-y-6"
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 200)"
    >
        <h1
            x-show="show"
            x-transition
            class="font-[Playfair_Display] text-[56px] md:text-[72px] font-bold leading-[1.2] text-[#1C1C3C] mb-4"
        >
            Build Your Dream Resume with AI
        </h1>

        <p
            x-show="show"
            x-transition.delay.150ms
            class="text-lg md:text-2xl text-[#1C1C3C]/80 mb-8"
        >
            Create a professional, job-winning resume in minutes. Let our AI write, enhance, and analyze your content so you can focus on landing your next opportunity.
        </p>

        <div class="flex justify-center md:justify-start gap-4">
            <a
                href="{{ route('register') }}"
                class="bg-[#FF6F61] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-[#FF8C7A] transition"
            >
                Get Started Free
            </a>
            <a
                href="#features"
                class="border border-[#1C1C3C] px-8 py-3 rounded-lg text-[#1C1C3C] font-semibold hover:bg-[#1C1C3C] hover:text-white transition"
            >
                Learn More
            </a>
        </div>
    </div>

    <div
        x-show="show"
        x-transition.duration.700ms
        class="w-full md:w-[520px] mt-10 md:mt-0 flex justify-center"
    >
        {{-- Animated Hero SVG --}}
        <div class="relative w-80 h-80 md:w-96 md:h-96 animate-float">
            <img
                src="{{ asset('images/undraw_screening-resumes_dh9s.svg') }}"
                alt="AI Resume Illustration"
                class="w-full h-full object-contain drop-shadow-lg"
            />
        </div>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
}
.animate-float {
    animation: float 5s ease-in-out infinite;
}
</style>

    {{-- Features Section --}}
    <section id="features" class="bg-[#F7D9F1] py-20">
        <div class="max-w-[1200px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-4xl md:text-5xl font-bold mb-4 text-[#1C1C3C]">Everything You Need to Land the Job</h2>
            <p class="font-[Inter] text-lg md:text-xl text-[#1C1C3C]/80 mb-12 max-w-[800px] mx-auto">
                Our smart tools combine AI and design excellence to create the ultimate resume experience.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Templates --}}
                <div class="bg-white rounded-2xl p-8 flex flex-col items-center text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#F7D9F1] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Smart Resume Templates</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">
                        Choose from dozens of clean, ATS-friendly templates built by hiring experts to impress recruiters instantly.
                    </p>
                </div>

                {{-- Analyzer --}}
                <div class="bg-white rounded-2xl p-8 flex flex-col items-center text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#F7D9F1] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">AI Resume Analyzer</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">
                        Upload your existing resume and get an instant score with feedback on keywords, tone, and formatting — powered by machine learning.
                    </p>
                </div>

                {{-- Formatting --}}
                <div class="bg-white rounded-2xl p-8 flex flex-col items-center text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#F7D9F1] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Auto-Formatting Engine</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">
                        Spend less time aligning margins. Our AI engine adjusts your layout for perfect spacing, style, and readability — instantly.
                    </p>
                </div>
            </div>

            {{-- CTA under features --}}
            <div class="mt-12 text-center">
                <p class="text-lg text-[#1C1C3C]/80 mb-4 max-w-[650px] mx-auto">
                    Why wait longer? Find out more about what our powerful AI-driven features can do for you.
                </p>
                <a href="{{ route('login') }}" class="inline-block bg-[#1C1C3C] text-white px-8 py-3 rounded-xl text-lg font-semibold hover:bg-[#FF6F61] transition-all duration-300 shadow-lg hover:shadow-xl">
                    Explore Features
                </a>
            </div>
        </div>
    </section>

    {{-- Templates Section --}}
    <section id="templates" class="bg-[#DAD9F7] py-20">
        <div class="max-w-[1200px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-4xl md:text-5xl font-bold mb-4 text-[#1C1C3C]">Professional Resume Templates</h2>
            <p class="text-lg md:text-xl mb-12 text-[#1C1C3C]/80 max-w-[800px] mx-auto">
                Pick from styles that recruiters love. Designed for clarity, professionalism, and elegance.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Modern --}}
                <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#DAD9F7] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Modern</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">Clean lines, subtle colors, and great readability. Ideal for tech and design professionals.</p>
                </div>

                {{-- Classic --}}
                <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#DAD9F7] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Classic</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">Timeless layout trusted by recruiters in corporate, law, and academic industries.</p>
                </div>

                {{-- Creative --}}
                <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-20 h-20 mb-5 bg-[#DAD9F7] rounded-full flex items-center justify-center">
                        <svg class="w-11 h-11 text-[#1C1C3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 text-[#1C1C3C]">Creative</h3>
                    <p class="text-base text-[#1C1C3C]/80 leading-relaxed">Bold, vibrant, and personal. Perfect for marketing, media, and creative arts fields.</p>
                </div>
            </div>

            {{-- CTA under templates --}}
            <div class="mt-12 text-center">
                <p class="text-lg text-[#1C1C3C]/80 mb-4 max-w-[750px] mx-auto">
                    We currently offer popular templates like <strong>Classic</strong>, <strong>Modern</strong>, <strong>Minimalist</strong>, <strong>Elegant</strong>, and <strong>Creative</strong>.
                    But don't worry — we're actively working to add even more designs to suit your needs.
                </p>
                <a href="{{ url('/test') }}" class="inline-block bg-[#1C1C3C] text-white px-8 py-3 rounded-xl text-lg font-semibold hover:bg-[#FF6F61] transition-all duration-300 shadow-lg hover:shadow-xl">
                    View All Templates
                </a>
            </div>
        </div>
    </section>


    {{-- CTA Final --}}
    <section class="bg-[#FFE1AF] py-20 text-center">
        <div class="max-w-[850px] mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-[Playfair_Display] mb-4 text-[#1C1C3C]">Ready to Build Your Resume?</h2>
            <p class="text-lg md:text-xl text-[#1C1C3C]/80 mb-8">Start creating your AI-powered resume today. It's fast, easy, and free to begin.</p>
            <a href="{{ route('register') }}" class="inline-block bg-[#FF6F61] text-white px-10 py-4 rounded-lg text-lg font-semibold hover:bg-[#FF8C7A] transition-all duration-300 shadow-lg hover:shadow-xl">
                Get Started Free
            </a>
            <p class="text-sm text-[#1C1C3C]/60 mt-6">
                Have suggestions? Contact us via the details at the bottom — we'd love your feedback.
            </p>
        </div>
    </section>
@endsection
