@extends('layouts.main')

@section('content')
    <div class="min-h-screen">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-[#006738] to-green-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                            Transform Your <span class="text-[#FBC905]">Math Journey</span>
                        </h1>
                        <p class="text-lg md:text-xl text-green-100 mb-8 leading-relaxed">
                            Discover comprehensive, engaging mathematics education that builds confidence and transforms
                            fear into success. From Primary to Advanced levels.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('primary') }}"
                                class="px-8 py-4 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200 text-center">
                                Primary Mathematics
                            </a>
                            <a href="{{ route('secondary') }}"
                                class="px-8 py-4 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-[#006738] transition-colors duration-200 text-center">
                                Secondary Mathematics
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center justify-center">
                        <div
                            class="w-96 h-96 bg-white bg-opacity-10 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-48 h-48 text-[#FBC905]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest Courses Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Latest Courses
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Discover our newest mathematics courses designed to help you excel
                    </p>
                </div>

                @if ($courses->count() > 0)
                    <!-- Course Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        @foreach ($courses as $course)
                            <x-course-card :title="$course->title" :description="Str::limit($course->description, 120)" :image="$course->cover_photo ? asset('storage/' . $course->cover_photo) : null" :level="$course->class_level"
                                duration="" :lessons="$course->lessons->count() . ' lessons'" price="Free" :route="route('courses.preview', $course)" buttonText="View Course"
                                :badge="$course->lessons->count() > 15
                                    ? 'Complete Course'
                                    : ($course->lessons->count() > 8
                                        ? 'Standard'
                                        : 'Starter')" :featured="$course->category === 'secondary'" />
                        @endforeach
                    </div>
                @else
                    <!-- No Courses Available -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">No Courses Available Yet</h3>
                        <p class="text-gray-600 mb-6">New courses are coming soon. Check back later for the latest
                            mathematics courses.</p>
                    </div>
                @endif

                <div class="text-center">
                    <a href="{{ route('primary') }}"
                        class="inline-block px-6 py-3 bg-[#006738] text-white font-semibold rounded-full hover:bg-green-700 transition-colors duration-200 mr-4">
                        Primary Courses
                    </a>
                    <a href="{{ route('secondary') }}"
                        class="inline-block px-6 py-3 bg-[#006738] text-white font-semibold rounded-full hover:bg-green-700 transition-colors duration-200">
                        Secondary Courses
                    </a>
                </div>
            </div>
        </section>

        <!-- Quick Access Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Choose Your Learning Path
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Select the program that matches your level and start your mathematical transformation today
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Primary -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-200 text-center group">
                        <div
                            class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Primary Mathematics</h3>
                        <p class="text-gray-600 mb-6">Foundation building with engaging lessons for young learners. Ages
                            5-11.</p>
                        <a href="{{ route('primary') }}"
                            class="inline-block px-6 py-3 bg-[#006738] text-white font-semibold rounded-full hover:bg-green-700 transition-colors duration-200">
                            Start Learning
                        </a>
                    </div>

                    <!-- Secondary -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-200 text-center group">
                        <div
                            class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Secondary Mathematics</h3>
                        <p class="text-gray-600 mb-6">Advanced concepts and exam preparation. IGCSE, WAEC curricula. Ages
                            11-18.</p>
                        <a href="{{ route('secondary') }}"
                            class="inline-block px-6 py-3 bg-[#006738] text-white font-semibold rounded-full hover:bg-green-700 transition-colors duration-200">
                            Explore Courses
                        </a>
                    </div>

                    <!-- Mental Math -->
                    <div
                        class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-200 text-center group">
                        <div
                            class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Mental Mathematics</h3>
                        <p class="text-gray-600 mb-6">Rapid calculation techniques and mental math strategies for all ages.
                        </p>
                        <a href="{{ route('mental') }}"
                            class="inline-block px-6 py-3 bg-[#006738] text-white font-semibold rounded-full hover:bg-green-700 transition-colors duration-200">
                            Train Your Mind
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Business Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            Our Vision & Mission
                        </h2>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                            At BriliantMath, we envision a world where every student develops confidence and mastery in
                            mathematics.
                            Our comprehensive online platform transforms mathematical fear into academic success through
                            engaging,
                            curriculum-aligned education.
                        </p>
                        <div class="space-y-4 mb-8">
                            <div class="flex items-start">
                                <div
                                    class="w-6 h-6 bg-[#006738] text-white rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">British & Cambridge Curricula</h3>
                                    <p class="text-gray-600">Aligned with British National Numeracy and Cambridge IGCSE
                                        standards</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="w-6 h-6 bg-[#006738] text-white rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">WAEC Preparation</h3>
                                    <p class="text-gray-600">Comprehensive preparation for West African Examination Council
                                        syllabus</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div
                                    class="w-6 h-6 bg-[#006738] text-white rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Physical Classes Available</h3>
                                    <p class="text-gray-600">Morning and after-school classes at our Labone, Accra campus
                                    </p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('about-us') }}"
                            class="inline-block px-6 py-3 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200">
                            Learn More About Us
                        </a>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6">What We Offer</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Self-Paced Learning</h4>
                                    <p class="text-sm text-gray-600">Study at your own pace with structured modules</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Live Online Classes</h4>
                                    <p class="text-sm text-gray-600">Interactive sessions with expert instructors</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Practice & Assessment</h4>
                                    <p class="text-sm text-gray-600">Comprehensive exercises and progress tracking</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Teacher Training</h4>
                                    <p class="text-sm text-gray-600">Professional development for educators</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-[#006738]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Ready to Transform Your Math Skills?
                </h2>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-2xl mx-auto">
                    Join thousands of students who have conquered their fear of mathematics and achieved academic success
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('primary') }}"
                        class="px-8 py-3 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200">
                        Start Learning Today
                    </a>
                    <a href="{{ route('contact') }}"
                        class="px-8 py-3 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-[#006738] transition-colors duration-200">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
