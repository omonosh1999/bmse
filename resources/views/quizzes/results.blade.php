@extends('layouts.main')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Results Header -->
        <section class="{{ $attempt->passed ? 'bg-green-500' : 'bg-red-500' }} text-white py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <!-- Result Icon -->
                    <div class="w-20 h-20 mx-auto mb-6 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        @if ($attempt->passed)
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        @endif
                    </div>

                    <h1 class="text-3xl md:text-4xl font-bold mb-4">
                        {{ $attempt->passed ? 'Congratulations!' : 'Quiz Complete' }}
                    </h1>
                    <h2 class="text-xl md:text-2xl mb-4">{{ $attempt->quiz->title }}</h2>

                    <!-- Score Display -->
                    <div class="bg-white bg-opacity-20 rounded-lg p-6 inline-block">
                        <div class="text-4xl font-bold mb-2">{{ $attempt->percentage }}%</div>
                        <div class="text-sm opacity-90">
                            {{ $attempt->score }} out of {{ $attempt->total_points }} points
                        </div>
                        <div class="text-sm opacity-75 mt-1">
                            @if ($attempt->passed)
                                ✓ Passed ({{ $attempt->quiz->passing_score }}% required)
                            @else
                                {{ $attempt->quiz->passing_score }}% required to pass
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Stats -->
        <section class="py-6 bg-white border-b">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ count($detailedResults) }}</div>
                        <div class="text-sm text-gray-600">Total Questions</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-600">
                            {{ collect($detailedResults)->where('is_correct', true)->count() }}</div>
                        <div class="text-sm text-gray-600">Correct</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-red-600">
                            {{ collect($detailedResults)->where('is_correct', false)->count() }}</div>
                        <div class="text-sm text-gray-600">Incorrect</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">
                            @if ($attempt->time_taken)
                                {{ floor($attempt->time_taken / 60) }}:{{ str_pad($attempt->time_taken % 60, 2, '0', STR_PAD_LEFT) }}
                            @else
                                N/A
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">Time Taken</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Detailed Results -->
        <section class="py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Review Your Answers</h3>

                <div class="space-y-6">
                    @foreach ($detailedResults as $index => $result)
                        <div
                            class="bg-white rounded-lg shadow-sm p-6 border-l-4 {{ $result['is_correct'] ? 'border-green-500' : 'border-red-500' }}">
                            <!-- Question Header -->
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="text-lg font-semibold text-gray-900">
                                    Question {{ $index + 1 }}
                                </h4>
                                <div class="flex items-center">
                                    @if ($result['is_correct'])
                                        <span
                                            class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Correct (+{{ $result['points'] }} pts)
                                        </span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Incorrect (0 pts)
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Question Text -->
                            <div class="mb-4">
                                <p class="text-gray-900 font-medium">{{ $result['question'] }}</p>
                            </div>

                            <!-- Answers Section -->
                            <div class="grid md:grid-cols-2 gap-4 mb-4">
                                <!-- Your Answer -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Answer:</label>
                                    <div
                                        class="p-3 rounded-lg {{ $result['is_correct'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                        @if ($result['type'] === 'multiple_choice')
                                            @php
                                                $formattedOptions = is_array($result['options'])
                                                    ? $result['options']
                                                    : [];
                                                // If options is indexed array, convert to letter keys
                                                if (
                                                    !empty($formattedOptions) &&
                                                    array_keys($formattedOptions) ===
                                                        range(0, count($formattedOptions) - 1)
                                                ) {
                                                    $converted = [];
                                                    foreach ($formattedOptions as $index => $option) {
                                                        $key = chr(65 + $index); // A, B, C, D...
                                                        $converted[$key] = $option;
                                                    }
                                                    $formattedOptions = $converted;
                                                }
                                            @endphp
                                            @if ($result['user_answer'] && isset($formattedOptions[$result['user_answer']]))
                                                {{ $result['user_answer'] }}.
                                                {{ $formattedOptions[$result['user_answer']] }}
                                            @else
                                                <span class="text-gray-500 italic">No answer selected</span>
                                            @endif
                                        @elseif($result['type'] === 'true_false')
                                            {{ ucfirst($result['user_answer'] ?? 'No answer') }}
                                        @elseif($result['type'] === 'fill_blank')
                                            {{ $result['user_answer'] ?: 'No answer provided' }}
                                        @endif
                                    </div>
                                </div>

                                <!-- Correct Answer -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Correct Answer:</label>
                                    <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                                        @if ($result['type'] === 'multiple_choice')
                                            @php
                                                $formattedOptions = is_array($result['options'])
                                                    ? $result['options']
                                                    : [];
                                                // If options is indexed array, convert to letter keys
                                                if (
                                                    !empty($formattedOptions) &&
                                                    array_keys($formattedOptions) ===
                                                        range(0, count($formattedOptions) - 1)
                                                ) {
                                                    $converted = [];
                                                    foreach ($formattedOptions as $index => $option) {
                                                        $key = chr(65 + $index); // A, B, C, D...
                                                        $converted[$key] = $option;
                                                    }
                                                    $formattedOptions = $converted;
                                                }
                                            @endphp
                                            @if (isset($formattedOptions[$result['correct_answer']]))
                                                {{ $result['correct_answer'] }}.
                                                {{ $formattedOptions[$result['correct_answer']] }}
                                            @else
                                                {{ $result['correct_answer'] }}
                                            @endif
                                        @elseif($result['type'] === 'true_false')
                                            {{ ucfirst($result['correct_answer']) }}
                                        @elseif($result['type'] === 'fill_blank')
                                            {{ $result['correct_answer'] }}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Explanation -->
                            @if ($result['explanation'])
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <h5 class="font-medium text-blue-900 mb-2">Explanation:</h5>
                                    <p class="text-blue-800 text-sm">{{ $result['explanation'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Action Buttons -->
        <section class="py-8 bg-white border-t">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <!-- Retake Quiz (if allowed) -->
                    @auth
                        @if (
                            $attempt->quiz->max_attempts == 0 ||
                                auth()->user()->quizAttempts()->where('quiz_id', $attempt->quiz->id)->count() < $attempt->quiz->max_attempts)
                            <a href="{{ route('quiz.take', $attempt->quiz) }}"
                                class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                Take Quiz Again
                            </a>
                        @else
                            <span class="px-6 py-3 bg-gray-300 text-gray-600 font-semibold rounded-lg cursor-not-allowed">
                                Maximum Attempts Reached
                            </span>
                        @endif
                    @else
                        <a href="{{ route('quiz.take', $attempt->quiz) }}"
                            class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors duration-200">
                            Take Quiz Again
                        </a>
                    @endauth

                    <!-- Back to Quizzes -->
                    <a href="{{ route('mental') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Browse More Quizzes
                    </a>

                    <!-- Back to Course (if applicable) -->
                    @if ($attempt->quiz->course)
                        <a href="{{ route('courses.preview', $attempt->quiz->course) }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Back to Lesson
                            {{-- {{ $attempt->quiz->course->title }} --}}
                        </a>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
