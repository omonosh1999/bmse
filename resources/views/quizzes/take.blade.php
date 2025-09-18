@extends('layouts.main')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Quiz Header -->
        <section class="bg-gradient-to-br from-purple-600 to-pink-600 text-white py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $quiz->title }}</h1>
                    <p class="text-lg text-purple-100 mb-6">{{ $quiz->description }}</p>

                    <!-- Quiz Info -->
                    <div class="flex flex-wrap justify-center gap-6 text-sm">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            {{ $quiz->questions->count() }} Questions
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $quiz->time_limit ? $quiz->time_limit . ' minutes' : 'No time limit' }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $quiz->passing_score }}% to pass
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quiz Content -->
        <section class="py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Timer Display -->
                @if ($quiz->time_limit)
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Time Remaining:</span>
                            <div id="timer" class="text-xl font-bold text-purple-600">
                                {{ $quiz->time_limit }}:00
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div id="timer-progress" class="bg-purple-600 h-2 rounded-full transition-all duration-1000"
                                style="width: 100%"></div>
                        </div>
                    </div>
                @endif

                <!-- Quiz Form -->
                <form id="quiz-form" method="POST" action="{{ route('quiz.submit', $quiz) }}">
                    @csrf
                    <input type="hidden" id="time_taken" name="time_taken" value="">

                    <div class="space-y-6">
                        @foreach ($quiz->questions as $index => $question)
                            <div class="bg-white rounded-lg shadow-sm p-6">
                                <!-- Question Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        Question {{ $index + 1 }} of {{ $quiz->questions->count() }}
                                    </h3>
                                    <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                                        {{ $question->points }} {{ $question->points == 1 ? 'point' : 'points' }}
                                    </span>
                                </div>

                                <!-- Question Text -->
                                <div class="mb-6">
                                    <p class="text-gray-900 text-base leading-relaxed">{{ $question->question }}</p>
                                </div>

                                <!-- Answer Options -->
                                <div class="space-y-3">
                                    @if ($question->type === 'multiple_choice')
                                        @foreach ($question->formatted_options as $optionKey => $option)
                                            <label
                                                class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="{{ $optionKey }}"
                                                    class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300"
                                                    required>
                                                <span class="ml-3 text-gray-900">{{ $optionKey }}.
                                                    {{ $option }}</span>
                                            </label>
                                        @endforeach
                                    @elseif($question->type === 'true_false')
                                        <label
                                            class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="true"
                                                class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300"
                                                required>
                                            <span class="ml-3 text-gray-900">True</span>
                                        </label>
                                        <label
                                            class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="false"
                                                class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300"
                                                required>
                                            <span class="ml-3 text-gray-900">False</span>
                                        </label>
                                    @elseif($question->type === 'fill_blank')
                                        <input type="text" name="answers[{{ $question->id }}]"
                                            placeholder="Enter your answer here..."
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"
                                            required>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 text-center">
                        <button type="submit" id="submit-btn"
                            class="px-8 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors duration-200">
                            Submit Quiz
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    @if ($quiz->time_limit)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const timeLimit = {{ $quiz->time_limit * 60 }}; // Convert to seconds
                let timeRemaining = timeLimit;
                const timerElement = document.getElementById('timer');
                const progressElement = document.getElementById('timer-progress');
                const form = document.getElementById('quiz-form');
                const startTime = Date.now();

                function formatTime(seconds) {
                    const minutes = Math.floor(seconds / 60);
                    const remainingSeconds = seconds % 60;
                    return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
                }

                function updateTimer() {
                    const minutes = Math.floor(timeRemaining / 60);
                    const seconds = timeRemaining % 60;

                    timerElement.textContent = formatTime(timeRemaining);

                    // Update progress bar
                    const progressPercent = (timeRemaining / timeLimit) * 100;
                    progressElement.style.width = progressPercent + '%';

                    // Change color when time is running low
                    if (timeRemaining <= 300) { // 5 minutes
                        timerElement.classList.add('text-red-600');
                        progressElement.classList.remove('bg-purple-600');
                        progressElement.classList.add('bg-red-600');
                    }

                    if (timeRemaining <= 0) {
                        // Time's up - auto submit
                        alert('Time is up! The quiz will be submitted automatically.');
                        document.getElementById('time_taken').value = Math.floor((Date.now() - startTime) / 1000);
                        form.submit();
                        return;
                    }

                    timeRemaining--;
                    setTimeout(updateTimer, 1000);
                }

                // Start the timer
                updateTimer();

                // Track time when form is submitted
                form.addEventListener('submit', function() {
                    document.getElementById('time_taken').value = Math.floor((Date.now() - startTime) / 1000);
                });
            });
        </script>
    @else
        <script>
            // Track time even without timer
            document.addEventListener('DOMContentLoaded', function() {
                const startTime = Date.now();
                const form = document.getElementById('quiz-form');

                form.addEventListener('submit', function() {
                    document.getElementById('time_taken').value = Math.floor((Date.now() - startTime) / 1000);
                });
            });
        </script>
    @endif
@endsection
