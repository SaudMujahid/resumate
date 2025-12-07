@extends('layouts.home')

@section('content')
<div class="bg-[#FFFFF7] min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Home
            </a>
        </div>

        <!-- Rating Card -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-6">Your CV Rating</h1>
            <div class="flex items-center justify-center mb-6">
                <div class="relative">
                    <div class="text-7xl font-bold text-blue-600">{{ $analysis['rating'] }}</div>
                    <div class="text-2xl text-gray-500">/10</div>
                </div>
            </div>
            <div class="mt-6 bg-gray-200 rounded-full h-4 overflow-hidden max-w-md mx-auto">
                <div class="bg-blue-600 h-full transition-all duration-1000" style="width: {{ $analysis['rating'] * 10 }}%"></div>
            </div>
        </div>

        <!-- Strengths -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-green-700 mb-6 flex items-center">
                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Strengths
            </h3>
            <ul class="space-y-3">
                @foreach($analysis['strengths'] as $strength)
                    <li class="flex items-start text-gray-700">
                        <span class="text-green-500 mr-3 font-bold">✓</span>
                        <span>{{ $strength }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Areas for Improvement -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-orange-700 mb-6 flex items-center">
                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Areas for Improvement
            </h3>
            <ul class="space-y-3">
                @foreach($analysis['improvements'] as $improvement)
                    <li class="flex items-start text-gray-700">
                        <span class="text-orange-500 mr-3 font-bold">•</span>
                        <span>{{ $improvement }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Feedback Cards -->
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Structure Feedback</h3>
                <p class="text-gray-700 leading-relaxed">{{ $analysis['structure_feedback'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Content Feedback</h3>
                <p class="text-gray-700 leading-relaxed">{{ $analysis['content_feedback'] }}</p>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-bold text-blue-700 mb-6 flex items-center">
                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Recommendations
            </h3>
            <ul class="space-y-3">
                @foreach($analysis['recommendations'] as $rec)
                    <li class="flex items-start text-gray-700">
                        <span class="text-blue-500 mr-3 font-bold">→</span>
                        <span>{{ $rec }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 justify-center">
            <a href="{{ route('home') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                Back to Home
            </a>
            <a href="{{ route('home') }}" class="bg-amber-400 hover:bg-amber-500 text-black font-bold py-3 px-8 rounded-lg transition-colors">
                Analyze Another Resume
            </a>
        </div>
    </div>
</div>
@endsection
