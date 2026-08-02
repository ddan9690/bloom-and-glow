@extends('layouts.app')

@section('title', "About Us | Bloom & Glow Mbita")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-16 lg:py-24 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-6">
                <i data-lucide="sparkles" class="w-4 h-4 text-purple-600"></i>
                <span>Our Story & Mission</span>
            </span>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-['Outfit'] tracking-tight leading-tight text-gray-900 mb-6">
                Redefining Beauty & Wellness in <span class="text-purple-800">Mbita</span>
            </h1>
            
            <p class="text-lg text-gray-600 max-w-2xl mx-auto font-['Plus_Jakarta_Sans'] leading-relaxed">
                Nestled along the Mbita-Homa Bay Highway near Ayman Supermarket, Bloom & Glow is your premier sanctuary dedicated to relaxation, rejuvenation, and precision aesthetic care.
            </p>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-16 lg:py-20 bg-gray-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            
            <!-- Mission Card -->
            <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute top-0 left-0 w-2 h-full bg-purple-900"></div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-900 mb-6">
                    <i data-lucide="target" class="w-6 h-6"></i>
                </div>
                <h2 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-4">Our Mission</h2>
                <p class="text-gray-600 font-['Plus_Jakarta_Sans'] leading-relaxed">
                    To provide exceptional, personalized beauty and wellness treatments using top-tier products and professional techniques, ensuring every client leaves feeling confident, radiant, and valued.
                </p>
            </div>

            <!-- Vision Card -->
            <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute top-0 left-0 w-2 h-full bg-purple-900"></div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-900 mb-6">
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
                </div>
                <h2 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-4">Our Vision</h2>
                <p class="text-gray-600 font-['Plus_Jakarta_Sans'] leading-relaxed">
                    To be the leading standard of modern self-care and professional styling across Homa Bay County, known for our warm hospitality, impeccable hygiene standards, and consistent excellence.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Location & Environment Section -->
<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div data-aos="fade-right">
                <span class="text-purple-900 font-semibold text-sm uppercase tracking-wider mb-3 block font-['Outfit']">The Experience</span>
                <h2 class="text-3xl font-bold font-['Outfit'] text-gray-900 mb-6">
                    A Tranquil Space Designed For Your Comfort
                </h2>
                <p class="text-gray-600 font-['Plus_Jakarta_Sans'] leading-relaxed mb-6">
                    From the moment you walk through our doors, our serene atmosphere washes away the fatigue of the day. We have carefully curated our environment to provide a peaceful getaway where you can unwind while our expert stylists and technicians attend to your every need.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-purple-50 flex items-center justify-center text-purple-900 flex-shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <p class="text-sm text-gray-700 font-['Plus_Jakarta_Sans']"><strong class="font-semibold text-gray-900">Prime Location:</strong> Easily accessible along the Mbita-Homa Bay Highway, conveniently situated near Ayman Supermarket.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-purple-50 flex items-center justify-center text-purple-900 flex-shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <p class="text-sm text-gray-700 font-['Plus_Jakarta_Sans']"><strong class="font-semibold text-gray-900">Expert Team:</strong> Highly trained beauty specialists dedicated to safe, high-quality care.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-purple-50 flex items-center justify-center text-purple-900 flex-shrink-0 mt-0.5">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <p class="text-sm text-gray-700 font-['Plus_Jakarta_Sans']"><strong class="font-semibold text-gray-900">Instant Slot Locking:</strong> Utilize our custom online system to secure your appointment schedule instantly with zero waiting queues.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-8 border border-gray-200 text-center flex flex-col justify-center items-center min-h-[350px]" data-aos="fade-left">
                <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-900 mb-4">
                    <i data-lucide="map-pin" class="w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold font-['Outfit'] text-gray-900 mb-2">Mbita Branch</h3>
                <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm max-w-xs mb-6">Mbita-Homa Bay Highway<br>Near Ayman Supermarket</p>
                <a href="#" class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white text-sm font-medium px-6 py-3 rounded-xl transition-all shadow-sm">
                    <span>Book a Session Now</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Final Bottom CTA Section -->
<section class="py-16 bg-purple-50/50 text-gray-900 text-center border-t border-gray-200">
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
        </div>
    </div>
</section>
@endsection