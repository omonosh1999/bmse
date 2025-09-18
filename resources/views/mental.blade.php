@extends('layouts.main')

@section('content')
    <div class="min-h-screen">
        <!-- Header Section -->
        <section class="bg-[#006738] text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Mental <span class="text-yellow-300">Mathematics</span>
                </h1>
                <p class="text-lg md:text-xl text-purple-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Test your mathematical skills with our interactive quizzes and challenges
                </p>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-yellow-300 rounded-full"></div>
                </div>
            </div>
        </section>

        <!-- Filters and Search Section -->
        <section class="py-6 lg:py-8 bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <form method="GET" action="{{ route('mental') }}"
                    class="space-y-4 lg:space-y-0 lg:flex lg:gap-4 lg:items-center lg:justify-between">
                    <!-- Search -->
                    <div class="w-full lg:flex-1 lg:max-w-md">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search quizzes..."
                                class="w-full pl-10 pr-4 py-3 lg:py-2 border border-gray-300 rounded-lg focus:ring-purple-600 focus:border-purple-600 text-sm sm:text-base">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Controls -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:gap-2 lg:items-center">
                        <!-- Category Filter -->
                        <div class="flex flex-col sm:flex-row sm:gap-2 sm:items-center">
                            <label for="category"
                                class="text-sm font-medium text-gray-700 mb-1 sm:mb-0 sm:whitespace-nowrap">
                                Category:
                            </label>
                            <select name="category" id="category"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-600 focus:border-purple-600 text-sm sm:text-base min-w-0">
                                <option value="">All Categories</option>
                                @foreach ($availableCategories as $category)
                                    <option value="{{ $category }}"
                                        {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ ucfirst($category) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Class Filter -->
                        <div class="flex flex-col sm:flex-row sm:gap-2 sm:items-center">
                            <label for="class"
                                class="text-sm font-medium text-gray-700 mb-1 sm:mb-0 sm:whitespace-nowrap">
                                Level:
                            </label>
                            <select name="class" id="class"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-purple-600 focus:border-purple-600 text-sm sm:text-base min-w-0">
                                <option value="">All Levels</option>
                                {{-- @foreach ($availableClasses as $class)
                                    <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>
                                        {{ $class }}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <!-- Filter Button -->
                            <button type="submit"
                                class="flex-1 sm:flex-none px-4 lg:px-6 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                Filter
                            </button>

                            <!-- Clear Filters -->
                            @if (request('search') || request('category') || request('class'))
                                <a href="{{ route('mental') }}"
                                    class="flex-1 sm:flex-none px-4 py-2 text-gray-600 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-center">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Quizzes Section -->
        <section class="py-12 lg:py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if ($quizzes->count() > 0)
                    <!-- Results Info -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 lg:mb-8">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                            Available Quizzes
                            @if (request('category'))
                                <span class="block sm:inline text-base sm:text-lg font-normal text-gray-600">for
                                    {{ ucfirst(request('category')) }}</span>
                            @endif
                            @if (request('class'))
                                <span class="block sm:inline text-base sm:text-lg font-normal text-gray-600">
                                    - {{ request('class') }}
                                </span>
                            @endif
                        </h2>
                        <p class="text-sm sm:text-base text-gray-600">
                            Showing {{ $quizzes->count() }} of {{ $quizzes->total() }} quizzes
                        </p>
                    </div>

                    <!-- Quizzes Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($quizzes as $quiz)
                            <div
                                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200 overflow-hidden">
                                <!-- Quiz Header -->
                                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-white text-sm font-medium">
                                            {{ ucfirst($quiz->category) }} - {{ $quiz->class_level }}
                                        </span>
                                        <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-1 rounded-full">
                                            {{ $quiz->questions->count() }} Questions
                                        </span>
                                    </div>
                                </div>

                                <!-- Quiz Content -->
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $quiz->title }}</h3>
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($quiz->description, 120) }}
                                    </p>

                                    <!-- Course and Lesson Info -->
                                    <div class="mb-4 space-y-1">
                                        <p class="text-sm text-gray-500">
                                            <span class="font-medium">Course:</span> {{ $quiz->course->title }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <span class="font-medium">Lesson:</span> {{ $quiz->lesson->title }}
                                        </p>
                                    </div>

                                    <!-- Quiz Stats -->
                                    <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $quiz->time_limit ? $quiz->time_limit . ' min' : 'No limit' }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                            {{ $quiz->hasUnlimitedAttempts() ? 'Unlimited' : $quiz->max_attempts }}
                                            attempts
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $quiz->passing_score }}% to pass
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('quiz.take', $quiz) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Take Quiz
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 lg:mt-12">
                        {{ $quizzes->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12 lg:py-16 px-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">
                            @if (request('search') || request('category') || request('class'))
                                No quizzes found
                            @else
                                No quizzes available yet
                            @endif
                        </h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            @if (request('search') || request('category') || request('class'))
                                Try adjusting your search criteria or filters to find more quizzes.
                            @else
                                Check back later for new mental mathematics quizzes and challenges.
                            @endif
                        </p>
                        @if (request('search') || request('category') || request('class'))
                            <a href="{{ route('mental') }}"
                                class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                View All Quizzes
                            </a>
                        @endif
                    </div>
                @endif
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

        <!-- CTA Section -->
        <section class="py-16 bg-gradient-to-br from-purple-600 to-pink-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Ready to Challenge Your Mind?
                </h2>
                <p class="text-lg md:text-xl text-purple-100 mb-8 max-w-2xl mx-auto">
                    Test your mathematical skills and improve your mental calculation abilities
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('primary') }}"
                        class="px-8 py-3 bg-yellow-300 text-purple-800 font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200">
                        Primary Courses
                    </a>
                    <a href="{{ route('secondary') }}"
                        class="px-8 py-3 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-purple-600 transition-colors duration-200">
                        Secondary Courses
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
