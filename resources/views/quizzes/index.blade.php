<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Quizzes') }}
            </h2>
            <a href="{{ route('quizzes.create') }}"
                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Create New Quiz
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($quizzes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($quizzes as $quiz)
                                <div
                                    class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <!-- Quiz Header -->
                                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-4 py-3 rounded-t-lg">
                                        <div class="flex items-center justify-between">
                                            <span class="text-white text-sm font-medium">
                                                {{ ucfirst($quiz->category) }} - {{ $quiz->class_level }}
                                            </span>
                                            <div class="flex space-x-2">
                                                @if ($quiz->status === 'draft')
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Draft</span>
                                                @elseif($quiz->status === 'published')
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Published</span>
                                                @endif

                                                @if (!$quiz->is_active)
                                                    <span
                                                        class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Inactive</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quiz Content -->
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 truncate mb-2">
                                            {{ $quiz->title }}
                                        </h3>

                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                            {{ Str::limit($quiz->description, 100) }}
                                        </p>

                                        <!-- Course and Lesson Info -->
                                        <div class="mb-3 space-y-1">
                                            <p class="text-xs text-gray-500">
                                                <span class="font-medium">Course:</span>
                                                {{ Str::limit($quiz->course->title, 20) }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                <span class="font-medium">Lesson:</span>
                                                {{ Str::limit($quiz->lesson->title, 20) }}
                                            </p>
                                        </div>

                                        <!-- Quiz Stats -->
                                        <div class="flex justify-between items-center text-xs text-gray-500 mb-3">
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                {{ $quiz->questions->count() }} Questions
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $quiz->time_limit ? $quiz->time_limit . 'm' : 'No limit' }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                    </path>
                                                </svg>
                                                {{ $quiz->hasUnlimitedAttempts() ? '∞' : $quiz->max_attempts }}
                                                attempts
                                            </span>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('quizzes.show', $quiz) }}"
                                                class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                                                View Details →
                                            </a>

                                            <div class="flex space-x-2">
                                                <a href="{{ route('quizzes.edit', $quiz) }}"
                                                    class="text-gray-600 hover:text-gray-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </a>

                                                <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $quizzes->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No quizzes created yet</h3>
                            <p class="mt-2 text-sm text-gray-500">Get started by creating your first quiz for your
                                students.</p>
                            <div class="mt-6">
                                <a href="{{ route('quizzes.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Your First Quiz
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
