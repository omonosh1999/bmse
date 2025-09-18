<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Quiz - ') . $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Quiz Information Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Quiz Information</h3>

                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('quizzes.update', $quiz) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Quiz Title -->
                        <div>
                            <x-input-label for="title" :value="__('Quiz Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title', $quiz->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Quiz Description -->
                        <div>
                            <x-input-label for="description" :value="__('Quiz Description')" />
                            <textarea id="description" name="description" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('description', $quiz->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Course and Lesson Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Course Selection -->
                            <div>
                                <x-input-label for="course_id" :value="__('Select Course')" />
                                <select id="course_id" name="course_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="">Select Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id', $quiz->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }} ({{ ucfirst($course->category) }} -
                                            {{ $course->class_level }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                            </div>

                            <!-- Lesson Selection -->
                            <div>
                                <x-input-label for="lesson_id" :value="__('Select Lesson')" />
                                <select id="lesson_id" name="lesson_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="">Select Lesson</option>
                                    <!-- Options populated by JavaScript -->
                                </select>
                                <x-input-error :messages="$errors->get('lesson_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Quiz Settings Row -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Max Attempts -->
                            <div>
                                <x-input-label for="max_attempts" :value="__('Max Attempts')" />
                                <select id="max_attempts" name="max_attempts"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="1"
                                        {{ old('max_attempts', $quiz->max_attempts) == '1' ? 'selected' : '' }}>1
                                        Attempt</option>
                                    <option value="2"
                                        {{ old('max_attempts', $quiz->max_attempts) == '2' ? 'selected' : '' }}>2
                                        Attempts</option>
                                    <option value="3"
                                        {{ old('max_attempts', $quiz->max_attempts) == '3' ? 'selected' : '' }}>3
                                        Attempts</option>
                                    <option value="5"
                                        {{ old('max_attempts', $quiz->max_attempts) == '5' ? 'selected' : '' }}>5
                                        Attempts</option>
                                    <option value="-1"
                                        {{ old('max_attempts', $quiz->max_attempts) == '-1' ? 'selected' : '' }}>
                                        Unlimited</option>
                                </select>
                                <x-input-error :messages="$errors->get('max_attempts')" class="mt-2" />
                            </div>

                            <!-- Time Limit -->
                            <div>
                                <x-input-label for="time_limit" :value="__('Time Limit (minutes)')" />
                                <select id="time_limit" name="time_limit"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">No Time Limit</option>
                                    <option value="5"
                                        {{ old('time_limit', $quiz->time_limit) == '5' ? 'selected' : '' }}>5 Minutes
                                    </option>
                                    <option value="10"
                                        {{ old('time_limit', $quiz->time_limit) == '10' ? 'selected' : '' }}>10 Minutes
                                    </option>
                                    <option value="15"
                                        {{ old('time_limit', $quiz->time_limit) == '15' ? 'selected' : '' }}>15 Minutes
                                    </option>
                                    <option value="30"
                                        {{ old('time_limit', $quiz->time_limit) == '30' ? 'selected' : '' }}>30 Minutes
                                    </option>
                                    <option value="45"
                                        {{ old('time_limit', $quiz->time_limit) == '45' ? 'selected' : '' }}>45 Minutes
                                    </option>
                                    <option value="60"
                                        {{ old('time_limit', $quiz->time_limit) == '60' ? 'selected' : '' }}>60 Minutes
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('time_limit')" class="mt-2" />
                            </div>

                            <!-- Passing Score -->
                            <div>
                                <x-input-label for="passing_score" :value="__('Passing Score (%)')" />
                                <select id="passing_score" name="passing_score"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="50"
                                        {{ old('passing_score', $quiz->passing_score) == '50' ? 'selected' : '' }}>50%
                                    </option>
                                    <option value="60"
                                        {{ old('passing_score', $quiz->passing_score) == '60' ? 'selected' : '' }}>60%
                                    </option>
                                    <option value="70"
                                        {{ old('passing_score', $quiz->passing_score) == '70' ? 'selected' : '' }}>70%
                                    </option>
                                    <option value="80"
                                        {{ old('passing_score', $quiz->passing_score) == '80' ? 'selected' : '' }}>80%
                                    </option>
                                    <option value="90"
                                        {{ old('passing_score', $quiz->passing_score) == '90' ? 'selected' : '' }}>90%
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('passing_score')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-4">
                            <a href="{{ route('quizzes.show', $quiz) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>
                                Update Quiz Info
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Questions Management Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Quiz Questions ({{ $quiz->questions->count() }})</h3>
                        <button type="button" id="add-question-btn"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Question
                        </button>
                    </div>

                    <!-- Existing Questions List -->
                    <div id="questions-container" class="space-y-4">
                        @forelse($quiz->questions->sortBy('sort_order') as $index => $question)
                            <div class="question-item border rounded-lg p-4 bg-gray-50"
                                data-question-id="{{ $question->id }}">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="font-semibold text-gray-800">Question {{ $index + 1 }}</h4>
                                    <div class="flex space-x-2">
                                        <button type="button"
                                            class="edit-question-btn text-indigo-600 hover:text-indigo-800"
                                            data-question-id="{{ $question->id }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button type="button"
                                            class="delete-question-btn text-red-600 hover:text-red-800"
                                            data-question-id="{{ $question->id }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <p class="text-gray-800 font-medium">{{ $question->question }}</p>
                                </div>

                                <div class="text-sm text-gray-600 mb-2">
                                    <span
                                        class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mr-2">
                                        {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                    </span>
                                    <span
                                        class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                        {{ $question->points }} {{ $question->points == 1 ? 'point' : 'points' }}
                                    </span>
                                </div>

                                @if ($question->type === 'multiple_choice' && $question->options)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600 mb-1">Options:</p>
                                        <ul class="text-sm text-gray-700 ml-4">
                                            @foreach ($question->formatted_options as $key => $option)
                                                <li class="mb-1">
                                                    <span
                                                        class="font-medium {{ $key === $question->correct_answer ? 'text-green-600' : '' }}">
                                                        {{ $key }}. {{ $option }}
                                                        @if ($key === $question->correct_answer)
                                                            <span class="text-green-600">(Correct)</span>
                                                        @endif
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @elseif($question->type === 'true_false')
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">
                                            Correct Answer:
                                            <span
                                                class="font-medium text-green-600">{{ ucfirst($question->correct_answer) }}</span>
                                        </p>
                                    </div>
                                @elseif($question->type === 'fill_blank')
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">
                                            Correct Answer:
                                            <span
                                                class="font-medium text-green-600">{{ $question->correct_answer }}</span>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <p class="text-lg font-medium mb-2">No questions added yet</p>
                                <p class="text-sm">Click "Add Question" to create your first quiz question.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Question Modal -->
    <div id="question-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-screen overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-lg font-semibold">Add Question</h3>
                        <button type="button" id="close-modal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form id="question-form" class="space-y-4">
                        <input type="hidden" id="question-id" name="question_id">

                        <!-- Question Text -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                            <textarea id="question-text" name="question" rows="3"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                        </div>

                        <!-- Question Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Question Type</label>
                            <select id="question-type" name="type"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="true_false">True/False</option>
                                <option value="fill_blank">Fill in the Blank</option>
                            </select>
                        </div>

                        <!-- Points -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                            <input type="number" id="question-points" name="points" min="1" value="10"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <!-- Multiple Choice Options -->
                        <div id="multiple-choice-options" class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Answer Options</label>
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="correct_option" value="A" id="option-a-radio">
                                    <label for="option-a-radio" class="text-sm font-medium">A.</label>
                                    <input type="text" id="option-a" placeholder="Option A"
                                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="correct_option" value="B" id="option-b-radio">
                                    <label for="option-b-radio" class="text-sm font-medium">B.</label>
                                    <input type="text" id="option-b" placeholder="Option B"
                                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="correct_option" value="C" id="option-c-radio">
                                    <label for="option-c-radio" class="text-sm font-medium">C.</label>
                                    <input type="text" id="option-c" placeholder="Option C"
                                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="radio" name="correct_option" value="D" id="option-d-radio">
                                    <label for="option-d-radio" class="text-sm font-medium">D.</label>
                                    <input type="text" id="option-d" placeholder="Option D"
                                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Select the radio button next to the correct answer.</p>
                        </div>

                        <!-- True/False Options -->
                        <div id="true-false-options" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correct Answer</label>
                            <div class="space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="tf_correct" value="true"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2">True</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="tf_correct" value="false"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <span class="ml-2">False</span>
                                </label>
                            </div>
                        </div>

                        <!-- Fill in the Blank Options -->
                        <div id="fill-blank-options" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correct Answer</label>
                            <input type="text" id="fill-blank-answer" name="fill_blank_answer"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-sm text-gray-500 mt-1">You can provide multiple correct answers separated by
                                | (e.g., "answer1|answer2")</p>
                        </div>

                        <!-- Explanation -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Explanation (Optional)</label>
                            <textarea id="question-explanation" name="explanation" rows="2"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="flex justify-end space-x-4 pt-4">
                            <button type="button" id="cancel-question"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                                Save Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Store current quiz and lesson data
        const currentCourseId = '{{ old('course_id', $quiz->course_id) }}';
        const currentLessonId = '{{ old('lesson_id', $quiz->lesson_id) }}';
        const quizId = '{{ $quiz->id }}';

        // Course/Lesson selection logic
        document.getElementById('course_id').addEventListener('change', function() {
            const courseId = this.value;
            const lessonSelect = document.getElementById('lesson_id');

            lessonSelect.innerHTML = '<option value="">Select Lesson</option>';

            if (courseId) {
                lessonSelect.disabled = false;
                fetch(`{{ route('api.lessons') }}?course_id=${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(lesson => {
                            const option = document.createElement('option');
                            option.value = lesson.id;
                            option.textContent = lesson.title;
                            if (lesson.id == currentLessonId) {
                                option.selected = true;
                            }
                            lessonSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                lessonSelect.disabled = true;
            }
        });

        // Initialize lesson options
        window.addEventListener('load', function() {
            if (currentCourseId) {
                document.getElementById('course_id').dispatchEvent(new Event('change'));
            }
        });

        // Question management
        const modal = document.getElementById('question-modal');
        const form = document.getElementById('question-form');
        let currentQuestionId = null;

        // Show/hide option fields based on question type
        document.getElementById('question-type').addEventListener('change', function() {
            const type = this.value;
            document.getElementById('multiple-choice-options').classList.toggle('hidden', type !==
                'multiple_choice');
            document.getElementById('true-false-options').classList.toggle('hidden', type !== 'true_false');
            document.getElementById('fill-blank-options').classList.toggle('hidden', type !== 'fill_blank');
        });

        // Add question button
        document.getElementById('add-question-btn').addEventListener('click', function() {
            currentQuestionId = null;
            document.getElementById('modal-title').textContent = 'Add Question';
            form.reset();
            document.getElementById('question-type').dispatchEvent(new Event('change'));
            modal.classList.remove('hidden');
        });

        // Edit question buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-question-btn')) {
                const questionId = e.target.closest('.edit-question-btn').dataset.questionId;
                editQuestion(questionId);
            }

            if (e.target.closest('.delete-question-btn')) {
                const questionId = e.target.closest('.delete-question-btn').dataset.questionId;
                if (confirm('Are you sure you want to delete this question?')) {
                    deleteQuestion(questionId);
                }
            }
        });

        // Close modal
        document.getElementById('close-modal').addEventListener('click', closeModal);
        document.getElementById('cancel-question').addEventListener('click', closeModal);

        function closeModal() {
            modal.classList.add('hidden');
            currentQuestionId = null;
            form.reset();
        }

        // Save question
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            saveQuestion();
        });

        function saveQuestion() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('quiz_id', quizId);
            formData.append('question', document.getElementById('question-text').value);
            formData.append('type', document.getElementById('question-type').value);
            formData.append('points', document.getElementById('question-points').value);
            formData.append('explanation', document.getElementById('question-explanation').value);

            const questionType = document.getElementById('question-type').value;

            if (questionType === 'multiple_choice') {
                const options = {
                    'A': document.getElementById('option-a').value,
                    'B': document.getElementById('option-b').value,
                    'C': document.getElementById('option-c').value,
                    'D': document.getElementById('option-d').value
                };
                formData.append('options', JSON.stringify(options));
                formData.append('correct_answer', document.querySelector('input[name="correct_option"]:checked').value);
            } else if (questionType === 'true_false') {
                formData.append('correct_answer', document.querySelector('input[name="tf_correct"]:checked').value);
            } else if (questionType === 'fill_blank') {
                formData.append('correct_answer', document.getElementById('fill-blank-answer').value);
            }

            // CORRECTED: Use proper URL structure with quiz ID
            const url = currentQuestionId ?
                `/quizzes/${quizId}/questions/${currentQuestionId}` :
                `/quizzes/${quizId}/questions`;

            if (currentQuestionId) {
                formData.append('_method', 'PUT');
            }

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeModal();
                        location.reload(); // Reload to show updated questions
                    } else {
                        alert('Error saving question. Please try again.');
                        console.log('Server response:', data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error saving question. Please try again.');
                });
        }

        function editQuestion(questionId) {
            // CORRECTED: Use proper URL structure with quiz ID
            fetch(`/quizzes/${quizId}/questions/${questionId}`)
                .then(response => response.json())
                .then(data => {
                    currentQuestionId = questionId;
                    document.getElementById('modal-title').textContent = 'Edit Question';

                    document.getElementById('question-text').value = data.question;
                    document.getElementById('question-type').value = data.type;
                    document.getElementById('question-points').value = data.points;
                    document.getElementById('question-explanation').value = data.explanation || '';

                    document.getElementById('question-type').dispatchEvent(new Event('change'));

                    if (data.type === 'multiple_choice' && data.options) {
                        document.getElementById('option-a').value = data.options.A || '';
                        document.getElementById('option-b').value = data.options.B || '';
                        document.getElementById('option-c').value = data.options.C || '';
                        document.getElementById('option-d').value = data.options.D || '';
                        document.querySelector(`input[name="correct_option"][value="${data.correct_answer}"]`).checked =
                            true;
                    } else if (data.type === 'true_false') {
                        document.querySelector(`input[name="tf_correct"][value="${data.correct_answer}"]`).checked =
                            true;
                    } else if (data.type === 'fill_blank') {
                        document.getElementById('fill-blank-answer').value = data.correct_answer;
                    }

                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading question. Please try again.');
                });
        }

        function deleteQuestion(questionId) {
            // CORRECTED: Use proper URL structure with quiz ID
            fetch(`/quizzes/${quizId}/questions/${questionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting question. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting question. Please try again.');
                });
        }
    </script>
</x-app-layout>
