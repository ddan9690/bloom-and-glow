<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | Bloom & Glow</title>
    
    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Laravel Vite Directive -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50/50 text-gray-900 font-['Plus_Jakarta_Sans'] antialiased min-h-screen flex items-center justify-center p-4 sm:p-6">

    <section class="w-full py-6 lg:py-12" x-data="{ showPassword: false, showConfirmPassword: false }">
        <div class="max-w-md w-full mx-auto">
            
            <!-- Top Navigation / Go Back Action -->
            <div class="mb-6 flex items-center justify-start" data-aos="fade-down">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-purple-900 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Back to Home</span>
                </a>
            </div>

            <!-- Register Card Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 sm:p-8" data-aos="fade-up">
                
                <!-- Heading -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">
                        Create Account
                    </h1>
                </div>

                <!-- Register Form -->
                <form action="#" method="POST" class="space-y-5">
                    @csrf

                    <!-- Full Name Input -->
                    <div>
                        <label for="name" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </div>
                            <input type="text" id="name" name="name" required autofocus
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                                placeholder="John Doe">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <input type="email" id="email" name="email" required
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                                placeholder="johndoe@gmail.com">
                        </div>
                    </div>

                    <!-- Password Input with Toggle -->
                    <div>
                        <label for="password" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="key" class="w-4 h-4"></i>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                                class="w-full pl-10 pr-12 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                                placeholder="••••••••">
                            
                            <!-- Toggle Button -->
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-purple-900 transition-colors focus:outline-none">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password Input with Toggle -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="key" class="w-4 h-4"></i>
                            </div>
                            <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                                class="w-full pl-10 pr-12 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                                placeholder="••••••••">
                            
                            <!-- Toggle Button -->
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-purple-900 transition-colors focus:outline-none">
                                <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showConfirmPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3.5 rounded-xl shadow-sm transition-all text-base">
                            <i data-lucide="user-plus" class="w-5 h-5 text-purple-200"></i>
                            <span>Create Account</span>
                        </button>
                    </div>

                </form>

                <!-- Footer Link (Already have an account?) -->
                <div class="mt-8 text-center border-t border-gray-100 pt-6">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-bold text-purple-900 hover:underline">Login here</a>
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Initialize Lucide Icons & AOS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    once: true,
                });
            }
        });
    </script>
</body>
</html>