@extends('layouts.home')

@section('content')
    {{-- Hero Section --}}
    <section class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-center px-6 py-24">
        <div class="max-w-[550px] text-center md:text-left space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)">
            <h1 x-show="show" x-transition
                class="font-[Playfair_Display] text-[64px] md:text-[80px] font-bold leading-[1.2] text-[#1C1C3C] mb-4">
                Build Your Dream Resume with AI
            </h1>

            <p x-show="show" x-transition.delay.150ms
               class="text-lg md:text-2xl text-[#1C1C3C]/80 mb-8">
                Create a professional, job-winning resume in minutes. Let our AI write, enhance, and analyze your content so you can focus on landing your next opportunity.
            </p>

            <div class="flex justify-center md:justify-start gap-4">
                <a href="{{ route('register') }}" class="bg-[#FF6F61] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-[#FF8C7A] transition">
                    Get Started Free
                </a>

                <a href="#features" class="border border-[#1C1C3C] px-8 py-3 rounded-lg text-[#1C1C3C] font-semibold hover:bg-[#1C1C3C] hover:text-white transition">
                    Learn More
                </a>
            </div>
        </div>

        <div x-show="show" x-transition.delay.300ms class="w-full md:w-[520px] mt-10 md:mt-0 flex justify-center">
            {{-- Hero SVG --}}
            <img src="" alt="AI Resume Builder" class="w-96">
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="bg-[#F7D9F1] py-24">
        <div class="max-w-[1200px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-[48px] font-bold mb-6 text-[#1C1C3C]">Everything You Need to Land the Job</h2>
            <p class="font-[Inter] text-xl text-[#1C1C3C]/80 mb-16">
                Our smart tools combine AI and design excellence to create the ultimate resume experience.
            </p>

            <div class="grid md:grid-cols-3 gap-12">
                {{-- Templates --}}
                <div class="bg-white rounded-xl p-10 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition">
                    <img src="https://www.svgrepo.com/show/530031/template.svg" class="w-20 mb-6" alt="Templates Icon">
                    <h3 class="text-2xl font-semibold mb-3 text-[#1C1C3C]">Smart Resume Templates</h3>
                    <p class="text-[#1C1C3C]/80">
                        Choose from dozens of clean, ATS-friendly templates built by hiring experts to impress recruiters instantly.
                    </p>
                </div>

                {{-- Analyzer --}}
                <div class="bg-white rounded-xl p-10 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition">
                    <img src="https://www.svgrepo.com/show/508263/analysis.svg" class="w-20 mb-6" alt="Analyzer Icon">
                    <h3 class="text-2xl font-semibold mb-3 text-[#1C1C3C]">AI Resume Analyzer</h3>
                    <p class="text-[#1C1C3C]/80">
                        Upload your existing resume and get an instant score with feedback on keywords, tone, and formatting — powered by machine learning.
                    </p>
                </div>

                {{-- Formatting --}}
                <div class="bg-white rounded-xl p-10 flex flex-col items-center text-center shadow-lg hover:shadow-2xl transition">
                    <img src="https://www.svgrepo.com/show/500267/settings-cog.svg" class="w-20 mb-6" alt="Formatting Icon">
                    <h3 class="text-2xl font-semibold mb-3 text-[#1C1C3C]">Auto-Formatting Engine</h3>
                    <p class="text-[#1C1C3C]/80">
                        Spend less time aligning margins. Our AI engine adjusts your layout for perfect spacing, style, and readability — instantly.
                    </p>
                </div>
            </div>

            {{-- CTA under features --}}
            <div class="mt-16 text-center">
                <p class="text-lg text-[#1C1C3C]/80 mb-4">
                    Why wait longer? Find out more about what our powerful AI-driven features can do for you.
                </p>
                <a href="{{ route('login') }}" class="bg-[#1C1C3C] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-[#FF6F61] transition">
                    Explore Features
                </a>
            </div>
        </div>
    </section>

    {{-- Templates Section --}}
    <section id="templates" class="bg-[#DAD9F7] py-24">
        <div class="max-w-[1200px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-[48px] font-bold mb-6 text-[#1C1C3C]">Professional Resume Templates</h2>
            <p class="text-xl mb-16 text-[#1C1C3C]/80">
                Pick from styles that recruiters love. Designed for clarity, professionalism, and elegance.
            </p>

            <div class="grid md:grid-cols-3 gap-12">
                {{-- Modern --}}
                <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-2xl transition">
                    <img src="https://www.svgrepo.com/show/490888/modern-design.svg" class="w-20 mb-6" alt="Modern Template Icon">
                    <h3 class="text-xl font-semibold mb-2">Modern</h3>
                    <p class="text-[#1C1C3C]/80">Clean lines, subtle colors, and great readability. Ideal for tech and design professionals.</p>
                </div>

                {{-- Classic --}}
                <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-2xl transition">
                    <img src="https://www.svgrepo.com/show/530244/document.svg" class="w-20 mb-6" alt="Classic Template Icon">
                    <h3 class="text-xl font-semibold mb-2">Classic</h3>
                    <p class="text-[#1C1C3C]/80">Timeless layout trusted by recruiters in corporate, law, and academic industries.</p>
                </div>

                {{-- Creative --}}
                <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-2xl transition">
                    <img src="https://www.svgrepo.com/show/503878/palette.svg" class="w-20 mb-6" alt="Creative Template Icon">
                    <h3 class="text-xl font-semibold mb-2">Creative</h3>
                    <p class="text-[#1C1C3C]/80">Bold, vibrant, and personal. Perfect for marketing, media, and creative arts fields.</p>
                </div>
            </div>

            {{-- CTA under templates --}}
            <div class="mt-16 text-center">
                <p class="text-lg text-[#1C1C3C]/80 mb-4">
                    We currently offer popular templates like <strong>Classic</strong>, <strong>Modern</strong>, <strong>Minimalist</strong>, <strong>Elegant</strong>, and <strong>Creative</strong>.
                    But don’t worry — we’re actively working to add even more designs to suit your needs.
                </p>
                <a href="{{ url('/templates') }}" class="bg-[#1C1C3C] text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-[#FF6F61] transition gap-4">
                    View All Templates
                </a>
            </div>
        </div>
    </section>


    {{-- CTA Final --}}
    <section class="bg-[#FFE1AF] text-white py-20 text-center">
        <h2 class="text-4xl font-[Playfair_Display] mb-4">Ready to Build Your Resume?</h2>
        <p class="text-lg text-white/80 mb-8">Start creating your AI-powered resume today. It’s fast, easy, and free to begin.</p>
        <a href="{{ route('register') }}" class="inline-block bg-[#FF6F61] text-white px-10 py-4 rounded-lg text-lg font-semibold hover:bg-[#FF8C7A] transition">
            Get Started Free
        </a>
        <p class="text-sm text-[#1C1C3C]/60 mt-4">
                    Have suggestions? Contact us via the details at the bottom — we’d love your feedback.
        </p>
    </section>
@endsection
