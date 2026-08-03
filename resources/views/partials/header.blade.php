<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-purple-100 shadow-xs">
    
    <!-- Optional Role-Based Top Context Bar -->
    @auth
    <div class="bg-purple-900 text-purple-100 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-9 flex items-center justify-between">
            <div class="flex items-center gap-3 font-medium">
                <span class="flex items-center gap-1 text-purple-300 uppercase tracking-wider text-[10px] font-bold">
                    <i data-lucide="shield" class="w-3 h-3"></i> Access:
                </span>
                <span class="text-white">{{ auth()->user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-purple-200 hover:text-white transition text-xs flex items-center gap-1">
                    <i data-lucide="log-out" class="w-3 h-3"></i> Logout
                </button>
            </form>
        </div>
    </div>
    @endauth

    <!-- Main Navigation Bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('images/bloom-and-gloom-logo.png') }}" alt="Bloom & Glow Logo" class="h-12 sm:h-14 w-auto object-contain block bg-transparent">
            <span class="text-xl font-bold tracking-tight text-gray-900 font-['Outfit']">
                Bloom <span class="text-purple-800">&</span> Glow
            </span>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-gray-600 font-['Plus_Jakarta_Sans']">
            <a href="{{ url('/') }}" class="hover:text-purple-800 transition">Home</a>
            <a href="{{ url('/about') }}" class="hover:text-purple-800 transition">About Us</a>
            <a href="{{ url('/faq') }}" class="hover:text-purple-800 transition">FAQ</a>
            <a href="{{ url('/contact') }}" class="hover:text-purple-800 transition">Contact</a>
        </nav>

        <!-- Right Action (Book Now or Auth) -->
        <div class="hidden md:flex items-center gap-3 font-['Plus_Jakarta_Sans']">
            @guest
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-purple-800 px-3 py-2 transition">
                    Sign In
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-purple-900 hover:text-purple-700 px-3 py-2 transition">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 px-3 py-2 transition">
                        Logout
                    </button>
                </form>
            @endguest
            <a href="{{ route('book') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-purple-900 text-white text-sm font-medium hover:bg-purple-800 transition shadow-sm shadow-purple-200">
                Book Now
            </a>
        </div>

        <!-- Mobile Menu Hamburger Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-gray-700 hover:text-purple-800 focus:outline-none" aria-label="Toggle Menu">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- Mobile Drawer Navigation -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="lg:hidden bg-white border-b border-purple-100 px-6 py-6 space-y-4 shadow-lg font-['Plus_Jakarta_Sans']">
        
        <div class="space-y-3 pb-4 border-b border-purple-50">
            <p class="text-xs font-bold uppercase tracking-wider text-purple-400 font-['Outfit']">Public Pages</p>
            <a href="{{ url('/') }}" class="block text-gray-700 font-medium hover:text-purple-800">Home</a>
            <a href="{{ url('/about') }}" class="block text-gray-700 font-medium hover:text-purple-800">About Us</a>
            <a href="{{ url('/faq') }}" class="block text-gray-700 font-medium hover:text-purple-800">FAQ</a>
            <a href="{{ url('/contact') }}" class="block text-gray-700 font-medium hover:text-purple-800">Contact</a>
        </div>

        <div class="pt-2 space-y-2">
            <a href="{{ route('book') }}" class="w-full text-center block px-5 py-3 rounded-xl bg-purple-900 text-white font-medium shadow-md shadow-purple-200 hover:bg-purple-800 transition">
                Book Now
            </a>
            @guest
                <a href="{{ route('login') }}" class="w-full text-center block px-5 py-2.5 rounded-xl bg-purple-50 text-purple-800 font-medium hover:bg-purple-100 transition">
                    Sign In
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="w-full text-center block px-5 py-2.5 rounded-xl bg-purple-50 text-purple-800 font-medium hover:bg-purple-100 transition">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-center block px-5 py-2.5 rounded-xl bg-red-50 text-red-700 font-medium hover:bg-red-100 transition">
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</header>