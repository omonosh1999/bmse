<!-- Navbar -->
<header class="flex justify-between items-center bg-white sticky top-0 z-50 shadow-sm px-3 h-16 md:h-20">
    <div class="flex items-center space-x-2 md:space-x-3">
        <a href="{{ route('home') }}">
            <img class="h-10 md:h-12 lg:h-12 w-auto" src="{{ asset('images/bmse-logo-main.png') }}" alt="BMSE Logo" />
        </a>
    </div>

    <!-- Desktop Navigation -->
    <nav class="hidden lg:flex ml-0 items-center text-gray-700">
        <a href="{{ route('home') }}"
            class="uppercase hover:bg-[#FBC90533] py-7 px-4 hover:text-[#FBC905] font-medium text-[13px] transition-colors duration-200 {{ request()->routeIs('home') ? 'text-[#FBC905] bg-[#FBC90533]' : '' }}">
            Home
        </a>
        <a href="{{ route('primary') }}"
            class="uppercase hover:bg-[#FBC90533] py-7 px-4 hover:text-[#FBC905] font-medium text-[13px] transition-colors duration-200 {{ request()->routeIs('primary') ? 'text-[#FBC905] bg-[#FBC90533]' : '' }}">
            Primary
        </a>
        <a href="{{ route('secondary') }}"
            class="uppercase hover:bg-[#FBC90533] py-7 px-4 hover:text-[#FBC905] font-medium text-[13px] transition-colors duration-200 {{ request()->routeIs('secondary') ? 'text-[#FBC905] bg-[#FBC90533]' : '' }}">
            Secondary
        </a>
        <a href="{{ route('mental') }}"
            class="uppercase hover:bg-[#FBC90533] py-7 px-4 hover:text-[#FBC905] font-medium text-[13px] transition-colors duration-200 {{ request()->routeIs('mental') ? 'text-[#FBC905] bg-[#FBC90533]' : '' }}">
            Mental
        </a>
        <a href="{{ route('about-us') }}"
            class="uppercase hover:bg-[#FBC90533] py-7 px-4 hover:text-[#FBC905] font-medium text-[13px] transition-colors duration-200 {{ request()->routeIs('about-us') ? 'text-[#FBC905] bg-[#FBC90533]' : '' }}">
            About Us
        </a>
        <a href="{{ route('services') }}"
            class="uppercase hover:bg-[#FBC90533] py-7 px-4 hover:text-[#FBC905] font-medium text-[13px] transition-colors duration-200 {{ request()->routeIs('services') ? 'text-[#FBC905] bg-[#FBC90533]' : '' }}">
            Services
        </a>
        <a href="{{ route('contact') }}"
            class="uppercase hover:bg-[#FBC90533] py-7 px-4 hover:text-[#FBC905] font-medium text-[13px] transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-[#FBC905] bg-[#FBC90533]' : '' }}">
            Contact
        </a>
    </nav>

    <!-- Desktop Auth Buttons -->
    {{-- <div class="hidden lg:flex items-center space-x-2 md:space-x-3">
        @auth
            <!-- User is logged in -->
            <a href="{{ route('courses.index') }}" 
               class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200">
                My Courses
            </a>
            <div class="relative group">
                <button class="flex items-center px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200">
                    {{ Auth::user()->name }}
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- User is not logged in -->
            <a href="{{ route('login') }}" 
               class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200">
                Log In
            </a>
            <a href="{{ route('register') }}" 
               class="rounded-full px-4 md:px-6 py-2 bg-[#00673833] hover:bg-[#006738] hover:text-white text-[#006738] font-medium text-sm md:text-base transition-all duration-200">
                Sign Up
            </a>
        @endauth
    </div> --}}

    <!-- Mobile Auth and Menu -->
    <div class="flex lg:hidden items-center space-x-2">
        <!-- Mobile Sign Up - visible on medium screens -->
        {{-- @guest
            <a href="{{ route('register') }}"
                class="hidden md:block rounded-full px-3 py-1.5 bg-[#00673833] hover:bg-[#006738] hover:text-white text-[#006738] font-medium text-sm transition-all duration-200">
                Sign Up
            </a>
        @endguest --}}

        <!-- Hamburger Menu Button -->
        <button onclick="toggleMobileMenu()" class="p-2 rounded-md hover:bg-gray-100 transition-colors duration-200"
            aria-label="Toggle menu">
            <svg id="menu-icon" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
            <svg id="close-icon" class="w-6 h-6 text-gray-600 hidden" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div id="mobile-overlay"
    class="lg:hidden fixed inset-0 bg-black/50 bg-opacity-50 transition-opacity duration-300 z-40 opacity-0 invisible"
    onclick="closeMobileMenu()">
</div>

<!-- Mobile Menu -->
<div id="mobile-menu"
    class="lg:hidden fixed top-0 right-0 h-full w-80 max-w-[85vw] bg-white shadow-xl transform transition-transform duration-300 z-50 translate-x-full">

    <!-- Mobile Menu Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-200">
        <img class="h-10 w-auto" src="{{ asset('images/bmse-logo-main.png') }}" alt="BMSE Logo" />
        <button onclick="closeMobileMenu()" class="p-2 rounded-md hover:bg-gray-100 transition-colors duration-200"
            aria-label="Close menu">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Navigation Links -->
    <nav class="flex flex-col p-4 space-y-1">
        <a href="{{ route('home') }}" onclick="closeMobileMenu()"
            class="uppercase hover:bg-gray-50 hover:text-[#006738] font-medium text-gray-700 py-3 px-4 rounded-md transition-all duration-200 {{ request()->routeIs('home') ? 'bg-gray-50 text-[#006738]' : '' }}">
            Home
        </a>
        <a href="{{ route('primary') }}" onclick="closeMobileMenu()"
            class="uppercase hover:bg-gray-50 hover:text-[#006738] font-medium text-gray-700 py-3 px-4 rounded-md transition-all duration-200 {{ request()->routeIs('primary') ? 'bg-gray-50 text-[#006738]' : '' }}">
            Primary
        </a>
        <a href="{{ route('secondary') }}" onclick="closeMobileMenu()"
            class="uppercase hover:bg-gray-50 hover:text-[#006738] font-medium text-gray-700 py-3 px-4 rounded-md transition-all duration-200 {{ request()->routeIs('secondary') ? 'bg-gray-50 text-[#006738]' : '' }}">
            Secondary
        </a>
        <a href="{{ route('mental') }}" onclick="closeMobileMenu()"
            class="uppercase hover:bg-gray-50 hover:text-[#006738] font-medium text-gray-700 py-3 px-4 rounded-md transition-all duration-200 {{ request()->routeIs('mental') ? 'bg-gray-50 text-[#006738]' : '' }}">
            Mental
        </a>
        <a href="{{ route('about-us') }}" onclick="closeMobileMenu()"
            class="uppercase hover:bg-gray-50 hover:text-[#006738] font-medium text-gray-700 py-3 px-4 rounded-md transition-all duration-200 {{ request()->routeIs('about-us') ? 'bg-gray-50 text-[#006738]' : '' }}">
            About Us
        </a>
        <a href="{{ route('services') }}" onclick="closeMobileMenu()"
            class="uppercase hover:bg-gray-50 hover:text-[#006738] font-medium text-gray-700 py-3 px-4 rounded-md transition-all duration-200 {{ request()->routeIs('services') ? 'bg-gray-50 text-[#006738]' : '' }}">
            Services
        </a>
        <a href="{{ route('contact') }}" onclick="closeMobileMenu()"
            class="uppercase hover:bg-gray-50 hover:text-[#006738] font-medium text-gray-700 py-3 px-4 rounded-md transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-gray-50 text-[#006738]' : '' }}">
            Contact
        </a>

        @auth
            <hr class="my-2 border-gray-200">
            <a href="{{ route('courses.index') }}" onclick="closeMobileMenu()"
                class="uppercase hover:bg-gray-50 hover:text-[#006738] font-medium text-gray-700 py-3 px-4 rounded-md transition-all duration-200">
                My Courses
            </a>
            <a href="{{ route('dashboard') }}" onclick="closeMobileMenu()"
                class="uppercase hover:bg-gray-50 hover:text-[#006738] font-medium text-gray-700 py-3 px-4 rounded-md transition-all duration-200">
                Dashboard
            </a>
        @endauth
    </nav>

    <!-- Mobile Auth Buttons -->
    {{-- <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-gray-50 space-y-3">
        @auth
            <div class="text-center text-sm text-gray-600 mb-2">
                Welcome, {{ Auth::user()->name }}!
            </div>
            <a href="{{ route('profile.edit') }}" 
               onclick="closeMobileMenu()"
               class="block w-full text-center px-4 py-2 text-gray-600 hover:text-gray-800 font-medium border border-gray-300 rounded-full hover:bg-gray-100 transition-all duration-200">
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" 
                        class="block w-full text-center px-4 py-2 bg-red-100 text-red-600 font-medium rounded-full hover:bg-red-200 transition-all duration-200">
                    Log Out
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" 
               onclick="closeMobileMenu()"
               class="block w-full text-center px-4 py-2 text-gray-600 hover:text-gray-800 font-medium border border-gray-300 rounded-full hover:bg-gray-100 transition-all duration-200">
                Log In
            </a>
            <a href="{{ route('register') }}" 
               onclick="closeMobileMenu()"
               class="block w-full text-center px-4 py-2 bg-[#00673833] text-[#006738] font-medium rounded-full hover:bg-[#006738] hover:text-white transition-all duration-200">
                Sign Up
            </a>
        @endauth
    </div> --}}
</div>

<!-- JavaScript for Mobile Menu -->
<script>
    function toggleMobileMenu() {
        const overlay = document.getElementById('mobile-overlay');
        const menu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        const isOpen = !menu.classList.contains('translate-x-full');

        if (isOpen) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    }

    function openMobileMenu() {
        const overlay = document.getElementById('mobile-overlay');
        const menu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        overlay.classList.remove('opacity-0', 'invisible');
        overlay.classList.add('opacity-100', 'visible');

        menu.classList.remove('translate-x-full');
        menu.classList.add('translate-x-0');

        menuIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');

        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        const overlay = document.getElementById('mobile-overlay');
        const menu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        overlay.classList.add('opacity-0', 'invisible');
        overlay.classList.remove('opacity-100', 'visible');

        menu.classList.add('translate-x-full');
        menu.classList.remove('translate-x-0');

        closeIcon.classList.add('hidden');
        menuIcon.classList.remove('hidden');

        // Restore body scroll
        document.body.style.overflow = '';
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobile-menu');
        const button = event.target.closest('[onclick="toggleMobileMenu()"]');

        if (!menu.contains(event.target) && !button) {
            closeMobileMenu();
        }
    });
</script>
