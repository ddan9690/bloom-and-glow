@extends('layouts.app')

@section('title', "Contact Us | Bloom & Glow Mbita")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-16 lg:py-24 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-6">
                <i data-lucide="map-pin" class="w-4 h-4 text-purple-600"></i>
                <span>Get in Touch</span>
            </span>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-['Outfit'] tracking-tight leading-tight text-gray-900 mb-6">
                We'd Love to Hear From <span class="text-purple-800">You</span>
            </h1>
            
            <p class="text-lg text-gray-600 max-w-2xl mx-auto font-['Plus_Jakarta_Sans'] leading-relaxed">
                Have questions about our styling services or need assistance with your booking? Reach out to us or visit our Mbita branch directly.
            </p>
        </div>
    </div>
</section>

<!-- Contact Info & Form Section -->
<section class="py-16 lg:py-24 bg-gray-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Contact Details Card -->
            <div class="lg:col-span-5 space-y-6" data-aos="fade-right">
                <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm space-y-8">
                    <h2 class="text-2xl font-bold font-['Outfit'] text-gray-900">Mbita Branch Details</h2>

                    <div class="space-y-6">
                        <!-- Location -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-900 flex-shrink-0">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-base mb-1">Location</h3>
                                <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm leading-relaxed">
                                    Mbita-Homa Bay Highway<br>
                                    Conveniently near Ayman Supermarket<br>
                                    Mbita, Homa Bay County
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-900 flex-shrink-0">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-base mb-1">Phone Number</h3>
                                <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm">
                                    +254 712 345 678
                                </p>
                            </div>
                        </div>

                        <!-- Hours -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-900 flex-shrink-0">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-base mb-1">Working Hours</h3>
                                <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm">
                                    Monday – Saturday: 8:00 AM – 7:00 PM<br>
                                    Sunday: 10:00 AM – 6:00 PM
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100">
                        <a href="#" class="w-full inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-6 py-3.5 rounded-xl transition-all shadow-sm text-sm">
                            <i data-lucide="calendar-check" class="w-4 h-4 text-purple-200"></i>
                            <span>Book an Appointment Slot</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Message Form -->
            <div class="lg:col-span-7" data-aos="fade-left">
                <div class="bg-white p-8 sm:p-10 rounded-2xl border border-gray-200 shadow-sm">
                    <h2 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-2">Send Us a Message</h2>
                    <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm mb-8">
                        Fill out the form below and our team will get back to you promptly.
                    </p>

                    <form action="#" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                                    Your Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                    </div>
                                    <input type="text" id="name" name="name" required
                                        class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                                        placeholder="Brenda Akinyi">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i data-lucide="phone" class="w-4 h-4"></i>
                                    </div>
                                    <input type="tel" id="phone" name="phone" required
                                        class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none"
                                        placeholder="0712345678">
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
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
                                    placeholder="brenda@example.com">
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                                Your Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full p-4 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm text-gray-900 bg-gray-50/50 outline-none resize-none"
                                placeholder="How can we help you with your next styling session?"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3.5 rounded-xl shadow-sm transition-all text-base">
                                <i data-lucide="send" class="w-5 h-5 text-purple-200"></i>
                                <span>Send Message</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection