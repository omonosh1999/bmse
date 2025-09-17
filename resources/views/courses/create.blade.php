<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Progress Indicator -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <div class="flex items-center text-blue-600 relative">
                                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-blue-600 bg-blue-600 text-white">
                                    <span class="text-white font-bold text-lg">1</span>
                                </div>
                                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-blue-600">Course Details</div>
                            </div>
                            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>
                            <div class="flex items-center text-gray-500 relative">
                                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-gray-300">
                                    <span class="text-gray-500 font-bold text-lg">2</span>
                                </div>
                                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">Curriculum</div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Course Title -->
                        <div>
                            <x-input-label for="title" :value="__('Course Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Course Description -->
                        <div>
                            <x-input-label for="description" :value="__('Course Description')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Category</option>
                                <option value="primary" {{ old('category') == 'primary' ? 'selected' : '' }}>Primary</option>
                                <option value="secondary" {{ old('category') == 'secondary' ? 'selected' : '' }}>Secondary</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Class Level -->
                        <div>
                            <x-input-label for="class_level" :value="__('Class Level')" />
                            <select id="class_level" name="class_level" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required disabled>
                                <option value="">Select Class Level</option>
                            </select>
                            <x-input-error :messages="$errors->get('class_level')" class="mt-2" />
                        </div>

                        <!-- Course Instructor -->
                        <div>
                            <x-input-label for="instructor" :value="__('Course Instructor')" />
                            <x-text-input id="instructor" class="block mt-1 w-full" type="text" name="instructor" :value="old('instructor')" required />
                            <x-input-error :messages="$errors->get('instructor')" class="mt-2" />
                        </div>

                        <!-- Cover Photo -->
                        <div>
                            <x-input-label for="cover_photo" :value="__('Cover Photo')" />
                            <input id="cover_photo" type="file" name="cover_photo" accept="image/*" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                            <p class="mt-1 text-sm text-gray-500">Upload a cover image for your course (JPG, PNG, GIF - Max: 2MB)</p>
                            <x-input-error :messages="$errors->get('cover_photo')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Continue to Curriculum') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic class options -->
    <script>
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
                            classLevelSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                classLevelSelect.disabled = true;
            }
        });

        // Trigger change event if category is already selected (for form validation errors)
        window.addEventListener('load', function() {
            const category = document.getElementById('category').value;
            if (category) {
                document.getElementById('category').dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>