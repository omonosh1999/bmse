@extends('layouts.main')

@section('content')
    <div class="min-h-screen">
        <!-- Header Section -->
        <section class="bg-gradient-to-br from-purple-50 to-pink-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Mental Mathematics
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Develop lightning-fast calculation skills and number sense
                </p>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                    Mental Math Skills
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="text-center p-6 bg-purple-50 rounded-lg">
                        <div
                            class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Speed Calculation</h3>
                        <p class="text-gray-600">Master rapid arithmetic operations without calculators</p>
                    </div>
                    <div class="text-center p-6 bg-blue-50 rounded-lg">
                        <div
                            class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Number Patterns</h3>
                        <p class="text-gray-600">Recognize and utilize mathematical patterns for faster computation</p>
                    </div>
                    <div class="text-center p-6 bg-green-50 rounded-lg">
                        <div
                            class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Memory Techniques</h3>
                        <p class="text-gray-600">Learn tricks and shortcuts for remembering mathematical facts</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Coming Soon -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">
                    Coming Soon!
                </h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    We're developing an exciting mental mathematics program. Stay tuned for updates!
                </p>
                <a href="{{ route('contact') }}"
                    class="px-8 py-3 bg-[#006738] text-white font-semibold rounded-full hover:bg-[#005230] transition-colors duration-200">
                    Get Notified
                </a>
            </div>
        </section>
    </div>
@endsection
