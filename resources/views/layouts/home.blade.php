<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Resumate - AI Resume Builder' }}</title>

    {{-- Option 1: Simple Vite (will fail if no manifest.json) --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- Option 2: Safe Vite with fallback --}}
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Fallback to CDN --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            'playfair': ['Playfair Display', 'serif'],
                            'poppins': ['Poppins', 'sans-serif'],
                            'inter': ['Inter', 'sans-serif'],
                        },
                        colors: {
                            'primary': '#1C1C3C',
                            'secondary': '#FF6F61',
                            'accent-blue': '#6497b1',
                            'accent-purple': '#a64d79',
                            'accent-green': '#6aa84f',
                        }
                    }
                }
            }
        </script>
    @endif

    {{-- REMOVE BOOTSTRAP - Your template uses Tailwind! --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    {{-- Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@500;600&family=Inter:wght@400&display=swap" rel="stylesheet">

    {{-- x-cloak styles --}}
    <style>
        [x-cloak] { display: none !important; }
    </style>
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

            {{-- Desktop Auth Buttons --}}
            @guest
            <div class="hidden md:flex gap-3">
                <a href="{{ route('login') }}">
                    <button class="px-4 py-2 bg-[#1C1C3C] text-white rounded hover:bg-[#FF6F61] transition">Sign In</button>
                </a>
                <a href="{{ route('register') }}">
                    <button class="px-4 py-2 bg-[#1C1C3C] text-white rounded hover:bg-[#FF6F61] transition">Sign Up</button>
                </a>
            </div>
            @endguest

            @auth
            <div class="relative hidden md:block" x-data="{ profileOpen: false }">
                <button @click="profileOpen = !profileOpen" class="w-10 h-10 rounded-full bg-[#FF6F61] text-white font-bold flex items-center justify-center">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </button>

                <div x-show="profileOpen" @click.away="profileOpen = false"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">

                    <div class="px-4 py-3 border-b">
                        <p class="font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100 border-t">Log Out</button>
                    </form>
                </div>
            </div>
            @endauth

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

            @guest
            <div class="pt-4 border-t">
                <a href="{{ route('login') }}">
                    <button class="w-full px-4 py-2 bg-[#1C1C3C] text-white rounded mb-2">Sign In</button>
                </a>
                <a href="{{ route('register') }}">
                    <button class="w-full px-4 py-2 bg-[#FF6F61] text-white rounded">Sign Up</button>
                </a>
            </div>
            @endguest

            @auth
            <div class="pt-4 border-t space-y-3">
                <a href="{{ route('profile.edit') }}" class="block hover:text-[#1C1C3C]">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="block w-full text-left hover:text-[#FF6F61]">Log Out</button>
                </form>
            </div>
            @endauth
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

