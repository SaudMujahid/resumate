<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Resumate - AI Resume Builder' }}</title>

    {{-- Include Tailwind + your styles via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@500;600&family=Inter:wght@400&display=swap" rel="stylesheet">
</head>
<body x-data x-cloak class="font-[Poppins] text-[#1C1C3C] min-h-screen flex flex-col">
    {{-- Navigation --}}
    <header class="bg-gray-100 fixed top-0 left-0 w-full shadow z-50">
        <nav class="max-w-[1440px] mx-auto p-5 flex justify-between items-center relative">
            <div class="font-[Playfair_Display] text-2xl font-bold text-[#1C1C3C]">Resumate</div>
            <div class="hidden md:flex gap-8 absolute left-1/2 -translate-x-1/2">
                <a href="{{ url('/') }}" class="text-[#1C1C3C] hover:text-[#FF6F61] transition">Home</a>
                <a href="#features" class="text-[#1C1C3C] hover:text-[#FF6F61] transition">Features</a>
                <a href="#templates" class="text-[#1C1C3C] hover:text-[#FF6F61] transition">Templates</a>
                <a href="#" class="text-[#1C1C3C] hover:text-[#FF6F61] transition">Analyzer</a>
            </div>
            <div>
                <a href="{{ route('login') }}">
                    <button class="px-4 py-2 bg-[#1C1C3C] text-white rounded hover:bg-[#FF6F61] transition">Sign In</button>
                </a>
            </div>
        </nav>
    </header>

    {{-- Main content --}}
    <main class="flex-1 mt-20">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#1C1C3C] text-white py-10 mt-auto">
        <div class="max-w-[1440px] mx-auto grid md:grid-cols-4 gap-10 px-6">
            <div>
                <h3 class="text-lg font-semibold mb-3">Resumate</h3>
                <p>Create professional resumes in minutes with our AI-powered builder.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-3">Quick Links</h3>
                <ul>
                    <li><a href="#" class="hover:text-[#FF6F61]">Home</a></li>
                    <li><a href="#features" class="hover:text-[#FF6F61]">Features</a></li>
                    <li><a href="#templates" class="hover:text-[#FF6F61]">Templates</a></li>
                    <li><a href="#" class="hover:text-[#FF6F61]">Pricing</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-3">Contact Us</h3>
                <ul>
                    <li>Email: info@resumate.com</li>
                    <li>Phone: +1 (555) 123-4567</li>
                    <li>Address: 123 Career St, Job City</li>
                </ul>
            </div>
        </div>
        <div class="text-center text-sm border-t border-gray-500 mt-8 pt-4">
            © {{ date('Y') }} Resumate. All rights reserved.
        </div>
    </footer>
</body>
</html>

