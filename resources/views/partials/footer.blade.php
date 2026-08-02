<footer class="bg-gray-900 text-gray-300 pt-16 pb-12 border-t border-purple-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10">
        
        <!-- Col 1: Brand Info -->
        <div class="space-y-4">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('images/bloom-and-gloom-logo.png') }}" alt="Logo" class="h-8 w-auto brightness-200">
                <h3 class="text-xl font-bold text-white font-heading">Bloom <span class="text-purple-400">&</span> Glow</h3>
            </div>
            <p class="text-sm text-gray-400 leading-relaxed">
                Your premier sanctuary for professional hair care, rejuvenating facials, soothing massages, and expert grooming designed for everyone.
            </p>
        </div>

        <!-- Col 2: Quick Links -->
        <div>
            <h4 class="text-sm font-semibold text-white tracking-wider uppercase mb-4 font-heading">Quick Links</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ url('/services') }}" class="hover:text-purple-400 transition">Our Services</a></li>
                <li><a href="{{ url('/book') }}" class="hover:text-purple-400 transition">Book a Slot</a></li>
                <li><a href="{{ url('/about') }}" class="hover:text-purple-400 transition">About Studio</a></li>
                <li><a href="{{ url('/contact') }}" class="hover:text-purple-400 transition">Get in Touch</a></li>
            </ul>
        </div>

        <!-- Col 3: Specialties -->
        <div>
            <h4 class="text-sm font-semibold text-white tracking-wider uppercase mb-4 font-heading">Specialties</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li>Hair Care & Styling</li>
                <li>Facials & Skin Care</li>
                <li>Nails & Hand/Foot Care</li>
                <li>Massage & Body Treatments</li>
                <li>Men’s Grooming</li>
            </ul>
        </div>

        <!-- Col 4: Opening Hours -->
        <div>
            <h4 class="text-sm font-semibold text-white tracking-wider uppercase mb-4 font-heading">Opening Hours</h4>
            <p class="text-sm text-gray-400 mb-2">Monday – Saturday: 8:00 AM – 8:00 PM</p>
            <p class="text-sm text-gray-400">Sunday: 10:00 AM – 6:00 PM</p>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} Bloom & Glow. All rights reserved.
    </div>
</footer>