@extends('layouts.main')

@section('content')
    <div class="min-h-screen">
        <!-- Header Section -->
        <section class="bg-gradient-to-br from-[#006738] to-green-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Secondary <span class="text-[#FBC905]">Mathematics</span>
                </h1>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Advanced mathematics education for Form 1 through Form 6 students
                </p>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-[#FBC905] rounded-full"></div>
                </div>
            </div>
        </section>

        <!-- Filters and Search Section -->
        <section class="py-6 lg:py-8 bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <form method="GET" action="{{ route('secondary') }}"
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
                        <!-- Form Filter -->
                        <div class="flex flex-col sm:flex-row sm:gap-2 sm:items-center">
                            <label for="form"
                                class="text-sm font-medium text-gray-700 mb-1 sm:mb-0 sm:whitespace-nowrap">
                                Filter by Form:
                            </label>
                            <select name="form" id="form"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-[#006738] focus:border-[#006738] text-sm sm:text-base min-w-0">
                                <option value="">All Forms</option>
                                @foreach ($availableForms as $form)
                                    <option value="{{ $form }}" {{ request('form') == $form ? 'selected' : '' }}>
                                        {{ $form }}
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
                            @if (request('search') || request('form'))
                                <a href="{{ route('secondary') }}"
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
                            @if (request('form'))
                                <span class="block sm:inline text-base sm:text-lg font-normal text-gray-600">for
                                    {{ request('form') }}</span>
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
                                duration="" :lessons="$course->lessons->count() . ' lessons'" price="" :route="route('courses.preview', $course)" buttonText="View Course"
                                :badge="$course->lessons->count() > 20
                                    ? 'Comprehensive'
                                    : ($course->lessons->count() > 10
                                        ? 'Standard'
                                        : 'Compact')" :featured="$course->lessons->count() > 30" />
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
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">
                            @if (request('search') || request('form'))
                                No courses found
                            @else
                                No secondary courses available yet
                            @endif
                        </h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            @if (request('search') || request('form'))
                                Try adjusting your search criteria or filters to find more courses.
                            @else
                                Check back later for new secondary mathematics courses.
                            @endif
                        </p>
                        @if (request('search') || request('form'))
                            <a href="{{ route('secondary') }}"
                                class="inline-flex items-center px-6 py-3 bg-[#006738] text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                                View All Courses
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <!-- Key Topics Section -->
        <section class="py-12 lg:py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-center text-gray-900 mb-8 lg:mb-12">
                    Advanced Mathematical Concepts
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div class="bg-gray-50 p-4 sm:p-6 rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="text-[#006738] mb-3">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Algebra</h3>
                        <p class="text-gray-600 text-sm">Linear and quadratic equations, polynomials, and functions</p>
                    </div>
                    <div class="bg-gray-50 p-4 sm:p-6 rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="text-[#006738] mb-3">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Statistics</h3>
                        <p class="text-gray-600 text-sm">Data analysis, probability, and statistical inference</p>
                    </div>
                    <div class="bg-gray-50 p-4 sm:p-6 rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="text-[#006738] mb-3">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Trigonometry</h3>
                        <p class="text-gray-600 text-sm">Sine, cosine, tangent, and their applications</p>
                    </div>
                    <div class="bg-gray-50 p-4 sm:p-6 rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="text-[#006738] mb-3">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Calculus</h3>
                        <p class="text-gray-600 text-sm">Differentiation, integration, and mathematical analysis</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Key Features Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Our Secondary Program?</h2>
                    <p class="text-lg text-gray-600">Advanced preparation for academic success and future opportunities</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Ages 11-18</h3>
                        <p class="text-gray-600">Advanced curriculum for secondary school students</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Exam Success</h3>
                        <p class="text-gray-600">Proven track record of high grades and exam success</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">University Ready</h3>
                        <p class="text-gray-600">Preparation for higher education and career advancement</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Secondary Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            Excel in Secondary Mathematics
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
                                    <p class="text-gray-600">Fully aligned with local and international curriculum
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
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Expert Instructors</h3>
                                    <p class="text-gray-600">Qualified secondary mathematics teachers with proven track
                                        records</p>
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
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Exam Preparation</h3>
                                    <p class="text-gray-600">Comprehensive preparation for WAEC, IGCSE, and other
                                        examinations</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-8 rounded-2xl">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Achieve Academic Excellence</h3>
                            <p class="text-gray-600 mb-6">Join thousands of students who have achieved top grades and
                                university places</p>
                            <div class="space-y-4">
                                @guest
                                    <a href="{{ route('register') }}"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-[#006738] text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        Start Free Trial
                                    </a>
                                    <a href="{{ route('contact') }}"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 border-2 border-[#006738] text-[#006738] font-semibold rounded-lg hover:bg-[#006738] hover:text-white transition-colors duration-200">
                                        Book Expert Consultation
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
        <section class="py-12 lg:py-16 bg-[#006738]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4 lg:mb-6">
                    Excel in Secondary Mathematics
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-green-100 mb-6 lg:mb-8 max-w-2xl mx-auto">
                    Prepare for advanced mathematics and future academic success
                </p>
                @guest
                    <a href="{{ route('register') }}"
                        class="inline-block px-6 sm:px-8 py-3 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200 text-sm sm:text-base">
                        Get Started
                    </a>
                @else
                    <a href="{{ route('courses.index') }}"
                        class="inline-block px-6 sm:px-8 py-3 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200 text-sm sm:text-base">
                        Browse Courses
                    </a>
                @endguest
            </div>
        </section>
    </div>
@endsection
