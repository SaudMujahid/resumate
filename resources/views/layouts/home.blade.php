<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Resumate - AI Resume Builder' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@500;600&family=Inter:wght@400&display=swap" rel="stylesheet">
</head>

<body x-data="{ mobileMenu: false }" x-cloak class="font-[Poppins] text-[#1C1C3C] min-h-screen flex flex-col">

    {{-- NAVIGATION --}}
    <header class="bg-gray-100 w-full shadow z-50
                   fixed md:fixed top-0 left-0
                   md:block">

        <nav class="max-w-[1440px] mx-auto p-5 flex justify-between items-center relative">

            {{-- Logo --}}
            <div class="font-[Playfair_Display] text-2xl font-bold text-[#1C1C3C]">
                <a href="{{ url('/') }}" class="hover:text-[#FF6F61] transition">Resumate</a>
            </div>

            {{-- Desktop Navigation (Center aligned) --}}
            <div class="hidden md:flex gap-8 absolute left-1/2 -translate-x-1/2">
                <a href="{{ url('/') }}" class="hover:text-[#FF6f61] transition">Home</a>
                <a href="{{ url('/features') }}" class="hover:text-[#6497b1] transition">Features</a>
                <a href="{{ url('/templates') }}" class="hover:text-[#a64d79] transition">Templates</a>
                <a href="{{ url('/mission') }}" class="hover:text-[#6aa84f] transition">Mission</a>
                <a href="{{ url('/analyzer') }}" class="hover:text-[#FF6F61] transition">Analyzer</a>
            </div>

            <div class="hidden md:flex">
                <a href="{{ route('resumebuilder') }}">
                    <button class="px-4 py-2 bg-[#FF6F61] text-white rounded hover:bg-[#FF8C7A] transition">Start for free</button>
                </a>
            </div>

            {{-- MOBILE MENU BUTTON --}}
            <button class="md:hidden p-2" @click="mobileMenu = !mobileMenu">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2">
                    <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </nav>

        {{-- MOBILE DROPDOWN MENU --}}
        <div x-show="mobileMenu" x-transition class="md:hidden bg-gray-100 w-full border-t shadow-inner p-4 space-y-4">

            <a href="{{ url('/') }}" class="block hover:text-[#ff6f61]">Home</a>
            <a href="{{ url('/features') }}" class="block hover:text-[#6497b1]">Features</a>
            <a href="{{ url('/templates') }}" class="block hover:text-[#a64d79]">Templates</a>
            <a href="{{ url('/mission') }}" class="block hover:text-[#6aa84f]">Mission</a>
            <a href="{{ url('/analyzer') }}" class="block hover:text-[#FF6F61]">Analyzer</a>

            <div class="pt-4 border-t">
                <a href="{{ route('resumebuilder') }}">
                    <button class="w-full px-4 py-2 bg-[#FF6F61] text-white rounded">Start for free</button>
                </a>
            </div>
        </div>

    </header>


    {{-- MAIN CONTENT --}}
    <main class="flex-1 mt-20">
        @yield('content')
    </main>


    {{-- FOOTER --}}
    <footer class="bg-[#1C1C3C] text-white py-12 mt-auto">
        <div class="max-w-[1440px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 px-6">

            <div>
                <h3 class="text-lg font-semibold mb-3">Resumate</h3>
                <p>AI-powered tools to build your career.</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/" class="hover:text-[#FF6F61]">Home</a></li>
                    <li><a href="/features" class="hover:text-[#FF6F61]">Features</a></li>
                    <li><a href="/templates" class="hover:text-[#FF6F61]">Templates</a></li>
                    <li><a href="/mission" class="hover:text-[#FF6F61]">Mission</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3">Contact</h3>
                <ul class="space-y-1 text-sm">
                    <li>Email: info@resumate.com</li>
                    <li>Phone: +1 (555) 123-4567</li>
                    <li>Address: 123 Career St</li>
                </ul>
            </div>

        </div>

        <div class="text-center text-sm border-t border-gray-500 mt-8 pt-4">
            © {{ date('Y') }} Resumate. All rights reserved.
        </div>
    </footer>

</body>
</html>

