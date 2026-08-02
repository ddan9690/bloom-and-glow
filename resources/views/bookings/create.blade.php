@extends('layouts.app')

@section('title', 'Book Your Appointment | Bloom & Glow Mbita')

@section('content')
<section class="py-12 lg:py-16 bg-gray-50/50 min-h-[85vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Navigation / Go Back Action -->
        <div class="mb-6 flex items-center justify-between" data-aos="fade-down">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-purple-900 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Go Back Home</span>
            </a>
            
            <span class="text-xs text-gray-500 font-medium">
                Bloom & Glow • Mbita Branch
            </span>
        </div>

        <!-- Page Header -->
        <div class="text-center max-w-2xl mx-auto mb-10" data-aos="fade-up">
            <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-md text-xs font-semibold uppercase tracking-wider mb-3">
                Instant Slot Reservation
            </span>
            <h1 class="text-3xl sm:text-4xl font-bold font-['Outfit'] text-gray-900 mb-3">
                Reserve Your Session at Bloom & Glow
            </h1>
            <p class="text-gray-600 font-['Plus_Jakarta_Sans'] text-base">
                Fill out the quick details below to lock in your guaranteed time slot at our Mbita branch. No waiting queues.
            </p>
        </div>

        <!-- Booking Form Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            
            <div 
                x-data="{
                    category: '',
                    service: '',
                    selectedDate: '',
                    showCalendar: false,
                    currentMonth: new Date().getMonth(),
                    currentYear: new Date().getFullYear(),
                    
                    services: {
                        'hair': [
                            { id: 'wash-styling', name: 'Luxury Wash & Styling', price: 'KSh 800', duration: '45 mins' },
                            { id: 'braiding', name: 'Professional Braiding', price: 'KSh 2,500', duration: '3 hrs' },
                            { id: 'treatment', name: 'Deep Hair Treatment', price: 'KSh 1,200', duration: '1 hr' }
                        ],
                        'nails': [
                            { id: 'manicure', name: 'Immaculate Manicure', price: 'KSh 1,000', duration: '45 mins' },
                            { id: 'pedicure', name: 'Relaxing Pedicure', price: 'KSh 1,200', duration: '1 hr' },
                            { id: 'gel-polish', name: 'Gel Polish Application', price: 'KSh 1,500', duration: '1 hr' }
                        ],
                        'grooming': [
                            { id: 'cut-shave', name: 'Precision Cut & Beard Trim', price: 'KSh 600', duration: '30 mins' },
                            { id: 'full-groom', name: 'Complete Executive Grooming', price: 'KSh 1,200', duration: '1 hr' }
                        ]
                    },

                    get availableServices() {
                        return this.services[this.category] || [];
                    },

                    selectedServiceDetails() {
                        if (!this.service) return null;
                        for (let cat in this.services) {
                            let found = this.services[cat].find(s => s.id === this.service);
                            if (found) return found;
                        }
                        return null;
                    },

                    get monthName() {
                        return new Date(this.currentYear, this.currentMonth).toLocaleString('default', { month: 'long', year: 'numeric' });
                    },
                    
                    get daysInMonth() {
                        return new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                    },
                    
                    get firstDayIndex() {
                        return new Date(this.currentYear, this.currentMonth, 1).getDay();
                    },

                    selectDate(day) {
                        let formattedMonth = String(this.currentMonth + 1).padStart(2, '0');
                        let formattedDay = String(day).padStart(2, '0');
                        this.selectedDate = `${this.currentYear}-${formattedMonth}-${formattedDay}`;
                        this.showCalendar = false;
                    }
                }"
                class="p-6 sm:p-10"
            >
                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <!-- Personal Information Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                </div>
                                <input type="text" id="name" name="name" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm font-['Plus_Jakarta_Sans'] text-gray-900 bg-gray-50/50"
                                    placeholder="e.g. Brenda Akinyi">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                                Phone <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="phone" class="w-4 h-4"></i>
                                </div>
                                <input type="tel" id="phone" name="phone" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm font-['Plus_Jakarta_Sans'] text-gray-900 bg-gray-50/50"
                                    placeholder="e.g. 0712345678">
                            </div>
                        </div>
                    </div>

                    <!-- Service Selection Grid (Dynamic Alpine Dropdowns) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                        <!-- Category Dropdown -->
                        <div>
                            <label for="category" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                                Service Category <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="layers" class="w-4 h-4"></i>
                                </div>
                                <select id="category" name="category" x-model="category" @change="service = ''" required
                                    class="w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm font-['Plus_Jakarta_Sans'] text-gray-900 bg-gray-50/50 appearance-none">
                                    <option value="" disabled selected>Select category...</option>
                                    <option value="hair">Hair Care & Styling</option>
                                    <option value="nails">Nail Studio</option>
                                    <option value="grooming">Precision Grooming</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Specific Service Dropdown -->
                        <div>
                            <label for="service" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                                Specific Service <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="scissors" class="w-4 h-4"></i>
                                </div>
                                <select id="service" name="service" x-model="service" :disabled="!category" required
                                    class="w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm font-['Plus_Jakarta_Sans'] text-gray-900 bg-gray-50/50 appearance-none disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed">
                                    <option value="" disabled selected>Choose category first...</option>
                                    <template x-for="item in availableServices" :key="item.id">
                                        <option :value="item.id" x-text="item.name + ' (' + item.price + ')'"></option>
                                    </template>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Service Meta Preview Box -->
                    <template x-if="selectedServiceDetails()">
                        <div class="p-4 rounded-xl bg-purple-50 border border-purple-200 flex flex-wrap items-center justify-between gap-4 text-sm animate-fadeIn">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-purple-900 text-white flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 font-['Outfit']" x-text="selectedServiceDetails().name"></p>
                                    <p class="text-xs text-gray-600">Estimated duration: <span class="font-semibold text-purple-900" x-text="selectedServiceDetails().duration"></span></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500 block">Estimated Cost</span>
                                <span class="text-base font-bold font-['Outfit'] text-purple-900" x-text="selectedServiceDetails().price"></span>
                            </div>
                        </div>
                    </template>

                    <!-- Date and Time Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Custom Custom Styled Alpine.js Calendar Picker Dropdown -->
                        <div class="relative">
                            <label class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                                Preferred Date <span class="text-red-500">*</span>
                            </label>
                            
                            <!-- Trigger Input Box -->
                            <div @click="showCalendar = !showCalendar" class="relative cursor-pointer">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                </div>
                                <input type="text" readonly x-model="selectedDate" name="preferred_date" required
                                    class="w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm font-['Plus_Jakarta_Sans'] text-gray-900 bg-gray-50/50 cursor-pointer"
                                    placeholder="Select appointment date...">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>

                            <!-- Custom Popup Calendar Grid Card -->
                            <div x-show="showCalendar" @click.away="showCalendar = false" 
                                 class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-200 p-4 font-['Plus_Jakarta_Sans']">
                                
                                <!-- Header Controls -->
                                <div class="flex items-center justify-between mb-4">
                                    <button type="button" @click="currentMonth === 0 ? (currentMonth = 11, currentYear--) : currentMonth--" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-600 transition-colors">
                                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                                    </button>
                                    <span class="font-bold font-['Outfit'] text-gray-900 text-sm" x-text="monthName"></span>
                                    <button type="button" @click="currentMonth === 11 ? (currentMonth = 0, currentYear++) : currentMonth++" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-600 transition-colors">
                                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                    </button>
                                </div>

                                <!-- Weekday Labels -->
                                <div class="grid grid-cols-7 gap-1 text-center text-xs font-semibold text-gray-400 mb-2">
                                    <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
                                </div>

                                <!-- Days Grid -->
                                <div class="grid grid-cols-7 gap-1 text-center text-sm">
                                    <!-- Blank offsets for start of month -->
                                    <template x-for="i in firstDayIndex">
                                        <div></div>
                                    </template>

                                    <!-- Actual Days -->
                                    <template x-for="day in daysInMonth">
                                        <button type="button" 
                                            @click="selectDate(day)"
                                            :class="{'bg-purple-900 text-white font-bold': selectedDate === `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`}"
                                            class="h-9 w-9 mx-auto rounded-lg flex items-center justify-center transition-colors font-medium text-gray-700 hover:bg-purple-100 hover:text-purple-900"
                                            x-text="day">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Preferred Time Slot -->
                        <div>
                            <label for="preferred_time" class="block text-sm font-semibold font-['Outfit'] text-gray-900 mb-2">
                                Time Slot <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="clock" class="w-4 h-4"></i>
                                </div>
                                <select id="preferred_time" name="preferred_time" required
                                    class="w-full pl-10 pr-10 py-3 rounded-lg border border-gray-300 focus:border-purple-800 focus:ring-1 focus:ring-purple-800 text-sm font-['Plus_Jakarta_Sans'] text-gray-900 bg-gray-50/50 appearance-none">
                                    <option value="" disabled selected>Select time slot...</option>
                                    <option value="08:00">08:00 AM – 10:00 AM</option>
                                    <option value="10:00">10:00 AM – 12:00 PM</option>
                                    <option value="12:00">12:00 PM – 02:00 PM</option>
                                    <option value="14:00">02:00 PM – 04:00 PM</option>
                                    <option value="16:00">04:00 PM – 06:00 PM</option>
                                    <option value="18:00">06:00 PM – 08:00 PM</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location Trust Note -->
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 flex items-center gap-3 text-xs text-gray-600">
                        <i data-lucide="map-pin" class="w-4 h-4 text-purple-800 flex-shrink-0"></i>
                        <span>Branch Location: Along the Mbita-Homa Bay Highway, right next to Ayman Supermarket.</span>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex flex-col sm:flex-row items-center gap-4">
                        <button type="submit" class="w-full sm:flex-1 inline-flex items-center justify-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-4 rounded-xl shadow-sm transition-all text-base">
                            <i data-lucide="calendar-check" class="w-5 h-5 text-purple-200"></i>
                            <span>Book Now</span>
                        </button>
                        <a href="{{ url('/') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-4 rounded-xl transition-all text-sm text-center">
                            <span>Cancel & Return</span>
                        </a>
                    </div>
                    
                    <p class="text-center text-xs text-gray-500 mt-3 flex items-center justify-center gap-1.5 font-medium">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5 text-purple-700"></i>
                        Your appointment slot is immediately reserved upon confirmation.
                    </p>

                </form>
            </div>
        </div>

    </div>
</section>
@endsection