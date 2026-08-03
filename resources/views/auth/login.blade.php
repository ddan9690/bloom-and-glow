<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bloom & Glow</title>

    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Laravel Vite Directive -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-gray-50/50 text-gray-900 font-['Plus_Jakarta_Sans'] antialiased min-h-screen flex items-center justify-center p-4 sm:p-6">

    <section class="w-full py-6 lg:py-12" x-data="{ showPassword: false }">
        <div class="max-w-md w-full mx-auto">

            <!-- Top Navigation / Go Back Action -->
            <div class="mb-6 flex items-center justify-start" data-aos="fade-down">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-purple-900 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Back to Home</span>
                </a>
            </div>

            <!-- Login Card Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 sm:p-8"
                data-aos="fade-up">

                <!-- Brand Logo & Heading -->
                <div class="text-center mb-8 flex flex-col items-center">
                    <a href="{{ url('/') }}" class="inline-block mb-4">
                        <img src="{{ asset('images/bloom-and-gloom-logo.png') }}" alt="Bloom & Glow Logo" class="h-14 sm:h-16 w-auto object-contain bg-transparent">
                    </a>
                    <h1 class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">
                        Login
                    </h1>
                </div>

                <!-- Validation Errors Alert -->
                @if ($errors->any())
                    <div
                        class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Phone Number Input -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="phone" class="w-4 h-4"></i>
                            </div>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                autofocus
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                                placeholder="0712345678">
                        </div>
                    </div>

                    <!-- Password Input with Toggle -->
                    <div>
                        <label for="password" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="key" class="w-4 h-4"></i>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                                class="w-full pl-10 pr-12 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                                placeholder="••••••••">

                            <!-- Toggle Button with Dynamic Icon -->
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-purple-900 transition-colors focus:outline-none">
                                <i :data-lucide="showPassword ? 'eye-off' : 'eye'" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-sm pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="rounded border-gray-300 text-purple-900 focus:ring-purple-800 w-4 h-4">
                            <span class="text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="font-medium text-purple-900 hover:text-purple-800 transition-colors">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3.5 rounded-xl shadow-sm transition-all text-base">
                            <i data-lucide="log-in" class="w-5 h-5 text-purple-200"></i>
                            <span>Login</span>
                        </button>
                    </div>

                </form>

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