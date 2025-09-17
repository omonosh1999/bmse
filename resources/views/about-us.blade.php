@extends('layouts.main')

@section('content')
    <div class="min-h-screen">
        <!-- Header Section -->
        <section class="bg-gradient-to-br from-[#006738] to-green-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    About <span class="text-[#FBC905]">BriliantMath</span>
                </h1>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Empowering students through quality mathematics education, transforming fear into confidence and
                    academic excellence
                </p>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-[#FBC905] rounded-full"></div>
                </div>
            </div>
        </section>

        <!-- Vision & Mission Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="order-2 lg:order-1">
                        <div
                            class="bg-gradient-to-br from-[#006738] to-green-700 text-white p-8 lg:p-12 rounded-2xl shadow-xl">
                            <h2 class="text-3xl md:text-4xl font-bold mb-6">Our Vision</h2>
                            <p class="text-lg text-green-100 leading-relaxed mb-8">
                                To create a comprehensive, engaging, and effective online learning platform that demystifies
                                Mathematics for students, transforming their fear into confidence and their academic
                                performance into success.
                            </p>

                            <h3 class="text-2xl font-bold mb-4 text-[#FBC905]">Key Objectives</h3>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="w-2 h-2 bg-[#FBC905] rounded-full mr-3 mt-2 flex-shrink-0"></div>
                                    <p class="text-green-100"><strong>Empower Students:</strong> Develop robust independent
                                        learning skills in Mathematics</p>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-2 h-2 bg-[#FBC905] rounded-full mr-3 mt-2 flex-shrink-0"></div>
                                    <p class="text-green-100"><strong>Build Confidence:</strong> Address and overcome maths
                                        anxiety and phobia</p>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-2 h-2 bg-[#FBC905] rounded-full mr-3 mt-2 flex-shrink-0"></div>
                                    <p class="text-green-100"><strong>Improve Performance:</strong> Provide targeted
                                        resources for significant grade improvement</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Our Mission</h2>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                            At BriliantMath, we believe that every student has the potential to excel in mathematics.
                            Our mission is to provide high-quality, accessible mathematics education that builds
                            confidence and fosters a deep understanding of mathematical concepts.
                        </p>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            We strive to make mathematics engaging, understandable, and relevant to students'
                            daily lives while preparing them for future academic and professional success.
                        </p>

                        <!-- Statistics -->
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-2xl md:text-3xl font-bold text-[#006738] mb-2">1000+</div>
                                <div class="text-sm text-gray-600">Students Helped</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-2xl md:text-3xl font-bold text-[#006738] mb-2">95%</div>
                                <div class="text-sm text-gray-600">Success Rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        These principles guide everything we do at BriliantMath
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div
                        class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow duration-200 group">
                        <div
                            class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Excellence</h3>
                        <p class="text-gray-600">Commitment to the highest standards in mathematics education and student
                            outcomes</p>
                    </div>

                    <div
                        class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow duration-200 group">
                        <div
                            class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Student-Centered</h3>
                        <p class="text-gray-600">Every decision we make prioritizes student learning, growth, and success
                        </p>
                    </div>

                    <div
                        class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow duration-200 group">
                        <div
                            class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Innovation</h3>
                        <p class="text-gray-600">Embracing cutting-edge teaching methods and educational technology</p>
                    </div>

                    <div
                        class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-xl transition-shadow duration-200 group">
                        <div
                            class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0 0V3"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Accessibility</h3>
                        <p class="text-gray-600">Making quality mathematics education available to students from all
                            backgrounds</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Target Audience Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Who We Serve</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Our comprehensive programs cater to diverse educational needs and curricula
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Students Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 lg:p-12 rounded-2xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">For Students</h3>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            We support primary and secondary school students following various curriculum standards:
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">British National Numeracy Curriculum</h4>
                                    <p class="text-gray-600">Comprehensive coverage of the British mathematics standards
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Cambridge IGCSE Curriculum</h4>
                                    <p class="text-gray-600">Aligned with Cambridge International Education standards</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">WAEC Syllabus</h4>
                                    <p class="text-gray-600">Complete preparation for West African Examination Council
                                        requirements</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Teachers Section -->
                    <div class="bg-gradient-to-br from-green-50 to-teal-50 p-8 lg:p-12 rounded-2xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">For Teachers</h3>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Professional development and curriculum resources to enhance teaching effectiveness:
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Curriculum Development</h4>
                                    <p class="text-gray-600">Access to comprehensive curriculum development resources</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Training Workshops</h4>
                                    <p class="text-gray-600">Regular seminars for Primary and Secondary Teachers</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Resource Library</h4>
                                    <p class="text-gray-600">Articles and materials on effective teaching methodologies</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Meet Our Expert Team
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Our dedicated educators and curriculum specialists bring years of experience and passion to
                        mathematics education
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-white p-8 rounded-2xl shadow-lg text-center hover:shadow-xl transition-shadow duration-200 group">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full mx-auto mb-6 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                            <span class="text-white font-bold text-2xl">SJ</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Dr. Sarah Johnson</h3>
                        <p class="text-[#006738] font-medium mb-3">Lead Mathematics Educator</p>
                        <p class="text-gray-600 text-sm leading-relaxed">PhD in Mathematics Education with 15+ years of
                            teaching experience specializing in curriculum development and student assessment.</p>
                    </div>

                    <div
                        class="bg-white p-8 rounded-2xl shadow-lg text-center hover:shadow-xl transition-shadow duration-200 group">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full mx-auto mb-6 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                            <span class="text-white font-bold text-2xl">MC</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Prof. Michael Chen</h3>
                        <p class="text-[#006738] font-medium mb-3">Curriculum Director</p>
                        <p class="text-gray-600 text-sm leading-relaxed">Former university professor specializing in
                            mathematical pedagogy with expertise in international curriculum standards.</p>
                    </div>

                    <div
                        class="bg-white p-8 rounded-2xl shadow-lg text-center hover:shadow-xl transition-shadow duration-200 group">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full mx-auto mb-6 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                            <span class="text-white font-bold text-2xl">ER</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Ms. Emily Rodriguez</h3>
                        <p class="text-[#006738] font-medium mb-3">Primary Education Specialist</p>
                        <p class="text-gray-600 text-sm leading-relaxed">Expert in early childhood mathematics education
                            and learning psychology with a focus on building mathematical confidence.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact CTA -->
        <section class="py-20 bg-gradient-to-br from-[#006738] to-green-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Ready to Join Our Community?
                </h2>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Become part of the BriliantMath family and unlock your mathematical potential with our comprehensive
                    learning platform
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                        class="px-8 py-3 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200">
                        Contact Us Today
                    </a>
                    <a href="{{ route('courses.index') }}"
                        class="px-8 py-3 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-[#006738] transition-colors duration-200">
                        View Our Courses
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
