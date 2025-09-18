<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Progress Indicator -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <div class="flex items-center text-purple-600 relative">
                                <div
                                    class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-purple-600 bg-purple-600 text-white">
                                    <span class="text-white font-bold text-lg">1</span>
                                </div>
                                <div
                                    class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-purple-600">
                                    Quiz Details</div>
                            </div>
                            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>
                            <div class="flex items-center text-gray-500 relative">
                                <div
                                    class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-gray-300">
                                    <span class="text-gray-500 font-bold text-lg">2</span>
                                </div>
                                <div
                                    class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">
                                    Questions</div>
                            </div>
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

                    <form method="POST" action="{{ route('quizzes.store') }}" class="space-y-6">
                        @csrf

                        <!-- Quiz Title -->
                        <div>
                            <x-input-label for="title" :value="__('Quiz Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Quiz Description -->
                        <div>
                            <x-input-label for="description" :value="__('Quiz Description')" />
                            <textarea id="description" name="description" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Course Selection -->
                        <div>
                            <x-input-label for="course_id" :value="__('Select Course')" />
                            <select id="course_id" name="course_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="">Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>
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
                                required disabled>
                                <option value="">Select Lesson</option>
                            </select>
                            <x-input-error :messages="$errors->get('lesson_id')" class="mt-2" />
                        </div>

                        <!-- Quiz Settings Row -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Max Attempts -->
                            <div>
                                <x-input-label for="max_attempts" :value="__('Max Attempts')" />
                                <select id="max_attempts" name="max_attempts"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="1" {{ old('max_attempts') == '1' ? 'selected' : '' }}>1 Attempt
                                    </option>
                                    <option value="2" {{ old('max_attempts') == '2' ? 'selected' : '' }}>2
                                        Attempts</option>
                                    <option value="3" {{ old('max_attempts', '3') == '3' ? 'selected' : '' }}>3
                                        Attempts</option>
                                    <option value="5" {{ old('max_attempts') == '5' ? 'selected' : '' }}>5
                                        Attempts</option>
                                    <option value="-1" {{ old('max_attempts') == '-1' ? 'selected' : '' }}>
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
                                    <option value="5" {{ old('time_limit') == '5' ? 'selected' : '' }}>5 Minutes
                                    </option>
                                    <option value="10" {{ old('time_limit') == '10' ? 'selected' : '' }}>10 Minutes
                                    </option>
                                    <option value="15" {{ old('time_limit') == '15' ? 'selected' : '' }}>15 Minutes
                                    </option>
                                    <option value="30" {{ old('time_limit') == '30' ? 'selected' : '' }}>30 Minutes
                                    </option>
                                    <option value="45" {{ old('time_limit') == '45' ? 'selected' : '' }}>45 Minutes
                                    </option>
                                    <option value="60" {{ old('time_limit') == '60' ? 'selected' : '' }}>60 Minutes
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
                                    <option value="50" {{ old('passing_score') == '50' ? 'selected' : '' }}>50%
                                    </option>
                                    <option value="60" {{ old('passing_score', '60') == '60' ? 'selected' : '' }}>
                                        60%</option>
                                    <option value="70" {{ old('passing_score') == '70' ? 'selected' : '' }}>70%
                                    </option>
                                    <option value="80" {{ old('passing_score') == '80' ? 'selected' : '' }}>80%
                                    </option>
                                    <option value="90" {{ old('passing_score') == '90' ? 'selected' : '' }}>90%
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('passing_score')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('quizzes.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Continue to Questions') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic lesson options -->
    <script>
        document.getElementById('course_id').addEventListener('change', function() {
            const courseId = this.value;
            const lessonSelect = document.getElementById('lesson_id');

            // Clear existing options
            lessonSelect.innerHTML = '<option value="">Select Lesson</option>';

            if (courseId) {
                // Enable the select
                lessonSelect.disabled = false;

                // Fetch lesson options
                fetch(`{{ route('api.lessons') }}?course_id=${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(lesson => {
                            const option = document.createElement('option');
                            option.value = lesson.id;
                            option.textContent = lesson.title;
                            lessonSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                lessonSelect.disabled = true;
            }
        });

        // Trigger change event if course is already selected (for form validation errors)
        window.addEventListener('load', function() {
            const courseId = document.getElementById('course_id').value;
            if (courseId) {
                document.getElementById('course_id').dispatchEvent(new Event('change'));

                // Set selected lesson if there was a validation error
                setTimeout(() => {
                    const selectedLessonId = '{{ old('lesson_id') }}';
                    if (selectedLessonId) {
                        document.getElementById('lesson_id').value = selectedLessonId;
                    }
                }, 500);
            }
        });
    </script>
</x-app-layout>
