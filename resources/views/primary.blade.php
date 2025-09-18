@extends('layouts.main')

@section('content')
    <div class="min-h-screen">
        <!-- Header Section -->
        <section class="bg-[#006738] text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Primary <span class="text-[#FBC905]">Mathematics</span>
                </h1>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Building strong mathematical foundations for children aged 5-11 years
                </p>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-[#FBC905] rounded-full"></div>
                </div>
            </div>
        </section>

        <!-- Filters and Search Section -->
        <section class="py-6 lg:py-8 bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <form method="GET" action="{{ route('primary') }}"
                    class="space-y-4 lg:space-y-0 lg:flex lg:gap-4 lg:items-center lg:justify-between">
                    <!-- Search -->
                    <div class="w-full lg:flex-1 lg:max-w-md">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search courses..."
                                class="w-full pl-10 pr-4 py-3 lg:py-2 border border-gray-300 rounded-lg focus:ring-[#006738] focus:border-[#006738] text-sm sm:text-base">
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
                        <!-- Class Filter -->
                        <div class="flex flex-col sm:flex-row sm:gap-2 sm:items-center">
                            <label for="class"
                                class="text-sm font-medium text-gray-700 mb-1 sm:mb-0 sm:whitespace-nowrap">
                                Filter by Class:
                            </label>
                            <select name="class" id="class"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#006738] focus:border-[#006738] text-sm sm:text-base min-w-0">
                                <option value="">All Classes</option>
                                @foreach ($availableClasses as $class)
                                    <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>
                                        {{ $class }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <!-- Filter Button -->
                            <button type="submit"
                                class="flex-1 sm:flex-none px-4 lg:px-6 py-2 bg-[#006738] text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                Filter
                            </button>

                            <!-- Clear Filters -->
                            @if (request('search') || request('class'))
                                <a href="{{ route('primary') }}"
                                    class="flex-1 sm:flex-none px-4 py-2 text-gray-600 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-center">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Courses Section -->
        <section class="py-12 lg:py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if ($courses->count() > 0)
                    <!-- Results Info -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 lg:mb-8">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                            Available Courses
                            @if (request('class'))
                                <span class="block sm:inline text-base sm:text-lg font-normal text-gray-600">for
                                    {{ request('class') }}</span>
                            @endif
                        </h2>
                        <p class="text-sm sm:text-base text-gray-600">
                            Showing {{ $courses->count() }} of {{ $courses->total() }} courses
                        </p>
                    </div>

                    <!-- Courses Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($courses as $course)
                            <x-course-card :title="$course->title" :description="Str::limit($course->description, 120)" :image="$course->cover_photo ? asset('storage/' . $course->cover_photo) : null" :level="$course->class_level"
                                duration="" :lessons="$course->lessons->count() . ' lessons'" price="Free" :route="route('courses.preview', $course)" buttonText="View Course"
                                :badge="$course->lessons->count() > 15
                                    ? 'Complete Course'
                                    : ($course->lessons->count() > 8
                                        ? 'Standard'
                                        : 'Starter')" :featured="$course->lessons->count() > 20" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 lg:mt-12">
                        {{ $courses->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12 lg:py-16 px-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">
                            @if (request('search') || request('class'))
                                No courses found
                            @else
                                No primary courses available yet
                            @endif
                        </h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            @if (request('search') || request('class'))
                                Try adjusting your search criteria or filters to find more courses.
                            @else
                                Check back later for new primary mathematics courses designed for young learners.
                            @endif
                        </p>
                        @if (request('search') || request('class'))
                            <a href="{{ route('primary') }}"
                                class="inline-flex items-center px-6 py-3 bg-[#006738] text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                                View All Courses
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <!-- Key Features Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Our Primary Program?</h2>
                    <p class="text-lg text-gray-600">Building confidence through engaging, age-appropriate learning</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Ages 5-11</h3>
                        <p class="text-gray-600">Carefully designed curriculum for primary school students</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Interactive Learning</h3>
                        <p class="text-gray-600">Engaging activities, games, and visual learning tools</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Quick Progress</h3>
                        <p class="text-gray-600">Build confidence and see improvements quickly</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Key Topics Section -->
        <section class="py-12 lg:py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-900 mb-8 lg:mb-12">
                    Essential Mathematical Concepts
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="text-[#006738] mb-3">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Number & Place Value</h3>
                        <p class="text-gray-600 text-sm">Understanding numbers, counting, and place value systems</p>
                    </div>
                    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="text-[#006738] mb-3">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Addition & Subtraction</h3>
                        <p class="text-gray-600 text-sm">Basic arithmetic operations and mental math strategies</p>
                    </div>
                    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="text-[#006738] mb-3">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Shapes & Space</h3>
                        <p class="text-gray-600 text-sm">Geometry, patterns, and spatial awareness</p>
                    </div>
                    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="text-[#006738] mb-3">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Measurement</h3>
                        <p class="text-gray-600 text-sm">Length, weight, time, and money concepts</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Primary Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            Build Strong Mathematical Foundations
                        </h2>
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-[#006738] rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Curriculum Aligned</h3>
                                    <p class="text-gray-600">Fully aligned with British National Numeracy Curriculum
                                        standards</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-[#006738] rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Expert Teachers</h3>
                                    <p class="text-gray-600">Qualified primary mathematics specialists with years of
                                        experience</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-[#006738] rounded-full flex items-center justify-center mr-4 mt-1">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Progress Tracking</h3>
                                    <p class="text-gray-600">Detailed progress reports for parents and continuous
                                        assessment</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-blue-50 p-8 rounded-2xl">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Start Your Child's Journey</h3>
                            <p class="text-gray-600 mb-6">Join thousands of families who trust BriliantMath for their
                                children's mathematical education</p>
                            <div class="space-y-4">
                                @guest
                                    <a href="{{ route('register') }}"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-[#006738] text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        Get Started Free
                                    </a>
                                    <a href="{{ route('contact') }}"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 border-2 border-[#006738] text-[#006738] font-semibold rounded-lg hover:bg-[#006738] hover:text-white transition-colors duration-200">
                                        Book a Consultation
                                    </a>
                                @else
                                    <a href="{{ route('courses.index') }}"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-[#006738] text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        Browse All Courses
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-[#006738] to-green-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Ready to Build Strong Mathematical Foundations?
                </h2>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Start with our engaging primary courses and watch your child's confidence grow
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @guest
                        <a href="{{ route('register') }}"
                            class="px-8 py-3 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200">
                            Start Free Course
                        </a>
                        <a href="{{ route('contact') }}"
                            class="px-8 py-3 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-[#006738] transition-colors duration-200">
                            Contact Us
                        </a>
                    @else
                        <a href="{{ route('courses.index') }}"
                            class="px-8 py-3 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200">
                            Browse Courses
                        </a>
                    @endguest
                </div>
            </div>
        </section>
    </div>
@endsection
