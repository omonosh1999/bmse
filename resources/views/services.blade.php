@extends('layouts.main')

@section('content')
    <div class="min-h-screen">
        <!-- Header Section -->
        <section class="bg-gradient-to-br from-[#006738] to-green-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Our <span class="text-[#FBC905]">Services</span>
                </h1>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Comprehensive mathematics education solutions designed to transform learning experiences and academic
                    outcomes
                </p>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-[#FBC905] rounded-full"></div>
                </div>
            </div>
        </section>

        <!-- Core Services Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Core Learning Services</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Our comprehensive suite of educational services designed to meet diverse learning needs
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Self-Paced Learning -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 lg:p-12 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Self-Paced Learning Modules</h3>
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            A structured library of curriculum-aligned lessons and modules, allowing students to learn at
                            their own pace with comprehensive progress tracking.
                        </p>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Curriculum-aligned content</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Progress tracking and analytics</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Flexible learning schedules</span>
                            </div>
                        </div>
                        <a href="{{ route('courses.index') }}"
                            class="inline-flex items-center text-[#006738] font-semibold hover:underline">
                            Explore Learning Modules
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <!-- Interactive Exercises -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl p-8 lg:p-12 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Interactive Exercises & Assessments</h3>
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            A vast repository of practice exercises, quizzes, and mock exams with instant feedback and
                            detailed explanations to reinforce learning.
                        </p>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Instant feedback system</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Detailed step-by-step solutions</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Adaptive difficulty levels</span>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}"
                            class="inline-flex items-center text-[#006738] font-semibold hover:underline">
                            Try Interactive Exercises
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <!-- Video Library -->
                    <div
                        class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 lg:p-12 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Video Lesson Library</h3>
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            A comprehensive collection of pre-recorded video tutorials explaining key concepts,
                            problem-solving techniques, and common exam questions.
                        </p>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">HD quality video content</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Searchable topic index</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Mobile-friendly streaming</span>
                            </div>
                        </div>
                        <a href="{{ route('courses.index') }}"
                            class="inline-flex items-center text-[#006738] font-semibold hover:underline">
                            Browse Video Library
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <!-- Live Classes -->
                    <div
                        class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-8 lg:p-12 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Live Online Lessons</h3>
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Scheduled, interactive live classes taught by expert instructors for real-time learning,
                            doubt-solving, and student engagement.
                        </p>
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Real-time interaction with instructors</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Small class sizes for personalized attention</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Session recordings available</span>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}"
                            class="inline-flex items-center text-[#006738] font-semibold hover:underline">
                            Join Live Classes
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Additional Services -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Additional Services</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Specialized services to support comprehensive mathematical education
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Teacher Training -->
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-8 hover:shadow-lg hover:border-[#006738] transition-all duration-200 group">
                        <div
                            class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Teacher Training & Seminars</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Professional development workshops and seminars for
                            Primary and Secondary Teachers focusing on effective mathematics pedagogy.</p>
                        <ul class="text-sm text-gray-600 space-y-2 mb-6">
                            <li class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-2"></div>
                                Curriculum development resources
                            </li>
                            <li class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-2"></div>
                                Workshop registrations
                            </li>
                            <li class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-2"></div>
                                Teaching methodology resources
                            </li>
                        </ul>
                        <a href="{{ route('contact') }}"
                            class="text-[#006738] font-medium hover:underline flex items-center">
                            Learn More
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <!-- Physical Classes -->
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-8 hover:shadow-lg hover:border-[#006738] transition-all duration-200 group">
                        <div
                            class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Physical Classes</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">In-person morning and after-school mathematics
                            classes at our Labone, Accra campus with plans for additional satellite locations.</p>
                        <ul class="text-sm text-gray-600 space-y-2 mb-6">
                            <li class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></div>
                                Morning sessions available
                            </li>
                            <li class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></div>
                                After-school programs
                            </li>
                            <li class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></div>
                                Small class sizes
                            </li>
                        </ul>
                        <a href="{{ route('contact') }}"
                            class="text-[#006738] font-medium hover:underline flex items-center">
                            Enroll Now
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <!-- Textbook Sales -->
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-8 hover:shadow-lg hover:border-[#006738] transition-all duration-200 group">
                        <div
                            class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">BriliantMath Textbooks</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Comprehensive mathematics textbooks designed to
                            complement our curriculum and provide additional practice and reference materials.</p>
                        <ul class="text-sm text-gray-600 space-y-2 mb-6">
                            <li class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></div>
                                Curriculum-aligned content
                            </li>
                            <li class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></div>
                                Practice exercises included
                            </li>
                            <li class="flex items-center">
                                <div class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></div>
                                Digital and print versions
                            </li>
                        </ul>
                        <a href="{{ route('contact') }}"
                            class="text-[#006738] font-medium hover:underline flex items-center">
                            View Catalog
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Learning Paths Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Choose Your Learning Path</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Tailored educational programs designed for different learning levels and objectives
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Primary -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow duration-200 group">
                        <div
                            class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Primary Mathematics</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Foundation building with engaging lessons for young
                            learners. British National Numeracy aligned.</p>
                        <div class="space-y-2 mb-8 text-sm text-gray-600">
                            <div class="flex justify-center items-center">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">Ages 5-11</span>
                            </div>
                        </div>
                        <a href="{{ route('primary') }}"
                            class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 transition-colors duration-200">
                            Start Learning
                        </a>
                    </div>

                    <!-- Secondary -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow duration-200 group">
                        <div
                            class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Secondary Mathematics</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Advanced concepts and exam preparation. Cambridge
                            IGCSE and WAEC curricula supported.</p>
                        <div class="space-y-2 mb-8 text-sm text-gray-600">
                            <div class="flex justify-center items-center">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">Ages 11-18</span>
                            </div>
                        </div>
                        <a href="{{ route('secondary') }}"
                            class="inline-block px-6 py-3 bg-green-600 text-white font-semibold rounded-full hover:bg-green-700 transition-colors duration-200">
                            Explore Courses
                        </a>
                    </div>

                    <!-- Mental Math -->
                    <div
                        class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow duration-200 group">
                        <div
                            class="w-20 h-20 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">Mental Mathematics</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Rapid calculation techniques and mental math
                            strategies for enhanced mathematical fluency.</p>
                        <div class="space-y-2 mb-8 text-sm text-gray-600">
                            <div class="flex justify-center items-center">
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">All Ages</span>
                            </div>
                        </div>
                        <a href="{{ route('mental') }}"
                            class="inline-block px-6 py-3 bg-yellow-600 text-white font-semibold rounded-full hover:bg-yellow-700 transition-colors duration-200">
                            Train Your Mind
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-[#006738] to-green-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Ready to Get Started?
                </h2>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Contact us today to learn more about our services and find the perfect solution for your mathematical
                    learning needs
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                        class="px-8 py-3 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200">
                        Contact Us Now
                    </a>
                    <a href="{{ route('courses.index') }}"
                        class="px-8 py-3 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-[#006738] transition-colors duration-200">
                        Browse Courses
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
