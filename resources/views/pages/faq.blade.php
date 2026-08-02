@extends('layouts.app')

@section('title', "Frequently Asked Questions | Bloom & Glow Mbita")

@section('content')
<!-- Hero Section -->
<section class="bg-white text-gray-900 overflow-hidden py-16 lg:py-24 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-50 border border-purple-200 text-purple-800 text-xs sm:text-sm font-medium mb-6">
                <i data-lucide="help-circle" class="w-4 h-4 text-purple-600"></i>
                <span>Got Questions? We've Got Answers</span>
            </span>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-['Outfit'] tracking-tight leading-tight text-gray-900 mb-6">
                Frequently Asked <span class="text-purple-800">Questions</span>
            </h1>
            
            <p class="text-lg text-gray-600 max-w-2xl mx-auto font-['Plus_Jakarta_Sans'] leading-relaxed">
                Find clear details about our booking process, slot reservations, working hours, and services at our Mbita branch.
            </p>
        </div>
    </div>
</section>

<!-- FAQ Accordion Section -->
<section class="py-16 lg:py-24 bg-gray-50/50" x-data="{ activeAccordion: 1 }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-4" data-aos="fade-up">

            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all">
                <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="font-bold font-['Outfit'] text-gray-900 text-lg">How do I book an appointment slot?</span>
                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-900 transition-transform duration-300" :class="{ 'rotate-180': activeAccordion === 1 }">
                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                    </div>
                </button>
                <div x-show="activeAccordion === 1" x-cloak class="px-6 pb-6 text-gray-600 font-['Plus_Jakarta_Sans'] text-sm leading-relaxed border-t border-gray-100 pt-4">
                    You can easily book online through our custom booking page by selecting your preferred service, date, and specific time slot. This instantly locks in your reservation with zero waiting queues when you arrive.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all">
                <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="font-bold font-['Outfit'] text-gray-900 text-lg">Where is the Bloom & Glow Mbita branch located?</span>
                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-900 transition-transform duration-300" :class="{ 'rotate-180': activeAccordion === 2 }">
                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                    </div>
                </button>
                <div x-show="activeAccordion === 2" x-cloak class="px-6 pb-6 text-gray-600 font-['Plus_Jakarta_Sans'] text-sm leading-relaxed border-t border-gray-100 pt-4">
                    Our branch is conveniently situated along the Mbita-Homa Bay Highway, right near Ayman Supermarket in Mbita, Homa Bay County.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all">
                <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="font-bold font-['Outfit'] text-gray-900 text-lg">What are your working hours?</span>
                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-900 transition-transform duration-300" :class="{ 'rotate-180': activeAccordion === 3 }">
                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                    </div>
                </button>
                <div x-show="activeAccordion === 3" x-cloak class="px-6 pb-6 text-gray-600 font-['Plus_Jakarta_Sans'] text-sm leading-relaxed border-t border-gray-100 pt-4">
                    We are open from Monday to Saturday between 8:00 AM and 7:00 PM, and on Sundays from 10:00 AM to 6:00 PM to accommodate your schedule.
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all">
                <button @click="activeAccordion = activeAccordion === 4 ? null : 4" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="font-bold font-['Outfit'] text-gray-900 text-lg">Can I walk in without an online reservation?</span>
                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-900 transition-transform duration-300" :class="{ 'rotate-180': activeAccordion === 4 }">
                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                    </div>
                </button>
                <div x-show="activeAccordion === 4" x-cloak class="px-6 pb-6 text-gray-600 font-['Plus_Jakarta_Sans'] text-sm leading-relaxed border-t border-gray-100 pt-4">
                    While walk-ins are welcome depending on stylist availability, we strongly recommend booking online in advance to secure your preferred time slot and guarantee dedicated care.
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden transition-all">
                <button @click="activeAccordion = activeAccordion === 5 ? null : 5" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="font-bold font-['Outfit'] text-gray-900 text-lg">What services do you offer?</span>
                    <div class="w-8 h-8 rounded-full bg-purple-50 flex items-center justify-center text-purple-900 transition-transform duration-300" :class="{ 'rotate-180': activeAccordion === 5 }">
                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                    </div>
                </button>
                <div x-show="activeAccordion === 5" x-cloak class="px-6 pb-6 text-gray-600 font-['Plus_Jakarta_Sans'] text-sm leading-relaxed border-t border-gray-100 pt-4">
                    We offer a comprehensive range of professional beauty and grooming services including luxury hair wash and styling, manicures and nail care, and precision grooming for both men and women.
                </div>
            </div>

        </div>

        <!-- Still have questions CTA -->
        <div class="mt-12 bg-white rounded-2xl border border-gray-200 p-8 text-center shadow-sm" data-aos="fade-up">
            <h3 class="text-xl font-bold font-['Outfit'] text-gray-900 mb-2">Still have questions?</h3>
            <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-sm mb-6">Reach out directly to our Mbita branch team and we'll be happy to assist you.</p>
            <a href="#" class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-6 py-3 rounded-xl transition-all shadow-sm text-sm">
                <i data-lucide="phone" class="w-4 h-4 text-purple-200"></i>
                <span>Contact Us</span>
            </a>
        </div>

    </div>
</section>
@endsection