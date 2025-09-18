<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz: {{ $quiz->title }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('quizzes.edit', $quiz) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Quiz
                </a>
                @if ($quiz->canBePublished() && $quiz->status === 'draft')
                    <form method="POST" action="{{ route('quizzes.publish', $quiz) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Publish Quiz
                        </button>
                    </form>
                @endif
                @if ($quiz->status === 'published')
                    <form method="POST" action="{{ route('quizzes.unpublish', $quiz) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Unpublish
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Quiz Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Quiz Overview -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Quiz Overview</h3>
                                <div class="flex space-x-2">
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
                                    @else
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <p class="text-gray-600 mb-4">{{ $quiz->description }}</p>

                            <!-- Quiz Details Grid -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Category</label>
                                    <p class="text-lg font-medium">{{ ucfirst($quiz->category) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Class Level</label>
                                    <p class="text-lg font-medium">{{ $quiz->class_level }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Max Attempts</label>
                                    <p class="text-lg font-medium">{{ $quiz->formatted_max_attempts }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Time Limit</label>
                                    <p class="text-lg font-medium">{{ $quiz->formatted_time_limit }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Passing Score</label>
                                    <p class="text-lg font-medium">{{ $quiz->formatted_passing_score }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Difficulty</label>
                                    <p class="text-lg font-medium">{{ $quiz->difficulty }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Questions</label>
                                    <p class="text-lg font-medium">{{ $quiz->questions->count() }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Est. Time</label>
                                    <p class="text-lg font-medium">{{ $quiz->estimated_time }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Questions List -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Questions
                                    ({{ $quiz->questions->count() }})</h3>
                                <a href="{{ route('quizzes.edit', $quiz) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Edit Questions
                                </a>
                            </div>

                            @if ($quiz->questions->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($quiz->questions as $question)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h4 class="font-medium text-gray-900">
                                                    Question {{ $question->sort_order }}
                                                </h4>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs text-gray-500">{{ $question->points }}
                                                        pts</span>
                                                    <span
                                                        class="inline-flex px-2 py-1 text-xs font-medium rounded-full 
                                                        @if ($question->type === 'multiple_choice') bg-blue-100 text-blue-800
                                                        @elseif($question->type === 'true_false') bg-green-100 text-green-800
                                                        @else bg-purple-100 text-purple-800 @endif">
                                                        {{ str_replace('_', ' ', ucfirst($question->type)) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <p class="text-gray-700 mb-2">{{ $question->question }}</p>

                                            @if ($question->type === 'multiple_choice' && $question->options)
                                                <div class="ml-4 space-y-1">
                                                    @foreach ($question->formatted_options as $key => $option)
                                                        <div class="flex items-center">
                                                            <span
                                                                class="text-sm text-gray-600 w-6">{{ $key }}.</span>
                                                            <span
                                                                class="text-sm {{ $option === $question->correct_answer ? 'text-green-600 font-medium' : 'text-gray-600' }}">
                                                                {{ $option }}
                                                                @if ($option === $question->correct_answer)
                                                                    <span class="text-green-600">✓</span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @elseif($question->type === 'true_false')
                                                <div class="ml-4 space-y-1">
                                                    <div class="flex items-center">
                                                        <span class="text-sm text-gray-600 w-6">A.</span>
                                                        <span
                                                            class="text-sm {{ $question->correct_answer === 'true' ? 'text-green-600 font-medium' : 'text-gray-600' }}">
                                                            True
                                                            @if ($question->correct_answer === 'true')
                                                                <span class="text-green-600">✓</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="text-sm text-gray-600 w-6">B.</span>
                                                        <span
                                                            class="text-sm {{ $question->correct_answer === 'false' ? 'text-green-600 font-medium' : 'text-gray-600' }}">
                                                            False
                                                            @if ($question->correct_answer === 'false')
                                                                <span class="text-green-600">✓</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="ml-4">
                                                    <span class="text-sm text-gray-600">Correct Answer: </span>
                                                    <span
                                                        class="text-sm text-green-600 font-medium">{{ $question->correct_answer }}</span>
                                                </div>
                                            @endif

                                            @if ($question->explanation)
                                                <div class="mt-2 p-2 bg-gray-50 rounded text-sm text-gray-600">
                                                    <strong>Explanation:</strong> {{ $question->explanation }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <p class="text-gray-500 mb-4">No questions added yet</p>
                                    <a href="{{ route('quizzes.questions.create', $quiz) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Add Questions
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Total Attempts</span>
                                    <span class="text-sm font-medium">{{ $quiz->stats['total_attempts'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Passed</span>
                                    <span class="text-sm font-medium">{{ $quiz->stats['passed_attempts'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Pass Rate</span>
                                    <span class="text-sm font-medium">{{ $quiz->stats['pass_rate'] }}%</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Avg Score</span>
                                    <span class="text-sm font-medium">{{ $quiz->stats['average_score'] }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course & Lesson Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Course</label>
                                    <a href="{{ route('courses.show', $quiz->course) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                        {{ $quiz->course->title }}
                                    </a>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Lesson</label>
                                    <p class="font-medium">{{ $quiz->lesson->title }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                            <div class="space-y-3">
                                @if ($quiz->status === 'published')
                                    <a href="{{ route('quiz.take', $quiz) }}" target="_blank"
                                        class="block w-full text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Preview Quiz
                                    </a>
                                @endif

                                <a href="{{ route('quizzes.attempts', $quiz) }}"
                                    class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    View Attempts
                                </a>

                                @if ($quiz->is_active)
                                    <form method="POST" action="{{ route('quizzes.deactivate', $quiz) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                            Deactivate Quiz
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('quizzes.activate', $quiz) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                            Activate Quiz
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this quiz? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Delete Quiz
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
