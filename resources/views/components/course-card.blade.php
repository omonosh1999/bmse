@props([
    'title' => '',
    'description' => '',
    'image' => null,
    'level' => '',
    'duration' => '',
    'lessons' => '',
    'price' => '',
    'route' => '#',
    'buttonText' => 'View Course',
    'badge' => null,
    'featured' => false,
])

<div
    class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group {{ $featured ? 'ring-2 ring-[#FBC905]' : '' }}">
    <!-- Image Section -->
    <div class="relative overflow-hidden h-48">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $title }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <!-- Default Math Icon Background -->
            <div class="w-full h-full bg-gradient-to-br from-[#006738] to-green-600 flex items-center justify-center">
                <div class="text-white/20 text-8xl font-bold">
                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8 12H9.5v-2H11v-2H9.5V9H11V7H9.5v2h-2V7H6v2h1.5v2H6v2h1.5v2H6v2h1.5v-2h2v2H11v-2zm6-2h-1.75l1.75-3.5V7h-4v2h2.25L13.5 12.5V15H17v-2z" />
                    </svg>
                </div>
                <!-- Math symbols overlay -->
                <div class="absolute inset-0 bg-black/10">
                    <div class="absolute top-4 left-4 text-white/40 text-2xl font-bold">∑</div>
                    <div class="absolute top-4 right-4 text-white/40 text-2xl font-bold">π</div>
                    <div class="absolute bottom-4 left-4 text-white/40 text-2xl font-bold">∞</div>
                    <div class="absolute bottom-4 right-4 text-white/40 text-2xl font-bold">√</div>
                </div>
            </div>
        @endif

        <!-- Level Badge -->
        @if ($level)
            <div class="absolute top-3 left-3">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#FBC905] text-[#006738]">
                    {{ $level }}
                </span>
            </div>
        @endif

        <!-- Featured Badge -->
        @if ($featured)
            <div class="absolute top-3 right-3">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-[#006738] shadow-lg">
                    ★ Featured
                </span>
            </div>
        @endif
    </div>

    <!-- Content Section -->
    <div class="p-6 flex flex-col h-64">
        <!-- Title -->
        <h3
            class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-[#006738] transition-colors duration-200">
            {{ $title }}
        </h3>

        <!-- Description -->
        <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-3 leading-relaxed">
            {{ $description }}
        </p>

        <!-- Meta Information -->
        <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-6">
            @if ($duration)
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $duration }}
                </div>
            @endif

            @if ($lessons)
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    {{ $lessons }}
                </div>
            @endif
        </div>

        <!-- Price and Button Section -->
        <div class="mt-auto">
            {{-- @if ($price)
                <div class="flex items-center justify-between mb-3">
                    <span class="text-2xl font-bold text-[#006738]">{{ $price }}</span>
                    @if (str_contains($price, 'Free'))
                        <span class="text-sm text-green-600 font-medium">No cost</span>
                    @endif
                </div>
            @endif --}}

            <!-- Wide Button -->
            <a href="{{ $route }}"
                class="w-full inline-flex items-center justify-center px-6 py-3 bg-[#006738] text-white font-semibold rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-[#006738] focus:ring-offset-2 transition-all duration-200 group-hover:shadow-lg">
                {{ $buttonText }}
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .line-clamp-3 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }
</style>
