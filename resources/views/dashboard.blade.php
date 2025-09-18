<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('courses.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                    Create Course
                </a>
                <a href="{{ route('quizzes.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                    Create Quiz
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="text-blue-100">Here's an overview of your courses and quizzes.</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Total Courses</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalCourses }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Published Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Published Courses</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $publishedCourses }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Quizzes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Total Quizzes</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalQuizzes }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Quizzes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Active Quizzes</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $activeQuizzes }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Courses</h3>
                            <a href="{{ route('courses.index') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View All
                            </a>
                        </div>

                        @if ($recentCourses->count() > 0)
                            <div class="space-y-4">
                                @foreach ($recentCourses as $course)
                                    <div
                                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-150 ease-in-out">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 mb-1">
                                                    <a href="{{ route('courses.show', $course) }}"
                                                        class="hover:text-blue-600">
                                                        {{ $course->title }}
                                                    </a>
                                                </h4>
                                                <p class="text-sm text-gray-600 mb-2">
                                                    {{ Str::limit($course->description, 100) }}</p>
                                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                            </path>
                                                        </svg>
                                                        {{ ucfirst($course->category) }}
                                                    </span>
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $course->lessons_count }} lessons
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex flex-col items-end">
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if ($course->status === 'published') bg-green-100 text-green-800 
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($course->status) }}
                                                </span>
                                                <span class="text-xs text-gray-500 mt-1">
                                                    {{ $course->updated_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                <p class="text-gray-500 mb-4">No courses created yet</p>
                                <a href="{{ route('courses.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Create Your First Course
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Quizzes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Quizzes</h3>
                            <a href="{{ route('quizzes.index') }}"
                                class="text-green-600 hover:text-green-800 text-sm font-medium">
                                View All
                            </a>
                        </div>

                        @if ($recentQuizzes->count() > 0)
                            <div class="space-y-4">
                                @foreach ($recentQuizzes as $quiz)
                                    <div
                                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-150 ease-in-out">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 mb-1">
                                                    <a href="{{ route('quizzes.show', $quiz) }}"
                                                        class="hover:text-green-600">
                                                        {{ $quiz->title }}
                                                    </a>
                                                </h4>
                                                <p class="text-sm text-gray-600 mb-2">
                                                    {{ Str::limit($quiz->description, 100) }}</p>
                                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                            </path>
                                                        </svg>
                                                        {{ $quiz->questions_count }} questions
                                                    </span>
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                            </path>
                                                        </svg>
                                                        {{ $quiz->attempts_count }} attempts
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex flex-col items-end">
                                                <div class="flex space-x-1">
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                        @if ($quiz->status === 'published') bg-green-100 text-green-800 
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ ucfirst($quiz->status) }}
                                                    </span>
                                                    @if ($quiz->is_active)
                                                        <span
                                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Active
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-gray-500 mt-1">
                                                    {{ $quiz->updated_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                <p class="text-gray-500 mb-4">No quizzes created yet</p>
                                <a href="{{ route('quizzes.create') }}"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Create Your First Quiz
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
