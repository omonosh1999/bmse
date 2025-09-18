<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Questions - ') . $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Progress Indicator -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <div class="flex items-center text-green-600 relative">
                                <div
                                    class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-green-600 bg-green-600 text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div
                                    class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-green-600">
                                    Quiz Details</div>
                            </div>
                            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-green-600">
                            </div>
                            <div class="flex items-center text-purple-600 relative">
                                <div
                                    class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-purple-600 bg-purple-600 text-white">
                                    <span class="text-white font-bold text-lg">2</span>
                                </div>
                                <div
                                    class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-purple-600">
                                    Questions</div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Summary -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Quiz Summary</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div><strong>Title:</strong> {{ $quiz->title }}</div>
                            <div><strong>Course:</strong> {{ $quiz->course->title }}</div>
                            <div><strong>Lesson:</strong> {{ $quiz->lesson->title }}</div>
                            <div><strong>Passing Score:</strong> {{ $quiz->passing_score }}%</div>
                        </div>
                    </div>

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

                    <form method="POST" action="{{ route('quizzes.questions.store', $quiz) }}" id="questions-form">
                        @csrf

                        <div id="questions-container">
                            @if ($questions->count() > 0)
                                @foreach ($questions as $index => $question)
                                    <div class="question-item mb-6 p-4 border border-gray-200 rounded-lg"
                                        data-question="{{ $index }}">
                                        <div class="flex justify-between items-center mb-4">
                                            <h4 class="text-lg font-medium text-gray-900">Question {{ $index + 1 }}
                                            </h4>
                                            <button type="button"
                                                class="remove-question text-red-600 hover:text-red-800 {{ $questions->count() <= 1 ? 'hidden' : '' }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Question Text -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Question</label>
                                            <textarea name="questions[{{ $index }}][question]" rows="2"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                required>{{ old('questions.' . $index . '.question', $question->question) }}</textarea>
                                        </div>

                                        <!-- Question Type -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Question Type</label>
                                            <select name="questions[{{ $index }}][type]"
                                                class="question-type-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                required>
                                                <option value="">Select Question Type</option>
                                                <option value="multiple_choice"
                                                    {{ old('questions.' . $index . '.type', $question->type) == 'multiple_choice' ? 'selected' : '' }}>
                                                    Multiple Choice</option>
                                                <option value="true_false"
                                                    {{ old('questions.' . $index . '.type', $question->type) == 'true_false' ? 'selected' : '' }}>
                                                    True/False</option>
                                                <option value="fill_blank"
                                                    {{ old('questions.' . $index . '.type', $question->type) == 'fill_blank' ? 'selected' : '' }}>
                                                    Fill in the Blank</option>
                                            </select>
                                        </div>

                                        <!-- Multiple Choice Options -->
                                        <div
                                            class="mb-4 multiple-choice-options {{ old('questions.' . $index . '.type', $question->type) == 'multiple_choice' ? '' : 'hidden' }}">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Answer
                                                Options</label>
                                            @php
                                                $options = old(
                                                    'questions.' . $index . '.options',
                                                    $question->options ?? ['', '', '', ''],
                                                );
                                                if (!is_array($options)) {
                                                    $options = ['', '', '', ''];
                                                }
                                                while (count($options) < 4) {
                                                    $options[] = '';
                                                }
                                            @endphp
                                            @for ($i = 0; $i < 4; $i++)
                                                <div class="flex items-center mb-2">
                                                    <span
                                                        class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3 text-sm font-medium">{{ chr(65 + $i) }}</span>
                                                    <input type="text"
                                                        name="questions[{{ $index }}][options][]"
                                                        value="{{ $options[$i] }}"
                                                        placeholder="Option {{ chr(65 + $i) }}"
                                                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                </div>
                                            @endfor
                                        </div>

                                        <!-- Correct Answer -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Correct
                                                Answer</label>
                                            <input type="text" name="questions[{{ $index }}][correct_answer]"
                                                value="{{ old('questions.' . $index . '.correct_answer', $question->correct_answer) }}"
                                                class="correct-answer-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                required>
                                            <p class="mt-1 text-xs text-gray-500 answer-help">
                                                @if ($question->type == 'multiple_choice')
                                                    Enter the letter (A, B, C, or D) of the correct answer
                                                @elseif($question->type == 'true_false')
                                                    Enter "true" or "false"
                                                @else
                                                    Enter the exact answer
                                                @endif
                                            </p>
                                        </div>

                                        <!-- Explanation -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Explanation
                                                (Optional)</label>
                                            <textarea name="questions[{{ $index }}][explanation]" rows="2"
                                                placeholder="Explain why this is the correct answer..."
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('questions.' . $index . '.explanation', $question->explanation) }}</textarea>
                                        </div>

                                        <!-- Points -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Points</label>
                                            <input type="number" name="questions[{{ $index }}][points]"
                                                value="{{ old('questions.' . $index . '.points', $question->points ?? 1) }}"
                                                min="1" max="10"
                                                class="mt-1 block w-24 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                required>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="question-item mb-6 p-4 border border-gray-200 rounded-lg" data-question="0">
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="text-lg font-medium text-gray-900">Question 1</h4>
                                        <button type="button"
                                            class="remove-question text-red-600 hover:text-red-800 hidden">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Question Text -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Question</label>
                                        <textarea name="questions[0][question]" rows="2"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required></textarea>
                                    </div>

                                    <!-- Question Type -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Question Type</label>
                                        <select name="questions[0][type]"
                                            class="question-type-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required>
                                            <option value="">Select Question Type</option>
                                            <option value="multiple_choice">Multiple Choice</option>
                                            <option value="true_false">True/False</option>
                                            <option value="fill_blank">Fill in the Blank</option>
                                        </select>
                                    </div>

                                    <!-- Multiple Choice Options -->
                                    <div class="mb-4 multiple-choice-options hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Answer
                                            Options</label>
                                        @for ($i = 0; $i < 4; $i++)
                                            <div class="flex items-center mb-2">
                                                <span
                                                    class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3 text-sm font-medium">{{ chr(65 + $i) }}</span>
                                                <input type="text" name="questions[0][options][]"
                                                    placeholder="Option {{ chr(65 + $i) }}"
                                                    class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        @endfor
                                    </div>

                                    <!-- Correct Answer -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Correct Answer</label>
                                        <input type="text" name="questions[0][correct_answer]"
                                            class="correct-answer-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required>
                                        <p class="mt-1 text-xs text-gray-500 answer-help">Select question type first to
                                            see specific instructions</p>
                                    </div>

                                    <!-- Explanation -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Explanation
                                            (Optional)</label>
                                        <textarea name="questions[0][explanation]" rows="2" placeholder="Explain why this is the correct answer..."
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    </div>

                                    <!-- Points -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Points</label>
                                        <input type="number" name="questions[0][points]" value="1"
                                            min="1" max="10"
                                            class="mt-1 block w-24 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            required>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="button" id="add-question"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Another Question
                            </button>

                            <div class="flex items-center space-x-4">
                                <a href="{{ route('quizzes.show', $quiz) }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Cancel') }}
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Save Questions') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let questionCount = {{ $questions->count() > 0 ? $questions->count() - 1 : 0 }};

        // Add new question
        document.getElementById('add-question').addEventListener('click', function() {
            questionCount++;
            const container = document.getElementById('questions-container');
            const newQuestion = createQuestionHTML(questionCount);
            container.insertAdjacentHTML('beforeend', newQuestion);
            updateRemoveButtons();
        });

        // Handle question type change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('question-type-select')) {
                const questionItem = e.target.closest('.question-item');
                const multipleChoiceContainer = questionItem.querySelector('.multiple-choice-options');
                const correctAnswerInput = questionItem.querySelector('.correct-answer-input');
                const answerHelp = questionItem.querySelector('.answer-help');

                if (e.target.value === 'multiple_choice') {
                    multipleChoiceContainer.classList.remove('hidden');
                    answerHelp.textContent = 'Enter the letter (A, B, C, or D) of the correct answer';
                } else if (e.target.value === 'true_false') {
                    multipleChoiceContainer.classList.add('hidden');
                    answerHelp.textContent = 'Enter "true" or "false"';
                } else if (e.target.value === 'fill_blank') {
                    multipleChoiceContainer.classList.add('hidden');
                    answerHelp.textContent = 'Enter the exact answer';
                } else {
                    multipleChoiceContainer.classList.add('hidden');
                    answerHelp.textContent = 'Select question type first to see specific instructions';
                }
            }
        });

        // Remove question
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-question')) {
                e.target.closest('.question-item').remove();
                updateQuestionNumbers();
                updateRemoveButtons();
            }
        });

        function createQuestionHTML(index) {
            return `
                <div class="question-item mb-6 p-4 border border-gray-200 rounded-lg" data-question="${index}">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium text-gray-900">Question ${index + 1}</h4>
                        <button type="button" class="remove-question text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Question</label>
                        <textarea name="questions[${index}][question]" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Question Type</label>
                        <select name="questions[${index}][type]" class="question-type-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Question Type</option>
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="true_false">True/False</option>
                            <option value="fill_blank">Fill in the Blank</option>
                        </select>
                    </div>

                    <div class="mb-4 multiple-choice-options hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Answer Options</label>
                        <div class="flex items-center mb-2">
                            <span class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3 text-sm font-medium">A</span>
                            <input type="text" name="questions[${index}][options][]" placeholder="Option A" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex items-center mb-2">
                            <span class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3 text-sm font-medium">B</span>
                            <input type="text" name="questions[${index}][options][]" placeholder="Option B" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex items-center mb-2">
                            <span class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3 text-sm font-medium">C</span>
                            <input type="text" name="questions[${index}][options][]" placeholder="Option C" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex items-center mb-2">
                            <span class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3 text-sm font-medium">D</span>
                            <input type="text" name="questions[${index}][options][]" placeholder="Option D" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Correct Answer</label>
                        <input type="text" name="questions[${index}][correct_answer]" class="correct-answer-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <p class="mt-1 text-xs text-gray-500 answer-help">Select question type first to see specific instructions</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Explanation (Optional)</label>
                        <textarea name="questions[${index}][explanation]" rows="2" placeholder="Explain why this is the correct answer..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Points</label>
                        <input type="number" name="questions[${index}][points]" value="1" min="1" max="10" class="mt-1 block w-24 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                </div>
            `;
        }

        function updateQuestionNumbers() {
            const questionItems = document.querySelectorAll('.question-item');
            questionItems.forEach((item, index) => {
                const heading = item.querySelector('h4');
                heading.textContent = `Question ${index + 1}`;
                item.setAttribute('data-question', index);

                // Update input names
                const inputs = item.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name && name.includes('questions[')) {
                        const newName = name.replace(/questions\[\d+\]/, `questions[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });
        }

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-question');
            removeButtons.forEach(button => {
                if (removeButtons.length > 1) {
                    button.classList.remove('hidden');
                } else {
                    button.classList.add('hidden');
                }
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateRemoveButtons();

            // Trigger change events for existing question type selects
            document.querySelectorAll('.question-type-select').forEach(select => {
                if (select.value) {
                    select.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>
</x-app-layout>
