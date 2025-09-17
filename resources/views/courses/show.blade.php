<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->title }}
            </h2>
            <div class="flex space-x-2">
                @if ($course->status === 'draft')
                    <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Draft</span>
                @elseif($course->status === 'published')
                    <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Published</span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-green-600 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Course Header -->
                    <div class="flex flex-col lg:flex-row gap-6 mb-8">
                        <!-- Cover Photo -->
                        <div class="lg:w-1/3">
                            @if ($course->cover_photo)
                                <img src="{{ asset('storage/' . $course->cover_photo) }}" alt="{{ $course->title }}"
                                    class="w-full h-48 object-cover rounded-lg shadow-md">
                            @else
                                <div
                                    class="w-full h-48 bg-gray-200 rounded-lg shadow-md flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Course Details -->
                        <div class="lg:w-2/3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Category</label>
                                    <p class="text-lg font-medium">{{ ucfirst($course->category) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Class Level</label>
                                    <p class="text-lg font-medium">{{ $course->class_level }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Instructor</label>
                                    <p class="text-lg font-medium">{{ $course->instructor }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Total Lessons</label>
                                    <p class="text-lg font-medium">{{ $course->lessons->count() }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                                <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-2">
                                @if ($course->status === 'draft')
                                    @if ($course->lessons->count() > 0)
                                        <form method="POST" action="{{ route('courses.publish', $course) }}"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Publish Course
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form method="POST" action="{{ route('courses.unpublish', $course) }}"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            Unpublish
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('courses.edit', $course) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit Course
                                </a>

                                <a href="{{ route('courses.curriculum.create', $course) }}"
                                    class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    {{ $course->lessons->count() > 0 ? 'Edit Curriculum' : 'Add Curriculum' }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Curriculum Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Course Curriculum</h3>

                        @if ($course->lessons->count() > 0)
                            <div class="space-y-4">
                                @foreach ($course->lessons as $index => $lesson)
                                    <div class="bg-gray-50 rounded-lg p-4 border">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center mb-2">
                                                    <span
                                                        class="inline-flex items-center justify-center w-6 h-6 bg-blue-600 text-white text-xs font-medium rounded-full mr-3">
                                                        {{ $index + 1 }}
                                                    </span>
                                                    <h4 class="text-lg font-medium text-gray-900">{{ $lesson->title }}
                                                    </h4>
                                                </div>
                                                <p class="text-gray-600 mb-3 ml-9">{{ $lesson->description }}</p>
                                                <div class="ml-9 flex items-center space-x-4 text-sm text-gray-500">
                                                    <div class="flex items-center">
                                                        @if ($lesson->isVideo())
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V8a2 2 0 012-2h2a2 2 0 012 2v2">
                                                                </path>
                                                            </svg>
                                                            Video
                                                        @elseif($lesson->isPdf())
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                            PDF Document
                                                        @else
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                            {{ $lesson->isFile() ? 'File' : 'Link' }}
                                                        @endif
                                                    </div>
                                                    <div>•</div>
                                                    <div>{{ ucfirst($lesson->material_type) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No curriculum added</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by adding lessons to your course.</p>
                                <div class="mt-6">
                                    <a href="{{ route('courses.curriculum.create', $course) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add Curriculum
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
