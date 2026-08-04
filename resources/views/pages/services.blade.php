@extends('layouts.app')

@section('title', "Our Services | Bloom & Glow Mbita")

@section('content')
<!-- Page Header -->
<section class="bg-purple-900 text-white py-16 lg:py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#e9d5ff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-800/85 border border-purple-700 text-purple-200 text-xs sm:text-sm font-medium mb-4">
            <i data-lucide="sparkles" class="w-4 h-4 text-purple-300"></i>
            <span>Professional Grooming & Styling Menu</span>
        </span>
        <h1 class="text-4xl sm:text-5xl font-bold font-['Outfit'] tracking-tight mb-4">
            Our Complete Service Menu
        </h1>
        <p class="text-purple-200 font-['Plus_Jakarta_Sans'] text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
            Ensure excellence in your personal appearance. Choose from our expertly curated selection of professional hair, skin, nail, and grooming treatments in Mbita.
        </p>
    </div>
</section>

<!-- Services Directory Section with Service-Oriented Grouping -->
<section class="py-16 bg-gray-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Category Filter Pills -->
        <div class="sticky top-20 z-30 bg-gray-50/90 backdrop-blur-md py-4 mb-12 border-b border-gray-200" data-aos="fade-up">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Jump to Category:</span>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <a href="#hair-studio" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-purple-900 text-sm font-semibold hover:bg-purple-900 hover:text-white hover:border-purple-900 transition-all shadow-sm">
                        Hair Studio & Styling
                    </a>
                    <a href="#grooming-maintenance" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-purple-900 text-sm font-semibold hover:bg-purple-900 hover:text-white hover:border-purple-900 transition-all shadow-sm">
                        Grooming & Maintenance
                    </a>
                    <a href="#nail-hand-foot" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-purple-900 text-sm font-semibold hover:bg-purple-900 hover:text-white hover:border-purple-900 transition-all shadow-sm">
                        Hand & Foot Care
                    </a>
                    <a href="#skin-treatments" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-purple-900 text-sm font-semibold hover:bg-purple-900 hover:text-white hover:border-purple-900 transition-all shadow-sm">
                        Skin & Facial Treatments
                    </a>
                </div>
            </div>
        </div>

        <div class="space-y-20">
            
            <!-- CATEGORY 1: HAIR STUDIO & STYLING -->
            <div id="hair-studio" class="scroll-mt-32" data-aos="fade-up">
                <div class="bg-purple-900/5 border border-purple-200 rounded-2xl p-6 sm:p-8 mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-900 text-white flex items-center justify-center shadow-sm">
                            <i data-lucide="scissors" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-widest text-purple-800">Professional Studio</span>
                            <h2 class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">Hair Studio & Styling</h2>
                        </div>
                    </div>
                    <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm sm:text-base max-w-3xl">
                        Expert cuts, custom textures, vibrant coloring, and precision styling tailored to keep your hair looking pristine.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Service Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-lg">Precision Hair Styling & Dye</h3>
                                <span class="bg-purple-50 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded">Popular</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Professional hair treatments, custom cuts, and vibrant coloring execution tailored to your preference.</p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">Hair Studio</span>
                            <a href="{{ route('book') }}" class="text-sm font-semibold text-purple-900 hover:text-purple-700 inline-flex items-center gap-1">
                                Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Service Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-lg">Custom Cuts & Modern Fades</h3>
                                <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-1 rounded">Essential</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Clean fades, classic trims, or modern custom cuts executed with elite professional precision.</p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">Hair Studio</span>
                            <a href="{{ route('book') }}" class="text-sm font-semibold text-purple-900 hover:text-purple-700 inline-flex items-center gap-1">
                                Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CATEGORY 2: GROOMING & MAINTENANCE -->
            <div id="grooming-maintenance" class="scroll-mt-32" data-aos="fade-up">
                <div class="bg-gray-900/5 border border-gray-200 rounded-2xl p-6 sm:p-8 mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-gray-900 text-white flex items-center justify-center shadow-sm">
                            <i data-lucide="sparkles" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-widest text-gray-700">Detailed Maintenance</span>
                            <h2 class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">Grooming & Maintenance</h2>
                        </div>
                    </div>
                    <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm sm:text-base max-w-3xl">
                        Targeted facial hair upkeep, soothing hot towel treatments, and deep cleansing care designed for complete refreshment.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Service Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-lg">Beard Trim & Hot Towel Treatment</h3>
                                <span class="bg-purple-50 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded">Popular</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Sharp line-ups, relaxing hot towel treatments, and soothing beard conditioning care.</p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">Beard Care</span>
                            <a href="{{ route('book') }}" class="text-sm font-semibold text-purple-900 hover:text-purple-700 inline-flex items-center gap-1">
                                Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Service Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-lg">Deep Scalp & Hair Steaming</h3>
                                <span class="bg-purple-50 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded">Relaxing</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Opens hair cuticles for maximum nutrient absorption, locking in essential moisture and total relief.</p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">Rejuvenation</span>
                            <a href="{{ route('book') }}" class="text-sm font-semibold text-purple-900 hover:text-purple-700 inline-flex items-center gap-1">
                                Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Service Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-lg">Shampoo & Scalp Massage Wash</h3>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Thorough cleansing to clear product buildup, paired with an invigorating and relaxing scalp massage.</p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">Hair Care</span>
                            <a href="{{ route('book') }}" class="text-sm font-semibold text-purple-900 hover:text-purple-700 inline-flex items-center gap-1">
                                Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CATEGORY 3: HAND & FOOT CARE -->
            <div id="nail-hand-foot" class="scroll-mt-32" data-aos="fade-up">
                <div class="bg-purple-50/60 border border-purple-200 rounded-2xl p-6 sm:p-8 mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-200 text-purple-900 flex items-center justify-center shadow-sm">
                            <i data-lucide="heart" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-widest text-purple-800">Wellness & Care</span>
                            <h2 class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">Hand & Foot Care</h2>
                        </div>
                    </div>
                    <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm sm:text-base max-w-3xl">
                        Immaculate nail shaping, deep skin scrubbing, and restorative hand and foot care treatments.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Service Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-lg">Immaculate Manicure</h3>
                                <span class="bg-purple-50 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded">Nail Care</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Precision nail shaping, professional cuticle maintenance, and flawless polish application.</p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">Hand Wellness</span>
                            <a href="{{ route('book') }}" class="text-sm font-semibold text-purple-900 hover:text-purple-700 inline-flex items-center gap-1">
                                Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Service Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-lg">Luxurious Pedicure</h3>
                                <span class="bg-purple-50 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded">Foot Care</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Deep scrubbing, smoothing, soothing foot soak, and immaculate nail grooming.</p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">Foot Wellness</span>
                            <a href="{{ route('book') }}" class="text-sm font-semibold text-purple-900 hover:text-purple-700 inline-flex items-center gap-1">
                                Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CATEGORY 4: SKIN & FACIAL TREATMENTS -->
            <div id="skin-treatments" class="scroll-mt-32" data-aos="fade-up">
                <div class="bg-purple-900/5 border border-purple-200 rounded-2xl p-6 sm:p-8 mb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-purple-900 text-white flex items-center justify-center shadow-sm">
                            <i data-lucide="droplet" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-widest text-purple-800">Advanced Care</span>
                            <h2 class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-gray-900">Skin & Facial Treatments</h2>
                        </div>
                    </div>
                    <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm sm:text-base max-w-3xl">
                        Specialized skin purifying protocols, deep cleansing facial treatments, and custom therapy sessions open to all clients.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Service Card -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex flex-col justify-between hover:border-purple-300 transition-all">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold font-['Outfit'] text-gray-900 text-lg">Refreshing Facial Treatment</h3>
                                <span class="bg-purple-50 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded">Glowing Skin</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">Deep cleansing, professional exfoliation, and custom hydrating masks to restore complete facial radiance.</p>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs text-gray-500 font-medium">Skin Therapy</span>
                            <a href="{{ route('book') }}" class="text-sm font-semibold text-purple-900 hover:text-purple-700 inline-flex items-center gap-1">
                                Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Call To Action Section -->
<section class="py-16 bg-white border-t border-gray-200 text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
        <h2 class="text-3xl font-bold font-['Outfit'] text-gray-900 mb-4">
            Ensure Excellence — <span class="text-purple-800 italic">Trust Bloom & Glow!</span>
        </h2>
        <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-base mb-8 max-w-xl mx-auto">
            Ready to experience dedicated personal care? Select your preferred service and secure your appointment slot instantly online.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('book') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3.5 rounded-lg shadow-sm transition-all text-base">
                <i data-lucide="calendar-check" class="w-5 h-5 text-purple-200"></i>
                <span>Book Your Slot Today</span>
            </a>
            <a href="{{ url('/') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-8 py-3.5 rounded-lg transition-all text-base">
                <i data-lucide="home" class="w-5 h-5 text-gray-600"></i>
                <span>Back to Home</span>
            </a>
        </div>
    </div>
</section>
@endsection