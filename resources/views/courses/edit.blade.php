<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course - ') . $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                    <form method="POST" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Course Title -->
                        <div>
                            <x-input-label for="title" :value="__('Course Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                :value="old('title', $course->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Course Description -->
                        <div>
                            <x-input-label for="description" :value="__('Course Description')" />
                            <textarea id="description" name="description" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('description', $course->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="">Select Category</option>
                                <option value="primary"
                                    {{ old('category', $course->category) == 'primary' ? 'selected' : '' }}>Primary
                                </option>
                                <option value="secondary"
                                    {{ old('category', $course->category) == 'secondary' ? 'selected' : '' }}>Secondary
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Class Level -->
                        <div>
                            <x-input-label for="class_level" :value="__('Class Level')" />
                            <select id="class_level" name="class_level"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="">Select Class Level</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                            <x-input-error :messages="$errors->get('class_level')" class="mt-2" />
                        </div>

                        <!-- Course Instructor -->
                        <div>
                            <x-input-label for="instructor" :value="__('Course Instructor')" />
                            <x-text-input id="instructor" class="block mt-1 w-full" type="text" name="instructor"
                                :value="old('instructor', $course->instructor)" required />
                            <x-input-error :messages="$errors->get('instructor')" class="mt-2" />
                        </div>

                        <!-- Current Cover Photo -->
                        @if ($course->cover_photo)
                            <div>
                                <x-input-label :value="__('Current Cover Photo')" />
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $course->cover_photo) }}" alt="Current cover"
                                        class="w-32 h-24 object-cover rounded-md border">
                                </div>
                            </div>
                        @endif

                        <!-- Cover Photo -->
                        <div>
                            <x-input-label for="cover_photo" :value="__('Cover Photo')" />
                            <input id="cover_photo" type="file" name="cover_photo" accept="image/*"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                            <p class="mt-1 text-sm text-gray-500">
                                {{ $course->cover_photo ? 'Upload a new image to replace the current cover photo' : 'Upload a cover image for your course' }}
                                (JPG, PNG, GIF - Max: 2MB)
                            </p>
                            <x-input-error :messages="$errors->get('cover_photo')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-4">
                            <a href="{{ route('courses.show', $course) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Course') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic class options -->
    <script>
        // Store the current selected values
        const currentCategory = '{{ old('category', $course->category) }}';
        const currentClassLevel = '{{ old('class_level', $course->class_level) }}';

        document.getElementById('category').addEventListener('change', function() {
            const category = this.value;
            const classLevelSelect = document.getElementById('class_level');

            // Clear existing options
            classLevelSelect.innerHTML = '<option value="">Select Class Level</option>';

            if (category) {
                // Enable the select
                classLevelSelect.disabled = false;

                // Fetch class options
                fetch(`{{ route('api.class-options') }}?category=${category}`)
                    .then(response => response.json())
                    .then(data => {
                        Object.keys(data).forEach(key => {
                            const option = document.createElement('option');
                            option.value = key;
                            option.textContent = data[key];

                            // Select the current class level if it matches
                            if (key === currentClassLevel) {
                                option.selected = true;
                            }

                            classLevelSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                classLevelSelect.disabled = true;
            }
        });

        // Initialize the class level options on page load
        window.addEventListener('load', function() {
            if (currentCategory) {
                document.getElementById('category').dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>
