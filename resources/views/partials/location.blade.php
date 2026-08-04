<!-- resources/views/partials/location.blade.php -->
<section class="py-16 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Location Details & Directions -->
            <div class="lg:col-span-5" data-aos="fade-right">
                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-md text-xs font-semibold uppercase tracking-wider mb-3">
                    Find Us in Mbita
                </span>
                <h2 class="text-3xl font-bold font-['Outfit'] text-gray-900 mb-4">
                    Your Sanctuary for Grooming & Beauty
                </h2>
                <p class="text-gray-600 font-['Plus_Jakarta_Sans'] mb-6 leading-relaxed">
                    Drop by for your scheduled sessions or walk in to explore our premium grooming and salon services right in the heart of Mbita.
                </p>

                <div class="space-y-4">
                    <!-- Address Card -->
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-800 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold font-['Outfit'] text-gray-900 text-base mb-1">Physical Location</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Junction Katol<br>
                                Next to Ayman Supermarket, Mbita.
                            </p>
                        </div>
                    </div>

                    <!-- Working Days Card -->
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-800 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold font-['Outfit'] text-gray-900 text-base mb-1">Working Days</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Monday, Tuesday, Wednesday, Thursday, Friday, and Sunday
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('book') }}" class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-6 py-3 rounded-lg shadow-sm transition-all text-sm">
                        <i data-lucide="calendar-check" class="w-4 h-4 text-purple-200"></i>
                        <span>Book Slot Before Visiting</span>
                    </a>
                </div>
            </div>

            <!-- Map / Visual Location Mockup Card -->
            <div class="lg:col-span-7" data-aos="fade-left">
                <div class="bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 shadow-sm p-3 sm:p-4">
                    <div class="relative w-full h-[380px] rounded-xl overflow-hidden bg-purple-950 flex flex-col items-center justify-center text-center p-6 text-white">
                        <!-- Decorative Map Background Styling Overlay -->
                        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#e9d5ff_1px,transparent_1px)] [background-size:20px_20px]"></div>
                        
                        <div class="relative z-10 max-w-md space-y-4">
                            <div class="w-14 h-14 rounded-full bg-purple-900 border border-purple-500/40 text-pink-300 flex items-center justify-center mx-auto shadow-lg">
                                <i data-lucide="navigation" class="w-7 h-7"></i>
                            </div>
                            <h3 class="text-xl font-bold font-['Outfit']">Bloom & Glow Mbita Branch</h3>
                            <p class="text-purple-200 text-sm font-['Plus_Jakarta_Sans'] leading-relaxed">
                                Conveniently located at Junction Katol, adjacent to Ayman Supermarket for easy accessibility and secure parking.
                            </p>
                            <div class="pt-2">
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white/10 backdrop-blur-md text-xs font-medium border border-white/20 text-white">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-pink-300"></i>
                                    Junction Katol, Next to Ayman Supermarket
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>