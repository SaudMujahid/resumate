@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-center px-6 py-24">
        <div class="max-w-[550px] text-center md:text-left space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)">
            <h1 x-show="show" x-transition
                class="font-[Playfair_Display] text-[72px] md:text-[86px] font-bold leading-[1.2] text-[#1C1C3C] mb-4">
                Build Your Dream Resume with AI
            </h1>

            <p x-show="show" x-transition.delay.150ms
               class="text-lg md:text-2xl text-[#1C1C3C]/80 mb-8">
                Create a polished, ATS-friendly resume in minutes — powered by advanced AI that writes, reviews, and enhances your resume automatically.
            </p>

            <div class="flex justify-center md:justify-start gap-4">
                <a href="{{ route('register') }}" class="relative group">
                    <span class="absolute inset-0 bg-[#FF6F61]/90 rounded-lg transition group-hover:bg-[#FF6F61]"></span>
                    <span class="relative text-white text-lg font-semibold px-8 py-3">Get Started Free</span>
                </a>

                <a href="#features" class="border border-[#1C1C3C] px-8 py-3 rounded-lg text-[#1C1C3C] font-semibold hover:bg-[#1C1C3C] hover:text-white transition">
                    Learn More
                </a>
            </div>
        </div>

        <div x-show="show" x-transition.delay.300ms
             class="w-full md:w-[520px] mt-10 md:mt-0 flex justify-center">
            <img src="https://images.pexels.com/photos/590016/pexels-photo-590016.jpeg?auto=compress&cs=tinysrgb&w=800"
                 alt="AI Resume Builder" class="rounded-2xl shadow-xl">
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="bg-[#F7D9F1] py-24">
        <div class="max-w-[1200px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-[56px] font-bold mb-6 text-[#1C1C3C]">Everything You Need to Land the Job</h2>
            <p class="font-[Inter] text-2xl text-[#1C1C3C]/80 mb-16">
                Powerful AI-driven tools designed to make your resume stand out — faster than ever.
            </p>

            <div class="grid md:grid-cols-3 gap-12">
                {{-- Smart Resume Templates --}}
                <div class="bg-white rounded-xl p-10 flex flex-col items-center justify-center text-center shadow-lg hover:shadow-2xl transition">
                    <img src="https://cdn-icons-png.flaticon.com/512/1087/1087815.png" class="w-20 mb-6" alt="Templates Icon">
                    <h3 class="text-2xl font-semibold text-[#1C1C3C] mb-3">Smart Resume Templates</h3>
                    <p class="text-[#1C1C3C]/80 leading-relaxed">
                        Choose from a growing library of professionally designed templates that adapt to your content automatically.
                    </p>
                </div>

                {{-- AI Resume Analyzer --}}
                <div class="bg-white rounded-xl p-10 flex flex-col items-center justify-center text-center shadow-lg hover:shadow-2xl transition">
                    <img src="https://cdn-icons-png.flaticon.com/512/3588/3588725.png" class="w-20 mb-6" alt="Analyzer Icon">
                    <h3 class="text-2xl font-semibold text-[#1C1C3C] mb-3">AI Resume Analyzer</h3>
                    <p class="text-[#1C1C3C]/80 leading-relaxed">
                        Upload your existing resume and get an instant score based on formatting, keywords, and tone. Powered by machine learning trained on 10,000+ resumes.
                    </p>
                </div>

                {{-- Instant Formatting --}}
                <div class="bg-white rounded-xl p-10 flex flex-col items-center justify-center text-center shadow-lg hover:shadow-2xl transition">
                    <img src="https://cdn-icons-png.flaticon.com/512/992/992651.png" class="w-20 mb-6" alt="Formatting Icon">
                    <h3 class="text-2xl font-semibold text-[#1C1C3C] mb-3">Instant Formatting</h3>
                    <p class="text-[#1C1C3C]/80 leading-relaxed">
                        Never struggle with layout again. Our system automatically adjusts fonts, spacing, and alignment for a perfect, ATS-optimized layout.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Templates Section --}}
    <section id="templates" class="bg-[#DAD9F7] py-24 shadow-inner">
        <div class="max-w-[1200px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-[56px] font-bold mb-6 text-[#1C1C3C]">Professionally Crafted Templates</h2>
            <p class="text-xl mb-16 text-[#1C1C3C]/80">
                Choose from templates used by professionals worldwide — optimized for different careers and industries.
            </p>

            <div class="grid md:grid-cols-3 gap-12">
                {{-- Modern Template --}}
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition flex flex-col items-center">
                    <img src="https://images.pexels.com/photos/590016/pexels-photo-590016.jpeg?auto=compress&cs=tinysrgb&w=600"
                         alt="Modern Resume Template" class="rounded-lg mb-6">
                    <h3 class="text-xl font-semibold mb-2">Modern Template</h3>
                    <p class="text-[#1C1C3C]/80">
                        Sleek, minimalist, and recruiter-approved. Ideal for tech, marketing, and creative fields.
                    </p>
                </div>

                {{-- Professional Template --}}
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition flex flex-col items-center">
                    <img src="https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&w=600"
                         alt="Professional Resume Template" class="rounded-lg mb-6">
                    <h3 class="text-xl font-semibold mb-2">Professional Template</h3>
                    <p class="text-[#1C1C3C]/80">
                        Balanced and elegant. The perfect fit for corporate, legal, and finance professionals.
                    </p>
                </div>

                {{-- Creative Template --}}
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition flex flex-col items-center">
                    <img src="https://images.pexels.com/photos/3184463/pexels-photo-3184463.jpeg?auto=compress&cs=tinysrgb&w=600"
                         alt="Creative Resume Template" class="rounded-lg mb-6">
                    <h3 class="text-xl font-semibold mb-2">Creative Template</h3>
                    <p class="text-[#1C1C3C]/80">
                        Express your personality with bold color palettes and flexible design options.
                    </p>
                </div>
            </div>

            <p class="mt-12 text-[#1C1C3C]/70 text-lg">More templates coming soon — including tech, medical, and academic styles!</p>
        </div>
    </section>


    {{-- Call-to-Action Section --}}
    <section class="bg-[#ffb3ba] text-white py-20 text-center">
        <h2 class="text-4xl font-[Playfair_Display] mb-4">Ready to Build Your Resume?</h2>
        <p class="text-lg text-white/80 mb-8">Start creating your AI-powered resume today. It’s fast, easy, and free to begin.</p>
        <a href="{{ route('register') }}" class="inline-block bg-[#FF6F61] text-white px-10 py-4 rounded-lg text-lg font-semibold hover:bg-[#FF8C7A] transition">
            Get Started Free
        </a>
    </section>
@endsection

