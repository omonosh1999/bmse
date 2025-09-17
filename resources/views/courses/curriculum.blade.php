<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Curriculum - ') . $course->title }}
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
                                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-green-600 bg-green-600 text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-green-600">Course Details</div>
                            </div>
                            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-green-600"></div>
                            <div class="flex items-center text-blue-600 relative">
                                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2 border-blue-600 bg-blue-600 text-white">
                                    <span class="text-white font-bold text-lg">2</span>
                                </div>
                                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-blue-600">Curriculum</div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Summary -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Course Summary</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div><strong>Title:</strong> {{ $course->title }}</div>
                            <div><strong>Category:</strong> {{ ucfirst($course->category) }}</div>
                            <div><strong>Class:</strong> {{ $course->class_level }}</div>
                            <div><strong>Instructor:</strong> {{ $course->instructor }}</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('courses.curriculum.store', $course) }}" enctype="multipart/form-data" id="curriculum-form">
                        @csrf

                        <div id="lessons-container">
                            @if($lessons->count() > 0)
                                @foreach($lessons as $index => $lesson)
                                    <div class="lesson-item mb-6 p-4 border border-gray-200 rounded-lg" data-lesson="{{ $index }}">
                                        <div class="flex justify-between items-center mb-4">
                                            <h4 class="text-lg font-medium text-gray-900">Lesson {{ $index + 1 }}</h4>
                                            <button type="button" class="remove-lesson text-red-600 hover:text-red-800 {{ $lessons->count() <= 1 ? 'hidden' : '' }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Lesson Title -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Lesson Title</label>
                                            <input type="text" name="lessons[{{ $index }}][title]" value="{{ old('lessons.'.$index.'.title', $lesson->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        </div>

                                        <!-- Lesson Description -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Lesson Description</label>
                                            <textarea name="lessons[{{ $index }}][description]" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('lessons.'.$index.'.description', $lesson->description) }}</textarea>
                                        </div>

                                        <!-- Material Type -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Material Type</label>
                                            <select name="lessons[{{ $index }}][material_type]" class="material-type-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                <option value="">Select Material Type</option>
                                                <option value="file" {{ old('lessons.'.$index.'.material_type', $lesson->material_type) == 'file' ? 'selected' : '' }}>Upload File</option>
                                                <option value="url" {{ old('lessons.'.$index.'.material_type', $lesson->material_type) == 'url' ? 'selected' : '' }}>YouTube/Video URL</option>
                                            </select>
                                        </div>

                                        <!-- File Upload -->
                                        <div class="mb-4 file-upload-container {{ old('lessons.'.$index.'.material_type', $lesson->material_type) == 'file' ? '' : 'hidden' }}">
                                            <label class="block text-sm font-medium text-gray-700">Upload Material</label>
                                            @if($lesson->material_type == 'file' && $lesson->material_path)
                                                <div class="mb-2 text-sm text-gray-600">
                                                    Current file: <span class="font-medium">{{ basename($lesson->material_path) }}</span>
                                                </div>
                                            @endif
                                            <input type="file" name="lessons[{{ $index }}][material_file]" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.avi,.mov,.wmv" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $lesson->material_type == 'file' ? 'Upload a new file to replace the current one' : 'Supported: PDF, DOC, DOCX, PPT, PPTX, MP4, AVI, MOV, WMV' }} (Max: 50MB)
                                            </p>
                                        </div>

                                        <!-- URL Input -->
                                        <div class="mb-4 url-input-container {{ old('lessons.'.$index.'.material_type', $lesson->material_type) == 'url' ? '' : 'hidden' }}">
                                            <label class="block text-sm font-medium text-gray-700">Video URL</label>
                                            <input type="url" name="lessons[{{ $index }}][material_url]" value="{{ old('lessons.'.$index.'.material_url', $lesson->material_type == 'url' ? $lesson->material_path : '') }}" placeholder="https://www.youtube.com/watch?v=..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            <p class="mt-1 text-xs text-gray-500">YouTube, Vimeo, or direct video links</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="lesson-item mb-6 p-4 border border-gray-200 rounded-lg" data-lesson="0">
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="text-lg font-medium text-gray-900">Lesson 1</h4>
                                        <button type="button" class="remove-lesson text-red-600 hover:text-red-800 hidden">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Lesson Title -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Lesson Title</label>
                                        <input type="text" name="lessons[0][title]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>

                                    <!-- Lesson Description -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Lesson Description</label>
                                        <textarea name="lessons[0][description]" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                                    </div>

                                    <!-- Material Type -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Material Type</label>
                                        <select name="lessons[0][material_type]" class="material-type-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">Select Material Type</option>
                                            <option value="file">Upload File</option>
                                            <option value="url">YouTube/Video URL</option>
                                        </select>
                                    </div>

                                    <!-- File Upload -->
                                    <div class="mb-4 file-upload-container hidden">
                                        <label class="block text-sm font-medium text-gray-700">Upload Material</label>
                                        <input type="file" name="lessons[0][material_file]" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.avi,.mov,.wmv" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <p class="mt-1 text-xs text-gray-500">Supported: PDF, DOC, DOCX, PPT, PPTX, MP4, AVI, MOV, WMV (Max: 50MB)</p>
                                    </div>

                                    <!-- URL Input -->
                                    <div class="mb-4 url-input-container hidden">
                                        <label class="block text-sm font-medium text-gray-700">Video URL</label>
                                        <input type="url" name="lessons[0][material_url]" placeholder="https://www.youtube.com/watch?v=..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <p class="mt-1 text-xs text-gray-500">YouTube, Vimeo, or direct video links</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="button" id="add-lesson" class="inline-flex items-center px-4 py-2 bg-green-600 border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Another Lesson
                            </button>

                            <div class="flex items-center space-x-4">
                                <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Cancel') }}
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Save Curriculum') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let lessonCount = {{ $lessons->count() > 0 ? $lessons->count() - 1 : 0 }};

        // Add new lesson
        document.getElementById('add-lesson').addEventListener('click', function() {
            lessonCount++;
            const container = document.getElementById('lessons-container');
            const newLesson = createLessonHTML(lessonCount);
            container.insertAdjacentHTML('beforeend', newLesson);
            updateRemoveButtons();
        });

        // Handle material type change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('material-type-select')) {
                const lessonItem = e.target.closest('.lesson-item');
                const fileContainer = lessonItem.querySelector('.file-upload-container');
                const urlContainer = lessonItem.querySelector('.url-input-container');
                const fileInput = lessonItem.querySelector('input[type="file"]');
                const urlInput = lessonItem.querySelector('input[type="url"]');

                if (e.target.value === 'file') {
                    fileContainer.classList.remove('hidden');
                    urlContainer.classList.add('hidden');
                    fileInput.required = true;
                    urlInput.required = false;
                } else if (e.target.value === 'url') {
                    urlContainer.classList.remove('hidden');
                    fileContainer.classList.add('hidden');
                    urlInput.required = true;
                    fileInput.required = false;
                } else {
                    fileContainer.classList.add('hidden');
                    urlContainer.classList.add('hidden');
                    fileInput.required = false;
                    urlInput.required = false;
                }
            }
        });

        // Remove lesson
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-lesson')) {
                e.target.closest('.lesson-item').remove();
                updateLessonNumbers();
                updateRemoveButtons();
            }
        });

        function createLessonHTML(index) {
            return `
                <div class="lesson-item mb-6 p-4 border border-gray-200 rounded-lg" data-lesson="${index}">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-medium text-gray-900">Lesson ${index + 1}</h4>
                        <button type="button" class="remove-lesson text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Lesson Title</label>
                        <input type="text" name="lessons[${index}][title]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Lesson Description</label>
                        <textarea name="lessons[${index}][description]" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Material Type</label>
                        <select name="lessons[${index}][material_type]" class="material-type-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Material Type</option>
                            <option value="file">Upload File</option>
                            <option value="url">YouTube/Video URL</option>
                        </select>
                    </div>

                    <div class="mb-4 file-upload-container hidden">
                        <label class="block text-sm font-medium text-gray-700">Upload Material</label>
                        <input type="file" name="lessons[${index}][material_file]" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.avi,.mov,.wmv" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <p class="mt-1 text-xs text-gray-500">Supported: PDF, DOC, DOCX, PPT, PPTX, MP4, AVI, MOV, WMV (Max: 50MB)</p>
                    </div>

                    <div class="mb-4 url-input-container hidden">
                        <label class="block text-sm font-medium text-gray-700">Video URL</label>
                        <input type="url" name="lessons[${index}][material_url]" placeholder="https://www.youtube.com/watch?v=..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <p class="mt-1 text-xs text-gray-500">YouTube, Vimeo, or direct video links</p>
                    </div>
                </div>
            `;
        }

        function updateLessonNumbers() {
            const lessonItems = document.querySelectorAll('.lesson-item');
            lessonItems.forEach((item, index) => {
                const heading = item.querySelector('h4');
                heading.textContent = `Lesson ${index + 1}`;
                item.setAttribute('data-lesson', index);
                
                // Update input names
                const inputs = item.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name && name.includes('lessons[')) {
                        const newName = name.replace(/lessons\[\d+\]/, `lessons[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });
        }

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-lesson');
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
            
            // Trigger change events for existing material type selects
            document.querySelectorAll('.material-type-select').forEach(select => {
                if (select.value) {
                    select.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>
</x-app-layout>