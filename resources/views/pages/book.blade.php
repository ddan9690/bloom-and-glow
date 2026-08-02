@extends('layouts.app')

@section('title', "Book Your Appointment | Bloom & Glow Mbita")

@section('content')
<!-- Booking Header Section -->
<section class="bg-purple-900 text-white py-12 lg:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#e9d5ff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-purple-800/80 border border-purple-700 text-purple-200 text-xs sm:text-sm font-medium mb-4">
            <i data-lucide="sparkles" class="w-4 h-4 text-purple-300"></i>
            <span>Guaranteed Instant Slot Reservation</span>
        </span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-['Outfit'] tracking-tight mb-4">
            Reserve Your Experience
        </h1>
        <p class="text-purple-200 text-sm sm:text-base max-w-2xl mx-auto font-['Plus_Jakarta_Sans']">
            Complete the steps below to secure your tailored session at Bloom & Glow Mbita. Zero waiting queues, absolute personal care.
        </p>
    </div>
</section>

<!-- Multi-Step Booking Form Section -->
<section class="py-12 lg:py-16 bg-gray-50/50 min-h-[600px]" 
    x-data="bookingForm()" 
    x-init="init()">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Display Server-side Flash / Validation Errors -->
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Successful!',
                        text: "{{ session('success') }}",
                        confirmButtonColor: '#581c87'
                    });
                });
            </script>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-sm">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i>
                    Please correct the errors below:
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Progress Indicator Bar -->
        <div class="mb-10 bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between relative">
                <!-- Progress Line Background -->
                <div class="absolute left-0 right-1/2 top-1/2 -translate-y-1/2 h-1 bg-gray-200 -z-0 hidden sm:block"></div>
                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-purple-800 -z-0 transition-all duration-300 hidden sm:block" :style="`width: ${((step - 1) / 3) * 100}%`"></div>

                <!-- Step 1 Indicator -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                        :class="step >= 1 ? 'bg-purple-900 text-white shadow-md' : 'bg-gray-100 text-gray-400 border border-gray-200'">
                        1
                    </div>
                    <span class="text-xs font-semibold mt-2" :class="step >= 1 ? 'text-purple-900' : 'text-gray-400'">Service</span>
                </div>

                <!-- Step 2 Indicator -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                        :class="step >= 2 ? 'bg-purple-900 text-white shadow-md' : 'bg-gray-100 text-gray-400 border border-gray-200'">
                        2
                    </div>
                    <span class="text-xs font-semibold mt-2" :class="step >= 2 ? 'text-purple-900' : 'text-gray-400'">Date & Location</span>
                </div>

                <!-- Step 3 Indicator -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                        :class="step >= 3 ? 'bg-purple-900 text-white shadow-md' : 'bg-gray-100 text-gray-400 border border-gray-200'">
                        3
                    </div>
                    <span class="text-xs font-semibold mt-2" :class="step >= 3 ? 'text-purple-900' : 'text-gray-400'">Your Details</span>
                </div>

                <!-- Step 4 Indicator -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                        :class="step >= 4 ? 'bg-purple-900 text-white shadow-md' : 'bg-gray-100 text-gray-400 border border-gray-200'">
                        4
                    </div>
                    <span class="text-xs font-semibold mt-2" :class="step >= 4 ? 'text-purple-900' : 'text-gray-400'">Confirm</span>
                </div>
            </div>
        </div>

        <!-- Main Form Card Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-10">
            <!-- 
                CRITICAL FIX: 
                1. Removed @submit.prevent from the form entirely so it submits normally to the server route.
                2. Attached @click="confirmAndSubmit" directly to the Step 4 confirm button to trigger SweetAlert2.
            -->
            <form x-ref="bookingFormElement" action="{{ route('book.store') }}" method="POST">
                @csrf

                <!-- Hidden Inputs Synchronized with Alpine State (Supports Multi-Select IDs Array) -->
                <template x-for="id in formData.service_ids" :key="id">
                    <input type="hidden" name="service_ids[]" :value="id">
                </template>
                <input type="hidden" name="preferred_date" :value="formData.preferred_date">
                <input type="hidden" name="preferred_time" :value="formData.preferred_time">
                <input type="hidden" name="location_type" :value="formData.location_type">
                <input type="hidden" name="location_details" :value="formData.location_details">
                <input type="hidden" name="client_name" :value="formData.client_name">
                <input type="hidden" name="client_phone" :value="formData.client_phone">
                <input type="hidden" name="client_notes" :value="formData.client_notes">

                <!-- ================= STEP 1: SELECT SERVICES (CUSTOM GROUPED SELECT DROPDOWN) ================= -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-1">Select Your Preferred Services</h2>
                        <p class="text-gray-600 text-sm">Choose one or more services from our categories below.</p>
                    </div>

                    @if($categories->count() > 0)
                        <div class="mb-8 relative" x-data="{ open: false }" @click.outside="open = false">
                            <!-- Custom Select Trigger Bar -->
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Services</label>
                            <div @click="open = !open" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-900 focus:ring-1 focus:ring-purple-900 text-sm bg-white cursor-pointer flex items-center justify-between shadow-sm">
                                <span class="truncate" x-text="formData.service_names.length > 0 ? formData.service_names.join(', ') : '-- Select Services --'"></span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                            </div>

                            <!-- Dropdown Panel Grouped by Categories -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-200" 
                                x-transition:enter-start="opacity-0 translate-y-1" 
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1"
                                class="absolute left-0 right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-xl z-50 max-h-80 overflow-y-auto p-4 space-y-6"
                                style="display: none;">
                                
                                @foreach($categories as $category)
                                    @if($category->services->count() > 0)
                                        <div>
                                            <div class="text-xs font-bold uppercase tracking-wider text-purple-900 mb-2 border-b border-purple-100 pb-1">
                                                {{ $category->name }}
                                            </div>
                                            <div class="space-y-1">
                                                @foreach($category->services as $service)
                                                    <label class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-purple-50/50 cursor-pointer transition-all text-sm text-gray-800 select-none">
                                                        <input type="checkbox" 
                                                            value="{{ $service->id }}" 
                                                            :checked="formData.service_ids.includes({{ $service->id }})"
                                                            @change="toggleService({{ $service->id }}, '{{ addslashes($service->name) }}')"
                                                            class="w-4 h-4 text-purple-900 rounded border-gray-300 focus:ring-purple-800">
                                                        <span class="font-medium">{{ $service->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Selected Badges Preview -->
                        <div class="mb-8" x-show="formData.service_names.length > 0">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Selected Services Summary</label>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="(name, index) in formData.service_names" :key="index">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 border border-purple-200 text-purple-900 text-xs font-medium">
                                        <span x-text="name"></span>
                                        <button type="button" @click="removeServiceByIndex(index)" class="text-purple-600 hover:text-purple-900">
                                            <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </span>
                                </template>
                            </div>
                        </div>
                    @else
                        <div class="p-6 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-sm mb-8">
                            No active services found. Please check back later or contact admin.
                        </div>
                    @endif

                    <!-- Step 1 Navigation -->
                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button type="button" @click="nextStep()" 
                            class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3 rounded-lg shadow-sm transition-all text-sm">
                            <span>Proceed to Date & Location</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- ================= STEP 2: DATE, TIME & LOCATION ================= -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-1">Choose Date, Time & Location</h2>
                        <p class="text-gray-600 text-sm">Select when and where you would like to receive your service.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Date Picker Field -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Select Date</label>
                            <input type="date" x-model="formData.preferred_date" :min="minDate" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-900 focus:ring-1 focus:ring-purple-900 text-sm bg-white">
                        </div>

                        <!-- Time Slot Options -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Select Time</label>
                            <select x-model="formData.preferred_time" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-900 focus:ring-1 focus:ring-purple-900 text-sm bg-white">
                                <option value="">-- Select Time --</option>
                                <option value="09:00:00">09:00 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="12:00:00">12:00 PM</option>
                                <option value="13:00:00">01:00 PM</option>
                                <option value="14:00:00">02:00 PM</option>
                                <option value="15:00:00">03:00 PM</option>
                                <option value="16:00:00">04:00 PM</option>
                                <option value="17:00:00">05:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <!-- Location Type Selection -->
                    <div class="mb-8">
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Location Preference</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all bg-white"
                                :class="formData.location_type === 'studio' ? 'border-purple-900 bg-purple-50/30 shadow-sm' : 'border-gray-200'">
                                <input type="radio" name="loc_choice" value="studio" x-model="formData.location_type" class="w-4 h-4 text-purple-900 border-gray-300 focus:ring-purple-800">
                                <div>
                                    <div class="font-bold text-gray-900 text-sm">Studio Visit</div>
                                    <div class="text-xs text-gray-500">Visit our fully equipped Mbita studio station</div>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all bg-white"
                                :class="formData.location_type === 'home' ? 'border-purple-900 bg-purple-50/30 shadow-sm' : 'border-gray-200'">
                                <input type="radio" name="loc_choice" value="home" x-model="formData.location_type" class="w-4 h-4 text-purple-900 border-gray-300 focus:ring-purple-800">
                                <div>
                                    <div class="font-bold text-gray-900 text-sm">Home Service</div>
                                    <div class="text-xs text-gray-500">We bring professional service to your doorstep</div>
                                </div>
                            </label>
                        </div>

                        <!-- Extra details for home service -->
                        <div x-show="formData.location_type === 'home'" x-transition class="mt-3">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Home / Delivery Address Details</label>
                            <input type="text" x-model="formData.location_details" placeholder="e.g. Estate, House No., or Landmark in Mbita" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-900 focus:ring-1 focus:ring-purple-900 text-sm bg-white">
                        </div>
                    </div>

                    <!-- Step 2 Navigation -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <button type="button" @click="prevStep()" 
                            class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-6 py-3 rounded-lg transition-all text-sm">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Back</span>
                        </button>
                        <button type="button" @click="nextStep()" 
                            class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3 rounded-lg shadow-sm transition-all text-sm">
                            <span>Proceed to Details</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- ================= STEP 3: USER PERSONAL DETAILS ================= -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-1">Your Personal Details</h2>
                        <p class="text-gray-600 text-sm">Provide your contact info so our specialists can prepare for your arrival.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                        <!-- Full Name -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Name</label>
                            <input type="text" x-model="formData.client_name" placeholder="e.g. Akinyi Brenda" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-900 focus:ring-1 focus:ring-purple-900 text-sm bg-white">
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Phone Number</label>
                            <input type="text" x-model="formData.client_phone" placeholder="e.g. 0712345678" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-900 focus:ring-1 focus:ring-purple-900 text-sm bg-white">
                        </div>

                        <!-- Special Notes -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Special Request or Notes (Optional)</label>
                            <textarea x-model="formData.client_notes" rows="3" placeholder="Please share any additional information or special requests regarding the service(s) you need." 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-purple-900 focus:ring-1 focus:ring-purple-900 text-sm bg-white"></textarea>
                        </div>
                    </div>

                    <!-- Step 3 Navigation -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <button type="button" @click="prevStep()" 
                            class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-6 py-3 rounded-lg transition-all text-sm">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Back</span>
                        </button>
                        <button type="button" @click="nextStep()" 
                            class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3 rounded-lg shadow-sm transition-all text-sm">
                            <span>Review & Confirm</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- ================= STEP 4: REVIEW & CONFIRM ================= -->
                <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold font-['Outfit'] text-gray-900 mb-1">Review Your Appointment Summary</h2>
                        <p class="text-gray-600 text-sm">Please verify your booking details before locking in your reservation.</p>
                    </div>

                    <!-- Summary Card -->
                    <div class="bg-purple-50/50 rounded-xl border border-purple-100 p-6 mb-8 space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-purple-100">
                            <span class="text-xs uppercase font-bold text-gray-500 tracking-wider">Selected Services</span>
                            <span class="text-sm font-bold text-purple-900 font-['Outfit'] text-right" x-text="formData.service_names.join(', ')"></span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-purple-100">
                            <span class="text-xs uppercase font-bold text-gray-500 tracking-wider">Appointment Date</span>
                            <span class="text-sm font-semibold text-gray-900" x-text="formData.preferred_date"></span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-purple-100">
                            <span class="text-xs uppercase font-bold text-gray-500 tracking-wider">Time Slot</span>
                            <span class="text-sm font-semibold text-gray-900" x-text="formData.preferred_time"></span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-purple-100">
                            <span class="text-xs uppercase font-bold text-gray-500 tracking-wider">Location</span>
                            <span class="text-sm font-semibold text-gray-900 capitalize">
                                <span x-text="formData.location_type"></span>
                                <template x-if="formData.location_type === 'home' && formData.location_details">
                                    <span x-text="' (' + formData.location_details + ')'" class="text-gray-500 font-normal"></span>
                                </template>
                            </span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-purple-100">
                            <span class="text-xs uppercase font-bold text-gray-500 tracking-wider">Name</span>
                            <span class="text-sm font-semibold text-gray-900" x-text="formData.client_name"></span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-purple-100">
                            <span class="text-xs uppercase font-bold text-gray-500 tracking-wider">Phone Contact</span>
                            <span class="text-sm font-semibold text-gray-900" x-text="formData.client_phone"></span>
                        </div>
                        <div class="flex justify-between items-center" x-show="formData.client_notes">
                            <span class="text-xs uppercase font-bold text-gray-500 tracking-wider">Special Notes</span>
                            <span class="text-sm text-gray-700 italic" x-text="formData.client_notes"></span>
                        </div>
                    </div>

                    <!-- Step 4 Navigation -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <button type="button" @click="prevStep()" 
                            class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium px-6 py-3 rounded-lg transition-all text-sm">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Back</span>
                        </button>
                        <!-- 
                            CRITICAL FIX: 
                            Changed button type to "button" with @click="confirmAndSubmit" to display SweetAlert confirmation first.
                        -->
                        <button type="button" @click="confirmAndSubmit()" 
                            class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-medium px-8 py-3.5 rounded-lg shadow-lg transition-all text-base cursor-pointer">
                            <i data-lucide="calendar-check" class="w-5 h-5 text-purple-200"></i>
                            <span>Confirm & Lock Slot Now</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </div>
</section>

<!-- Alpine JS Multi-Step Form Logic & SweetAlert Integration -->
<script>
    function bookingForm() {
        return {
            step: 1,
            minDate: new Date().toISOString().split('T')[0],
            formData: {
                service_ids: @json(old('service_ids', [])),
                service_names: @json(
                    collect(old('service_ids', []))->map(function($id) {
                        $service = \App\Models\Service::find($id);
                        return $service ? $service->name : '';
                    })->filter()->values()
                ),
                preferred_date: @json(old('preferred_date', '')),
                preferred_time: @json(old('preferred_time', '')),
                location_type: @json(old('location_type', 'studio')),
                location_details: @json(old('location_details', '')),
                client_name: @json(old('client_name', '')),
                client_phone: @json(old('client_phone', '')),
                client_notes: @json(old('client_notes', ''))
            },
            init() {
                if (window.lucide) {
                    lucide.createIcons();
                }
            },
            toggleService(serviceId, serviceName) {
                const index = this.formData.service_ids.indexOf(serviceId);
                if (index > -1) {
                    this.formData.service_ids.splice(index, 1);
                    this.formData.service_names.splice(index, 1);
                } else {
                    this.formData.service_ids.push(serviceId);
                    this.formData.service_names.push(serviceName);
                }
                if (window.lucide) {
                    this.$nextTick(() => lucide.createIcons());
                }
            },
            removeServiceByIndex(index) {
                this.formData.service_ids.splice(index, 1);
                this.formData.service_names.splice(index, 1);
            },
            nextStep() {
                // Step 1 Validation
                if (this.step === 1 && this.formData.service_ids.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Services Required',
                        text: 'Please select at least one service before proceeding.',
                        confirmButtonColor: '#581c87'
                    });
                    return;
                }
                // Step 2 Validation
                if (this.step === 2 && (!this.formData.preferred_date || !this.formData.preferred_time)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Date & Time Required',
                        text: 'Please select both your preferred date and time.',
                        confirmButtonColor: '#581c87'
                    });
                    return;
                }
                // Step 3 Validation
                if (this.step === 3 && (!this.formData.client_name || !this.formData.client_phone)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Contact Info Required',
                        text: 'Please provide your full name and phone contact.',
                        confirmButtonColor: '#581c87'
                    });
                    return;
                }
                if (this.step < 4) {
                    this.step++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    if (window.lucide) {
                        this.$nextTick(() => lucide.createIcons());
                    }
                }
            },
            prevStep() {
                if (this.step > 1) {
                    this.step--;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    if (window.lucide) {
                        this.$nextTick(() => lucide.createIcons());
                    }
                }
            },
            confirmAndSubmit() {
                // Trigger SweetAlert2 Confirmation Dialog before actual form submission
                Swal.fire({
                    title: 'Lock In Reservation?',
                    text: 'Are you sure you want to submit your booking details?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#581c87',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Submit!',
                    cancelButtonText: 'Review Again'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Actually submit the form programmatically to the Laravel route
                        this.$refs.bookingFormElement.submit();
                    }
                });
            }
        }
    }
</script>
@endsection