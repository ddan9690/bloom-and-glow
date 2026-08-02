@extends('layouts.app')

@section('title', "Bloom & Glow | Mbita's No. 1 Premium Beauty & Grooming")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-16 lg:py-24 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <!-- Hero Text Content -->
            <div class="lg:col-span-7 text-center lg:text-left" data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-6">
                    <i data-lucide="sparkles" class="w-4 h-4 text-purple-600"></i>
                    <span>Mbita’s Premier Sanctuary for Hair, Nails & Grooming</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-['Outfit'] tracking-tight leading-tight text-gray-900 mb-6">
                    Elevate Your Look, <br class="hidden sm:inline">
                    <span class="text-purple-800">
                        Embrace Your Glow.
                    </span>
                </h1>
                
                <p class="text-lg text-gray-600 max-w-2xl mx-auto lg:mx-0 font-['Plus_Jakarta_Sans'] mb-8 leading-relaxed">
                    Step into absolute luxury right here in Mbita. From precision cuts and vibrant styling to immaculate manicures, we reserve exclusive slots for guaranteed, personalized care tailored just for you.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-10">
                    <a href="#" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3.5 rounded-lg shadow-sm transition-all text-base">
                        <i data-lucide="calendar-check" class="w-5 h-5 text-purple-200"></i>
                        <span>Book Your Appointment Now</span>
                    </a>
                    
                    <a href="#" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-6 py-3.5 rounded-lg transition-all text-base">
                        <i data-lucide="grid" class="w-5 h-5 text-gray-600"></i>
                        <span>Explore Our Services</span>
                    </a>
                </div>

                <!-- Trust Metrics -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-200 max-w-lg mx-auto lg:mx-0">
                    <div>
                        <p class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-purple-900">100%</p>
                        <p class="text-xs sm:text-sm text-gray-500">Dedicated Care</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-purple-900">Instant</p>
                        <p class="text-xs sm:text-sm text-gray-500">Slot Locking</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-purple-900">Expert</p>
                        <p class="text-xs sm:text-sm text-gray-500">Stylists & Techs</p>
                    </div>
                </div>
            </div>

            <!-- Hero Image Grid -->
            <div class="lg:col-span-5 relative" data-aos="fade-left">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <div class="rounded-xl overflow-hidden shadow-md border border-gray-200 aspect-[4/5] bg-gray-100">
                        <img src="{{ asset('images/young-adult-man-getting-a-hair-and-beard-styling-and-dressing-treatment.jpg') }}" 
                             alt="Professional Grooming at Bloom & Glow Mbita" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-lg border border-gray-100 max-w-[220px] hidden sm:block">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-800 flex-shrink-0">
                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-900">Guaranteed Slot</p>
                                <p class="text-[11px] text-gray-500">Zero waiting queues</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Direct Booking Call-To-Action Banner -->
<section class="py-12 bg-purple-50/50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 text-center lg:text-left">
                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-md text-xs font-semibold uppercase tracking-wider mb-3">
                        Seamless & Convenient
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-bold font-['Outfit'] text-gray-900 mb-3">
                        Book from the Comfort of Your Home
                    </h2>
                    <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-base max-w-2xl leading-relaxed">
                        Skip the phone calls and long waits. Select your preferred service, lock in your exact time slot instantly, and let our specialists reserve maximum dedicated care exclusively for you.
                    </p>
                </div>

                <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col justify-center items-center gap-3">
                    <a href="#" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-6 py-3.5 rounded-lg shadow-sm transition-all text-center text-base">
                        <i data-lucide="calendar-plus" class="w-5 h-5 text-purple-200"></i>
                        <span>Start Your Booking</span>
                    </a>
                    <span class="text-xs text-gray-500 flex items-center gap-1.5 font-medium">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-purple-700"></i>
                        Takes less than 1 minute to secure your slot
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Services Snapshot Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12" data-aos="fade-up">
            <h2 class="text-xs sm:text-sm font-semibold text-purple-800 uppercase tracking-widest mb-2">Our Signature Offerings</h2>
            <h3 class="text-3xl font-bold font-['Outfit'] text-gray-900 mb-3">Designed for Your Ultimate Refresh</h3>
            <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-base">Experience professional grooming and styling treatments tailored to bring out your absolute best.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service Card 1 -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:border-purple-300 transition-all duration-300 group shadow-sm" data-aos="fade-up" data-aos-delay="100">
                <div class="h-56 overflow-hidden relative bg-gray-100">
                    <img src="{{ asset('images/a-woman-having-her-hair-washed-on-a-salon-sink.jpg') }}" alt="Hair Treatment" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded bg-white/90 text-gray-800 shadow-sm">Hair Care</span>
                </div>
                <div class="p-6">
                    <h4 class="text-lg font-bold font-['Outfit'] text-gray-900 mb-2">Luxury Wash & Styling</h4>
                    <p class="text-gray-600 text-sm mb-6 line-clamp-2">Revitalize your hair with deep-cleansing washes, professional treatments, and sleek styling designed to turn heads.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Professional Care</span>
                        <a href="#" class="inline-flex items-center gap-1 text-sm font-semibold text-purple-800 hover:text-purple-900">
                            Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service Card 2 -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:border-purple-300 transition-all duration-300 group shadow-sm" data-aos="fade-up" data-aos-delay="200">
                <div class="h-56 overflow-hidden relative bg-gray-100">
                    <img src="{{ asset('images/person-wearing-a-latex-gloves-doing-manicure.jpg') }}" alt="Manicure & Nails" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded bg-white/90 text-gray-800 shadow-sm">Nail Studio</span>
                </div>
                <div class="p-6">
                    <h4 class="text-lg font-bold font-['Outfit'] text-gray-900 mb-2">Immaculate Manicures</h4>
                    <p class="text-gray-600 text-sm mb-6 line-clamp-2">Precision nail care, expert polishing, and creative color palettes to give your hands a pristine, polished aesthetic.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Professional Care</span>
                        <a href="#" class="inline-flex items-center gap-1 text-sm font-semibold text-purple-800 hover:text-purple-900">
                            Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Service Card 3 -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:border-purple-300 transition-all duration-300 group shadow-sm" data-aos="fade-up" data-aos-delay="300">
                <div class="h-56 overflow-hidden relative bg-gray-100">
                    <img src="{{ asset('images/young-adult-man-getting-a-hair-and-beard-styling-and-dressing-treatment.jpg') }}" alt="Grooming" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded bg-white/90 text-gray-800 shadow-sm">Men & Women</span>
                </div>
                <div class="p-6">
                    <h4 class="text-lg font-bold font-['Outfit'] text-gray-900 mb-2">Precision Grooming</h4>
                    <p class="text-gray-600 text-sm mb-6 line-clamp-2">Sharp cuts, beard styling, and complete grooming treatments delivered with absolute precision and hygiene.</p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Professional Care</span>
                        <a href="#" class="inline-flex items-center gap-1 text-sm font-semibold text-purple-800 hover:text-purple-900">
                            Book Slot <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-10" data-aos="fade-up">
            <a href="#" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-6 py-3 rounded-lg transition-all text-sm">
                <span>View Complete Services List</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Bloom & Glow Section -->
<section class="py-16 bg-gray-50/50 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6" data-aos="fade-right">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="{{ asset('images/a-client-choosing-on-a-nail-color-palette.jpg') }}" alt="Client choosing color" class="rounded-xl shadow-sm border border-gray-200 w-full h-44 object-cover">
                        <img src="{{ asset('images/bloom-hand-nails.jpg') }}" alt="Bloom nails" class="rounded-xl shadow-sm border border-gray-200 w-full h-56 object-cover">
                    </div>
                    <div class="space-y-4 pt-6">
                        <img src="{{ asset('images/woman-getting-her-hair-shampoo.jpg') }}" alt="Hair shampoo" class="rounded-xl shadow-sm border border-gray-200 w-full h-56 object-cover">
                        <img src="{{ asset('images/a-woman-using-a-nail-file-while-polishing-nails-of-her-client.jpg') }}" alt="Nail polishing" class="rounded-xl shadow-sm border border-gray-200 w-full h-44 object-cover">
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6" data-aos="fade-left">
                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-md text-xs font-semibold uppercase tracking-wider mb-3">
                    The Bloom & Glow Difference
                </span>
                <h2 class="text-3xl font-bold font-['Outfit'] text-gray-900 mb-4">
                    Where Luxury Meets Personal Attention in Mbita
                </h2>
                <p class="text-gray-600 font-['Plus_Jakarta_Sans'] mb-8 leading-relaxed">
                    We believe beauty and grooming are deeply personal. That's why every visit to Bloom & Glow is structured around you—combining top-tier hygiene, modern equipment, experienced professionals, and guaranteed schedule reservation slots.
                </p>

                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-lg bg-purple-100 text-purple-800 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold font-['Outfit'] text-gray-900 text-base">Instant Slot Locking</h3>
                            <p class="text-gray-600 text-sm">When you book through our platform, your time is strictly reserved. No overbooking, no waiting around.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-lg bg-purple-100 text-purple-800 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="sparkles" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold font-['Outfit'] text-gray-900 text-base">Premium Products & Equipment</h3>
                            <p class="text-gray-600 text-sm">We use top-grade cosmetics, sanitization standards, and modern tools to guarantee flawless, lasting results.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-lg bg-purple-100 text-purple-800 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i data-lucide="heart" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold font-['Outfit'] text-gray-900 text-base">Inclusive & Welcoming Environment</h3>
                            <p class="text-gray-600 text-sm">A serene, comfortable space designed for both women and men seeking professional grooming excellence.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="#" class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-6 py-3 rounded-lg shadow-sm transition-all text-sm">
                        <span>Book Your Session Now</span>
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Location Section Partial Integration -->
@include('partials.location')

<!-- Final Bottom CTA Section -->
<section class="py-16 bg-white text-gray-900 text-center border-t border-gray-200">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
        <h2 class="text-3xl font-bold font-['Outfit'] mb-4 text-gray-900">Ready to Experience the Ultimate Glow?</h2>
        <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-base mb-8 max-w-xl mx-auto">
            Secure your appointment today and let Mbita's top beauty and grooming specialists treat you to unmatched dedicated care.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="#" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3.5 rounded-lg shadow-sm transition-all text-base">
                <i data-lucide="calendar-check" class="w-5 h-5 text-purple-200"></i>
                <span>Book Appointment Now</span>
            </a>
            <a href="#" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-8 py-3.5 rounded-lg transition-all text-base">
                <i data-lucide="map-pin" class="w-5 h-5 text-gray-600"></i>
                <span>Visit Us in Mbita</span>
            </a>
        </div>
    </div>
</section>
@endsection