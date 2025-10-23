@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <section class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-center px-6 py-20">
        <div class="max-w-[500px] text-center md:text-left">
            <h1 class="font-[Playfair_Display] text-[72px] md:text-[94px] font-bold leading-[1.2] mb-4">AI Resume Builder</h1>
            <p class="text-lg md:text-2xl text-[#1C1C3C]/80 mb-8">Create a professional resume in minutes with our AI-powered builder.</p>
            <a href="{{ route('register') }}" class="inline-block relative group">
                <span class="absolute inset-0 bg-[#FF6F61]/90 rounded-lg transition group-hover:bg-[#FF6F61]"></span>
                <span class="relative text-white text-xl font-semibold px-10 py-4">Get Started</span>
            </a>
        </div>

        <div class="w-[400px] h-[300px] md:w-[500px] md:h-[400px] bg-[#FF6F61]/10 rounded-lg flex items-center justify-center text-lg text-[#1C1C3C] mt-10 md:mt-0">
            Resume Preview Placeholder
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="bg-[#F7D9F1] py-20">
        <div class="max-w-[1100px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-[56px] font-bold mb-6">Features</h2>
            <p class="font-[Inter] text-2xl mb-16">Leverage AI to craft a professional resume with ease</p>
            <div class="grid md:grid-cols-3 gap-12">
                @foreach (['Smart Resume Templates', 'Instant Formatting', 'Download in PDF & Word'] as $feature)
                    <div class="bg-[#FFF4E6] rounded-xl p-10 flex flex-col items-center justify-center text-center">
                        <div class="w-[100px] h-[100px] bg-[#DA85E2]/80 rounded-full mb-8"></div>
                        <h3 class="text-2xl font-semibold">{{ $feature }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Templates --}}
    <section id="templates" class="bg-[#DAD9F7] py-20 shadow-lg">
        <div class="max-w-[1100px] mx-auto text-center px-6">
            <h2 class="font-[Playfair_Display] text-[56px] font-bold mb-6">Templates</h2>
            <p class="text-2xl mb-16">Choose from a range of professional templates designed by experts</p>
            <div class="grid md:grid-cols-3 gap-12">
                @foreach (['Modern Design', 'Easy Customization', 'Expertly Crafted'] as $template)
                    <div class="flex flex-col items-center">
                        <div class="bg-[#1C2E3C]/60 rounded-xl w-[250px] h-[390px] flex items-center justify-center mb-8">
                            <div class="bg-[#DAD9F7] rounded-full w-[120px] h-[100px]"></div>
                        </div>
                        <h3 class="text-2xl font-semibold text-black/80">{{ $template }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Why Choose --}}
    <section class="py-20 text-center">
        <h2 class="font-[Playfair_Display] text-[48px] mb-12">Why Choose Resumate?</h2>
        <div class="max-w-[1100px] mx-auto grid md:grid-cols-3 gap-10 px-6">
            @foreach ([
                ['AI', 'AI-Powered', 'Our advanced AI helps you create professional resumes tailored to your industry.'],
                ['T', 'Professional Templates', 'Choose from dozens of ATS-friendly templates designed by career experts.'],
                ['✓', 'Resume Analyzer', 'Get instant feedback on your resume with our comprehensive analysis tool.'],
            ] as $item)
                <div class="bg-white rounded-xl p-8 shadow">
                    <div class="w-[60px] h-[60px] bg-[#FF6F61]/10 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-semibold">
                        {{ $item[0] }}
                    </div>
                    <h3 class="text-2xl mb-3 font-semibold">{{ $item[1] }}</h3>
                    <p class="text-[#1C1C3C]/80 leading-relaxed">{{ $item[2] }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endsection

