@extends('layouts.main')

@section('title', $course->title)

@section('content')
    <div class="min-h-screen bg-gray-100">
        <!-- Course Header -->
        <div class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-3 sm:py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2 sm:space-x-4 min-w-0 flex-1">
                        <a href="{{ route('primary') }}" class="text-white hover:text-gray-300 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </a>
                        <h1 class="text-sm sm:text-lg font-medium truncate">{{ $course->title }}</h1>
                    </div>
                    <div class="flex items-center space-x-2 sm:space-x-4 flex-shrink-0">
                        <div class="text-xs sm:text-sm">
                            <span class="text-gray-300">Your progress</span>
                            <div class="w-16 sm:w-20 bg-gray-700 rounded-full h-1 mt-1">
                                <div class="bg-purple-600 h-1 rounded-full"
                                    style="width: {{ $lessons->count() > 0 ? ($currentLessonIndex / $lessons->count()) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile progress bar -->
                <div class="mt-2 lg:hidden">
                    <div class="flex items-center justify-between text-xs text-gray-300">
                        <span>Progress</span>
                        <span>{{ $currentLessonIndex + 1 }}/{{ $lessons->count() }}</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-1 mt-1">
                        <div class="bg-purple-600 h-1 rounded-full"
                            style="width: {{ $lessons->count() > 0 ? ($currentLessonIndex / $lessons->count()) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row">
            <!-- Main Content Area -->
            <div class="flex-1 order-1 lg:order-1">
                <!-- Video/Content Player - Updated Heights -->
                <div class="bg-black relative h-[50vh] lg:h-[70vh]">
                    @if ($currentLesson)
                        {{-- Check for URL content (videos) --}}
                        @if ($currentLesson->material_type === 'url' && !empty($currentLesson->material_path))
                            @php
                                $videoId = null;
                                $platform = null;
                                $videoUrl = trim($currentLesson->material_path);

                                // YouTube detection - multiple patterns
                                if (
                                    preg_match(
                                        '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/',
                                        $videoUrl,
                                        $matches,
                                    )
                                ) {
                                    $videoId = $matches[1];
                                    $platform = 'youtube';
                                }
                                // Vimeo detection
                                elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches)) {
                                    $videoId = $matches[1];
                                    $platform = 'vimeo';
                                }
                            @endphp

                            @if ($platform === 'youtube' && $videoId)
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1&controls=1"
                                    frameborder="0" allowfullscreen
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    class="w-full h-full">
                                </iframe>
                            @elseif($platform === 'vimeo' && $videoId)
                                <iframe src="https://player.vimeo.com/video/{{ $videoId }}?title=0&byline=0&portrait=0"
                                    frameborder="0" allowfullscreen class="w-full h-full">
                                </iframe>
                            @else
                                {{-- Fallback for other URLs --}}
                                <div class="flex items-center justify-center h-full p-4">
                                    <div class="text-center text-white">
                                        <svg class="w-12 sm:w-20 h-12 sm:h-20 mx-auto mb-4 text-purple-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                        <h3 class="text-base sm:text-lg font-medium mb-2">External Link</h3>
                                        <p class="text-gray-400 mb-4 text-sm">This content opens in a new window</p>
                                        <a href="{{ $videoUrl }}" target="_blank"
                                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 sm:px-6 py-2 rounded-lg font-medium text-sm">
                                            Open Link
                                        </a>
                                    </div>
                                </div>
                            @endif

                            {{-- Check for file content (documents) --}}
                        @elseif($currentLesson->material_type === 'file' && !empty($currentLesson->material_path))
                            @php
                                $filePath = $currentLesson->material_path;
                                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                                $fileName = basename($filePath);
                                $fileUrl = Storage::url($filePath);
                            @endphp

                            @if (in_array(strtolower($fileExtension), ['pdf']))
                                {{-- PDF Embedded Viewer --}}
                                <iframe src="{{ $fileUrl }}#toolbar=1&navpanes=1&scrollbar=1" class="w-full h-full"
                                    style="border: none;">
                                </iframe>
                            @else
                                {{-- Other document types - show preview with actions --}}
                                <div class="flex items-center justify-center h-full p-4">
                                    <div class="text-center text-white max-w-md">
                                        @if (in_array(strtolower($fileExtension), ['ppt', 'pptx']))
                                            <svg class="w-12 sm:w-20 h-12 sm:h-20 mx-auto mb-4 text-orange-400"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                            </svg>
                                            <h3 class="text-base sm:text-lg font-medium mb-2">PowerPoint Presentation</h3>
                                        @elseif(in_array(strtolower($fileExtension), ['doc', 'docx']))
                                            <svg class="w-12 sm:w-20 h-12 sm:h-20 mx-auto mb-4 text-blue-400"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                            </svg>
                                            <h3 class="text-base sm:text-lg font-medium mb-2">Word Document</h3>
                                        @elseif(in_array(strtolower($fileExtension), ['xls', 'xlsx']))
                                            <svg class="w-12 sm:w-20 h-12 sm:h-20 mx-auto mb-4 text-green-400"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                            </svg>
                                            <h3 class="text-base sm:text-lg font-medium mb-2">Excel Spreadsheet</h3>
                                        @elseif(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ $fileUrl }}" alt="{{ $fileName }}"
                                                class="max-w-full max-h-full object-contain" />
                                        @else
                                            <svg class="w-12 sm:w-20 h-12 sm:h-20 mx-auto mb-4 text-gray-400"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                            </svg>
                                            <h3 class="text-base sm:text-lg font-medium mb-2">Document</h3>
                                        @endif

                                        @if (!in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                            <p class="text-gray-400 mb-6 text-xs sm:text-sm">{{ $fileName }}</p>
                                            <div
                                                class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-3">
                                                @if (in_array(strtolower($fileExtension), ['ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx']))
                                                    <a href="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(url($fileUrl)) }}"
                                                        target="_blank"
                                                        class="bg-purple-600 hover:bg-purple-700 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium">
                                                        View Online
                                                    </a>
                                                @endif
                                                <a href="{{ $fileUrl }}" download
                                                    class="bg-gray-600 hover:bg-gray-700 text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium">
                                                    Download
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- Check for text content in description --}}
                        @elseif(!empty($currentLesson->description))
                            <div class="flex items-center justify-center h-full p-4 overflow-y-auto">
                                <div class="text-center text-white max-w-4xl">
                                    <svg class="w-12 sm:w-16 h-12 sm:h-16 mx-auto mb-4 sm:mb-6 text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg sm:text-2xl font-bold mb-4 sm:mb-6">{{ $currentLesson->title }}</h3>
                                    <div
                                        class="text-left bg-gray-800 rounded-lg p-4 sm:p-8 text-gray-100 leading-relaxed text-sm sm:text-base">
                                        {!! nl2br(e($currentLesson->description)) !!}
                                    </div>
                                </div>
                            </div>

                            {{-- No content available --}}
                        @else
                            <div class="flex items-center justify-center h-full p-4">
                                <div class="text-center text-gray-400">
                                    <svg class="w-12 sm:w-16 h-12 sm:h-16 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <h3 class="text-base sm:text-lg font-medium mb-2 text-white">
                                        {{ $currentLesson->title }}</h3>
                                    <p class="text-sm">No content available for this lesson</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Course Complete -->
                        <div class="flex items-center justify-center h-full p-4">
                            <div class="text-center text-white">
                                <div
                                    class="w-16 sm:w-20 h-16 sm:h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                                    <svg class="w-8 sm:w-10 h-8 sm:h-10" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-bold mb-4">Course Complete!</h2>
                                <p class="text-gray-300 mb-6 sm:mb-8">You've finished {{ $course->title }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Video Controls Bar -->
                <div class="bg-gray-900 text-white px-3 sm:px-4 py-2 flex items-center justify-between">
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        @if ($currentLesson && $currentLessonIndex > 0)
                            <a href="{{ route('courses.preview', ['course' => $course, 'lesson' => $currentLessonIndex - 1]) }}"
                                class="text-gray-300 hover:text-white p-1">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        @endif

                        <div class="text-xs sm:text-sm">1x</div>

                        @if ($currentLesson)
                            <div class="text-xs sm:text-sm text-gray-300 hidden sm:block">0:00 / 0:00</div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <div class="text-xs sm:text-sm text-gray-300 hidden sm:block">Auto-play is on</div>

                        @if ($currentLesson && $currentLessonIndex < $lessons->count() - 1)
                            <a href="{{ route('courses.preview', ['course' => $course, 'lesson' => $currentLessonIndex + 1]) }}"
                                class="text-gray-300 hover:text-white p-1">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Content Tabs -->
                <div class="bg-white border-b">
                    <div class="max-w-6xl mx-auto">
                        <nav class="flex overflow-x-auto px-3 sm:px-6 space-x-4 sm:space-x-8"
                            style="scrollbar-width: none; -ms-overflow-style: none;">
                            <!-- Curriculum Tab - Now Default Active -->
                            <button
                                class="tab-button py-4 px-1 border-b-2 border-purple-600 font-medium text-xs sm:text-sm text-purple-600 flex-shrink-0 lg:hidden"
                                data-tab="curriculum">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    Curriculum
                                </span>
                            </button>
                            <!-- Overview Tab - Now Second -->
                            <button
                                class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0"
                                data-tab="overview">
                                Overview
                            </button>
                            <button
                                class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0"
                                data-tab="qa">
                                Q&A
                            </button>
                            <button
                                class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0"
                                data-tab="notes">
                                Notes
                            </button>
                            <button
                                class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0"
                                data-tab="announcements">
                                Announcements
                            </button>
                            <button
                                class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0"
                                data-tab="reviews">
                                Reviews
                            </button>
                            <button
                                class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 flex-shrink-0"
                                data-tab="tools">
                                Learning tools
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="bg-white px-3 sm:px-6 py-6 sm:py-8">
                    <div class="max-w-4xl">
                        <!-- Curriculum Tab Content - Now Default -->
                        <div class="tab-content" id="curriculum-content">
                            <div class="border border-gray-200 rounded-lg bg-gray-50 lg:hidden">
                                <div class="p-4 border-b bg-white rounded-t-lg">
                                    <h3 class="font-semibold text-gray-900 mb-1">Course content</h3>
                                    <div class="text-sm text-gray-600">
                                        {{ $lessons->count() }} lectures • Lesson {{ $currentLessonIndex + 1 }} of
                                        {{ $lessons->count() }}
                                    </div>
                                </div>

                                <div class="divide-y divide-gray-200">
                                    @foreach ($lessons as $index => $lesson)
                                        <a href="{{ route('courses.preview', ['course' => $course, 'lesson' => $index]) }}"
                                            class="block px-4 py-4 hover:bg-gray-100 {{ $currentLessonIndex === $index ? 'bg-purple-50 border-l-4 border-l-purple-600' : '' }}">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 mr-3">
                                                    @if ($currentLessonIndex === $index)
                                                        <div
                                                            class="w-6 h-6 bg-purple-600 rounded-full flex items-center justify-center">
                                                            <svg class="w-3 h-3 text-white" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                    @elseif($currentLessonIndex > $index)
                                                        <div
                                                            class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-white" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div
                                                            class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                                                            <span class="text-xs text-gray-600">{{ $index + 1 }}</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start">
                                                        @if ($lesson->material_type === 'url')
                                                            <svg class="w-4 h-4 mr-2 mt-0.5 text-gray-500 flex-shrink-0"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                                </path>
                                                            </svg>
                                                        @elseif($lesson->material_type === 'file')
                                                            <svg class="w-4 h-4 mr-2 mt-0.5 text-gray-500 flex-shrink-0"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-4 h-4 mr-2 mt-0.5 text-gray-500 flex-shrink-0"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                                            </svg>
                                                        @endif
                                                        <div class="min-w-0 flex-1">
                                                            <p
                                                                class="text-sm {{ $currentLessonIndex === $index ? 'font-medium text-purple-700' : 'text-gray-700' }} leading-tight">
                                                                {{ $lesson->title }}
                                                            </p>
                                                            <div class="flex items-center mt-1">
                                                                <span class="text-xs text-gray-500">3min</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Desktop message -->
                            <div class="hidden lg:block text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <p>Course curriculum is available in the sidebar.</p>
                            </div>
                        </div>

                        <!-- Overview Tab Content -->
                        <div class="tab-content hidden" id="overview-content">
                            @if ($currentLesson)
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">
                                    {{ $course->title }}
                                </h1>
                                <div class="prose prose-sm sm:prose-lg max-w-none">
                                    <p class="text-gray-600 text-base sm:text-lg leading-relaxed">
                                        {{ $course->description }}
                                    </p>

                                    @if ($currentLesson->description && ($currentLesson->material_type !== null || empty($currentLesson->material_path)))
                                        <div class="mt-6 sm:mt-8">
                                            <h3 class="text-base sm:text-lg font-semibold mb-4">Lesson Content</h3>
                                            <div class="text-gray-700 text-sm sm:text-base">
                                                {!! nl2br(e($currentLesson->description)) !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-6 sm:mt-8 pt-6 border-t">
                                    <div
                                        class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <span class="font-medium text-orange-500">4.7</span>
                                            <div class="flex ml-1">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-orange-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="hidden sm:inline">495,056 ratings</span>
                                        <span class="hidden sm:inline">1,497,247 students</span>
                                        <span class="sm:hidden">495K ratings</span>
                                        <span class="sm:hidden">1.5M students</span>
                                        <span>61.5 hours total</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">Congratulations!</h2>
                                    <p class="text-gray-600 mb-6 sm:mb-8">You've completed the course.</p>
                                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                                        <a href="{{ route('courses.preview', ['course' => $course, 'lesson' => 0]) }}"
                                            class="px-4 sm:px-6 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50 text-sm sm:text-base">
                                            Restart Course
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Other Tab Contents -->
                        <div class="tab-content hidden" id="qa-content">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Questions & Answers</h2>
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <p>No questions have been asked yet.</p>
                            </div>
                        </div>

                        <div class="tab-content hidden" id="notes-content">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Notes</h2>
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                <p>You haven't taken any notes yet.</p>
                            </div>
                        </div>

                        <div class="tab-content hidden" id="announcements-content">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Announcements</h2>
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                                    </path>
                                </svg>
                                <p>No announcements yet.</p>
                            </div>
                        </div>

                        <div class="tab-content hidden" id="reviews-content">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Reviews</h2>
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                    </path>
                                </svg>
                                <p>No reviews yet.</p>
                            </div>
                        </div>

                        <div class="tab-content hidden" id="tools-content">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Learning Tools</h2>
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p>No learning tools available.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Sidebar - Always Visible on Desktop (Like Udemy) -->
            <div class="hidden lg:block w-80 bg-white border-l shadow-lg order-2"
                style="height: calc(100vh - 120px); overflow-y: auto;">
                <div class="p-4 border-b bg-gray-50">
                    <h3 class="font-semibold text-gray-900 mb-1">Course content</h3>
                    <div class="text-sm text-gray-600">
                        {{ $lessons->count() }} lectures
                    </div>
                </div>

                <div class="divide-y">
                    <!-- Course Section -->
                    <div class="border-b">
                        <button class="w-full px-4 py-3 text-left hover:bg-gray-50 flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-sm">Section 1: Course Content</h4>
                                <p class="text-xs text-gray-600 mt-1">{{ $lessons->count() }} lectures</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transform rotate-180" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <!-- Lessons List -->
                        <div class="bg-gray-50">
                            @foreach ($lessons as $index => $lesson)
                                <a href="{{ route('courses.preview', ['course' => $course, 'lesson' => $index]) }}"
                                    class="block px-6 py-3 hover:bg-gray-100 border-b border-gray-200 {{ $currentLessonIndex === $index ? 'bg-purple-50 border-l-4 border-l-purple-600' : '' }}">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-3">
                                            @if ($currentLessonIndex === $index)
                                                <div
                                                    class="w-5 h-5 bg-purple-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @elseif($currentLessonIndex > $index)
                                                <div
                                                    class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div
                                                    class="w-5 h-5 bg-gray-300 rounded-full flex items-center justify-center">
                                                    <span class="text-xs text-gray-600">{{ $index + 1 }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center">
                                                @if ($lesson->material_type === 'url')
                                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                @elseif($lesson->material_type === 'file')
                                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                                    </svg>
                                                @endif
                                                <p
                                                    class="text-sm {{ $currentLessonIndex === $index ? 'font-medium text-purple-700' : 'text-gray-700' }} truncate">
                                                    {{ $lesson->title }}
                                                </p>
                                            </div>
                                            <div class="flex items-center mt-1">
                                                <span class="text-xs text-gray-500">3min</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            function showTab(targetTab) {
                // Hide all content
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Reset all button styles
                tabButtons.forEach(button => {
                    button.classList.remove('border-purple-600', 'text-purple-600');
                    button.classList.add('border-transparent', 'text-gray-500');
                });

                // Show target content
                const targetContent = document.getElementById(targetTab + '-content');
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                }

                // Activate target button
                const targetButton = document.querySelector(`[data-tab="${targetTab}"]`);
                if (targetButton) {
                    targetButton.classList.remove('border-transparent', 'text-gray-500');
                    targetButton.classList.add('border-purple-600', 'text-purple-600');
                }
            }

            // Add click listeners to tab buttons
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    showTab(targetTab);
                });
            });

            // Hide scroll bar for content tabs on mobile
            const tabsNav = document.querySelector('nav.flex.overflow-x-auto');
            if (tabsNav) {
                tabsNav.style.scrollbarWidth = 'none';
                tabsNav.style.msOverflowStyle = 'none';
                tabsNav.style.webkitScrollbar = 'display: none';
            }
        });
    </script>

@endsection
