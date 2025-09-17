@extends('layouts.main')

@section('content')
    <div class="min-h-screen">
        <!-- Header Section -->
        <section class="bg-gradient-to-br from-[#006738] to-green-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Contact <span class="text-[#FBC905]">Us</span>
                </h1>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Ready to start your mathematical journey? We're here to help you every step of the way
                </p>
                <div class="flex justify-center">
                    <div class="w-24 h-1 bg-[#FBC905] rounded-full"></div>
                </div>
            </div>
        </section>

        <!-- Contact Information Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                    <!-- Contact Form -->
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Get In Touch</h2>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            Have questions about our courses or services? Fill out the form below and we'll get back to you
                            within 24 hours.
                        </p>

                        <!-- Success/Error Messages -->
                        @if (session('success'))
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-red-800 font-medium">Please fix the following errors:</h4>
                                        <ul class="mt-2 text-red-700 text-sm list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form class="space-y-6" action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name
                                        *</label>
                                    <input type="text" id="first_name" name="first_name" required
                                        value="{{ old('first_name') }}"
                                        class="w-full px-4 py-3 border @error('first_name') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-[#006738] focus:border-transparent transition-colors duration-200"
                                        placeholder="Enter your first name">
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name
                                        *</label>
                                    <input type="text" id="last_name" name="last_name" required
                                        value="{{ old('last_name') }}"
                                        class="w-full px-4 py-3 border @error('last_name') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-[#006738] focus:border-transparent transition-colors duration-200"
                                        placeholder="Enter your last name">
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address
                                    *</label>
                                <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border @error('email') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-[#006738] focus:border-transparent transition-colors duration-200"
                                    placeholder="Enter your email address">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone
                                    Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 border @error('phone') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-[#006738] focus:border-transparent transition-colors duration-200"
                                    placeholder="Enter your phone number">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="student_level" class="block text-sm font-medium text-gray-700 mb-2">Student
                                    Level</label>
                                <select id="student_level" name="student_level"
                                    class="w-full px-4 py-3 border @error('student_level') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-[#006738] focus:border-transparent transition-colors duration-200">
                                    <option value="">Select student level</option>
                                    <option value="primary" {{ old('student_level') == 'primary' ? 'selected' : '' }}>
                                        Primary (Ages 5-11)</option>
                                    <option value="secondary" {{ old('student_level') == 'secondary' ? 'selected' : '' }}>
                                        Secondary (Ages 11-18)</option>
                                    <option value="adult" {{ old('student_level') == 'adult' ? 'selected' : '' }}>Adult
                                        Learner</option>
                                    <option value="teacher" {{ old('student_level') == 'teacher' ? 'selected' : '' }}>
                                        Teacher/Educator</option>
                                </select>
                                @error('student_level')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="inquiry_type" class="block text-sm font-medium text-gray-700 mb-2">Inquiry Type
                                    *</label>
                                <select id="inquiry_type" name="inquiry_type" required
                                    class="w-full px-4 py-3 border @error('inquiry_type') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-[#006738] focus:border-transparent transition-colors duration-200">
                                    <option value="">Select inquiry type</option>
                                    <option value="online_courses"
                                        {{ old('inquiry_type') == 'online_courses' ? 'selected' : '' }}>Online Courses
                                        Information</option>
                                    <option value="live_classes"
                                        {{ old('inquiry_type') == 'live_classes' ? 'selected' : '' }}>Live Online Classes
                                    </option>
                                    <option value="physical_classes"
                                        {{ old('inquiry_type') == 'physical_classes' ? 'selected' : '' }}>Physical Classes
                                        (Labone Campus)</option>
                                    <option value="teacher_training"
                                        {{ old('inquiry_type') == 'teacher_training' ? 'selected' : '' }}>Teacher Training
                                        & Seminars</option>
                                    <option value="textbooks" {{ old('inquiry_type') == 'textbooks' ? 'selected' : '' }}>
                                        BriliantMath Textbooks</option>
                                    <option value="curriculum"
                                        {{ old('inquiry_type') == 'curriculum' ? 'selected' : '' }}>Curriculum Consulting
                                    </option>
                                    <option value="general" {{ old('inquiry_type') == 'general' ? 'selected' : '' }}>
                                        General Information</option>
                                    <option value="other" {{ old('inquiry_type') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('inquiry_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message
                                    *</label>
                                <textarea id="message" name="message" rows="6" required
                                    class="w-full px-4 py-3 border @error('message') border-red-300 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-[#006738] focus:border-transparent transition-colors duration-200"
                                    placeholder="Tell us more about your inquiry or any questions you have...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" id="newsletter" name="newsletter" value="1"
                                    {{ old('newsletter') ? 'checked' : '' }}
                                    class="mt-1 mr-3 w-4 h-4 text-[#006738] border-gray-300 rounded focus:ring-[#006738]">
                                <label for="newsletter" class="text-sm text-gray-600">
                                    I would like to receive updates about new courses, special offers, and mathematics
                                    education tips via email.
                                </label>
                            </div>

                            <button type="submit"
                                class="w-full bg-[#006738] text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center justify-center">
                                Send Message
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-8 lg:p-12 rounded-2xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8">Contact Information</h3>

                        <!-- Main Office -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-[#006738] mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Main Campus
                            </h4>
                            <div class="ml-7 space-y-2 text-gray-600">
                                <p class="flex items-start">
                                    <span class="font-medium text-gray-900 w-16 flex-shrink-0">Address:</span>
                                    <span>Labone, Accra, Greater Accra Region, Ghana</span>
                                </p>
                                <p class="flex items-start">
                                    <span class="font-medium text-gray-900 w-16 flex-shrink-0">Hours:</span>
                                    <span>
                                        Monday - Friday: 8:00 AM - 6:00 PM<br>
                                        Saturday: 9:00 AM - 4:00 PM<br>
                                        Sunday: Closed
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Contact Methods -->
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-[#006738] text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Email</h4>
                                    <p class="text-gray-600 mb-1">info@brilliantmath.com</p>
                                    <p class="text-sm text-gray-500">General inquiries and course information</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-[#FBC905] text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Phone</h4>
                                    <p class="text-gray-600 mb-1">+233 (0) 123 456 789</p>
                                    <p class="text-sm text-gray-500">Call us during business hours</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div
                                    class="w-12 h-12 bg-green-600 text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">WhatsApp</h4>
                                    <p class="text-gray-600 mb-1">+233 (0) 987 654 321</p>
                                    <p class="text-sm text-gray-500">Quick questions and course support</p>
                                </div>
                            </div>
                        </div>

                        <!-- Response Time -->
                        <div class="mt-8 p-4 bg-white rounded-lg border border-gray-200">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm">Response Time</h4>
                                    <p class="text-sm text-gray-600">We typically respond within 24 hours</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Quick Links -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How Can We Help You?</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Quick links to get you started with the right service for your needs
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Online Courses -->
                    <div class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow duration-200 group">
                        <div
                            class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Online Courses</h3>
                        <p class="text-sm text-gray-600 mb-4">Self-paced learning modules</p>
                        <a href="{{ route('courses.index') }}"
                            class="text-[#006738] font-medium hover:underline text-sm">
                            Browse Courses →
                        </a>
                    </div>

                    <!-- Live Classes -->
                    <div class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow duration-200 group">
                        <div
                            class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Live Classes</h3>
                        <p class="text-sm text-gray-600 mb-4">Interactive online sessions</p>
                        <a href="mailto:info@brilliantmath.com?subject=Live Classes Inquiry"
                            class="text-[#006738] font-medium hover:underline text-sm">
                            Join Classes →
                        </a>
                    </div>

                    <!-- Physical Classes -->
                    <div class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow duration-200 group">
                        <div
                            class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Campus Classes</h3>
                        <p class="text-sm text-gray-600 mb-4">In-person learning in Labone</p>
                        <a href="tel:+2330123456789" class="text-[#006738] font-medium hover:underline text-sm">
                            Enroll Now →
                        </a>
                    </div>

                    <!-- Teacher Training -->
                    <div class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow duration-200 group">
                        <div
                            class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Teacher Training</h3>
                        <p class="text-sm text-gray-600 mb-4">Professional development</p>
                        <a href="mailto:info@brilliantmath.com?subject=Teacher Training Inquiry"
                            class="text-[#006738] font-medium hover:underline text-sm">
                            Learn More →
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                    <p class="text-lg text-gray-600">
                        Quick answers to common questions about our services
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">What age groups do you serve?</h3>
                        <p class="text-gray-600">
                            We serve students from Primary (ages 5-11) through Secondary (ages 11-18) levels, as well as
                            adult learners and professional educators seeking development opportunities.
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Which curricula do you support?</h3>
                        <p class="text-gray-600">
                            Our courses are aligned with British National Numeracy Curriculum, Cambridge IGCSE Curriculum,
                            and WAEC Syllabus to ensure comprehensive coverage of required standards.
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Do you offer both online and in-person
                            classes?</h3>
                        <p class="text-gray-600">
                            Yes! We offer self-paced online courses, live online classes, and in-person classes at our
                            Labone, Accra campus. Choose the learning format that works best for you.
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">How can I track my child's progress?</h3>
                        <p class="text-gray-600">
                            Our platform includes comprehensive progress tracking features that allow both students and
                            parents to monitor learning advancement, completed lessons, and assessment results.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Section (Placeholder) -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Visit Our Campus</h2>
                    <p class="text-lg text-gray-600">
                        Located in the heart of Labone, Accra - easily accessible by public transport
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <div
                        class="w-24 h-24 bg-[#006738] text-white rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">BriliantMath Learning Center</h3>
                    <p class="text-gray-600 mb-6">Labone, Accra, Greater Accra Region, Ghana</p>
                    <p class="text-sm text-gray-500 mb-8">
                        Interactive map and detailed directions will be available soon.
                        Contact us for specific location details and transportation guidance.
                    </p>
                    <a href="tel:+2330123456789"
                        class="inline-block px-6 py-3 bg-[#006738] text-white font-semibold rounded-full hover:bg-green-700 transition-colors duration-200">
                        Call for Directions
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-br from-[#006738] to-green-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Ready to Start Your Mathematical Journey?
                </h2>
                <p class="text-lg md:text-xl text-green-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Join thousands of students who have transformed their relationship with mathematics through our
                    comprehensive learning platform
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('courses.index') }}"
                        class="px-8 py-3 bg-[#FBC905] text-[#006738] font-semibold rounded-full hover:bg-yellow-400 transition-colors duration-200">
                        Browse Our Courses
                    </a>
                    <a href="tel:+2330123456789"
                        class="px-8 py-3 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-[#006738] transition-colors duration-200">
                        Call Us Now
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
