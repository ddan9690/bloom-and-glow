<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingRestriction;
use App\Models\BookingWeeklySchedule;
use App\Models\Service;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class BookingService
{
    /**
     * Create a new booking with full validation.
     */
    public function createBooking(array $validated)
    {
        $date = Carbon::parse($validated['preferred_date']);
        $time = $validated['preferred_time'];
        $serviceIds = $validated['service_ids'] ?? [];

        // Check all restrictions
        $restrictionCheck = BookingRestriction::isBookingAllowed($date, $time, $serviceIds);
        
        if (!$restrictionCheck['allowed']) {
            throw new \Exception($restrictionCheck['message']);
        }

        // Check duplicate booking
        $this->validateDuplicateBooking($validated['client_phone'], $date, $time);

        // Check if time slot is available in weekly schedule
        $this->validateTimeSlot($date, $time);

        DB::transaction(function () use ($validated, $serviceIds) {
            $booking = Booking::create([
                'service_ids' => $serviceIds,
                'client_name' => $validated['client_name'],
                'client_phone' => $validated['client_phone'],
                'preferred_date' => $validated['preferred_date'],
                'preferred_time' => $validated['preferred_time'],
                'location_type' => $validated['location_type'],
                'location_details' => $validated['location_details'] ?? null,
                'client_notes' => $validated['client_notes'] ?? null,
                'status' => 'pending',
            ]);

            // Update restriction usage
            $this->updateRestrictionUsage($validated['preferred_date'], $serviceIds);

            // Clear cache
            $this->clearAvailabilityCache($validated['preferred_date']);

            Log::info('New booking created', [
                'booking_id' => $booking->id,
                'client' => $booking->client_name,
                'date' => $booking->preferred_date,
                'time' => $booking->preferred_time,
                'services' => $serviceIds,
            ]);
        });
    }

    /**
     * Update booking status with validation.
     */
    public function updateBookingStatus(Booking $booking, array $validated, $userId)
    {
        $newStatus = $validated['status'];
        $ignoreBlocks = $validated['ignore_blocks'] ?? false;

        // If changing to confirmed or rescheduled, validate availability
        if (in_array($newStatus, ['confirmed', 'rescheduled']) && !$ignoreBlocks) {
            $date = Carbon::parse($booking->preferred_date);
            $time = $booking->preferred_time;
            $serviceIds = $booking->service_ids ?? [];
            
            $restrictionCheck = BookingRestriction::isBookingAllowed($date, $time, $serviceIds);
            
            if (!$restrictionCheck['allowed']) {
                throw new \Exception($restrictionCheck['message']);
            }
        }

        $booking->status = $newStatus;
        $booking->status_updated_by = $userId;
        
        if (isset($validated['admin_notes'])) {
            $booking->admin_notes = $validated['admin_notes'];
        }

        $booking->save();

        // Clear cache
        $this->clearAvailabilityCache($booking->preferred_date);

        Log::info('Booking status updated', [
            'booking_id' => $booking->id,
            'new_status' => $newStatus,
            'updated_by' => $userId,
        ]);
    }

    /**
     * Reschedule a booking with validation.
     */
    public function rescheduleBooking(Booking $booking, $newDate, $newTime, $userId)
    {
        $date = Carbon::parse($newDate);
        $serviceIds = $booking->service_ids ?? [];

        // Validate the new slot
        $restrictionCheck = BookingRestriction::isBookingAllowed($date, $newTime, $serviceIds);
        
        if (!$restrictionCheck['allowed']) {
            throw new \Exception($restrictionCheck['message']);
        }

        // Validate time slot
        $this->validateTimeSlot($date, $newTime);

        // Store original dates if first reschedule
        if (is_null($booking->original_date)) {
            $booking->original_date = $booking->preferred_date;
            $booking->original_time = $booking->preferred_time;
        }

        $booking->preferred_date = $newDate;
        $booking->preferred_time = $newTime;
        $booking->status = 'rescheduled';
        $booking->status_updated_by = $userId;
        $booking->save();

        // Clear cache
        $this->clearAvailabilityCache($newDate);
        $this->clearAvailabilityCache($booking->original_date);

        Log::info('Booking rescheduled', [
            'booking_id' => $booking->id,
            'new_date' => $newDate,
            'new_time' => $newTime,
            'original_date' => $booking->original_date,
            'updated_by' => $userId,
        ]);
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Booking $booking, $userId, $reason = null)
    {
        $booking->status = 'cancelled';
        $booking->status_updated_by = $userId;
        
        if ($reason) {
            $booking->admin_notes = $reason;
        }
        
        $booking->save();

        // Clear cache
        $this->clearAvailabilityCache($booking->preferred_date);

        Log::info('Booking cancelled', [
            'booking_id' => $booking->id,
            'reason' => $reason,
            'cancelled_by' => $userId,
        ]);
    }

    /**
     * Validate duplicate booking.
     */
    protected function validateDuplicateBooking($phone, Carbon $date, $time)
    {
        $existing = Booking::where('client_phone', $phone)
            ->whereDate('preferred_date', $date)
            ->whereTime('preferred_time', $time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($existing) {
            throw new \Exception('You already have a booking at this time. Please choose a different slot.');
        }
    }

    /**
     * Validate time slot against weekly schedule.
     */
    protected function validateTimeSlot(Carbon $date, $time)
    {
        $schedule = BookingWeeklySchedule::where('day_of_week', $date->dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (!$schedule) {
            throw new \Exception('We are closed on this day. Please choose another date.');
        }

        $timeObj = Carbon::parse($time);
        $startTime = Carbon::parse($schedule->start_time);
        $endTime = Carbon::parse($schedule->end_time);

        if ($timeObj->lt($startTime) || $timeObj->gte($endTime)) {
            throw new \Exception('This time is outside our business hours. Please choose a time between ' . 
                $startTime->format('g:i A') . ' and ' . $endTime->format('g:i A'));
        }

        // Check if time slot is available (not overlapping with existing bookings)
        $existingCount = Booking::whereDate('preferred_date', $date)
            ->whereTime('preferred_time', $time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $maxCapacity = BookingRestriction::checkCapacity($date, $time)['max_capacity'] ?? 3;

        if ($existingCount >= $maxCapacity) {
            throw new \Exception('This time slot is fully booked. Please choose another time.');
        }
    }

    /**
     * Update restriction usage counters.
     */
    protected function updateRestrictionUsage($date, $serviceIds)
    {
        $date = Carbon::parse($date);
        $dateString = $date->format('Y-m-d');

        // Update global capacity
        $globalRestriction = BookingRestriction::where('type', 'capacity_limit')
            ->where('target_type', 'all')
            ->where(function ($q) use ($dateString) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', $dateString)
                  ->where(function ($q2) use ($dateString) {
                      $q2->whereNull('end_date')
                         ->orWhere('end_date', '>=', $dateString);
                  });
            })
            ->first();

        if ($globalRestriction) {
            $globalRestriction->increment('current_usage');
        }

        // Update category capacities
        if (!empty($serviceIds)) {
            $categories = Service::whereIn('id', $serviceIds)
                ->pluck('category_id')
                ->unique();

            foreach ($categories as $categoryId) {
                $categoryRestriction = BookingRestriction::where('type', 'capacity_limit')
                    ->where('target_type', 'category')
                    ->where('target_id', $categoryId)
                    ->where(function ($q) use ($dateString) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', $dateString)
                          ->where(function ($q2) use ($dateString) {
                              $q2->whereNull('end_date')
                                 ->orWhere('end_date', '>=', $dateString);
                          });
                    })
                    ->first();

                if ($categoryRestriction) {
                    $categoryRestriction->increment('current_usage');
                }
            }

            // Update service capacities
            foreach ($serviceIds as $serviceId) {
                $serviceRestriction = BookingRestriction::where('type', 'capacity_limit')
                    ->where('target_type', 'service')
                    ->where('target_id', $serviceId)
                    ->where(function ($q) use ($dateString) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', $dateString)
                          ->where(function ($q2) use ($dateString) {
                              $q2->whereNull('end_date')
                                 ->orWhere('end_date', '>=', $dateString);
                          });
                    })
                    ->first();

                if ($serviceRestriction) {
                    $serviceRestriction->increment('current_usage');
                }
            }
        }
    }

    /**
     * Get available slots for a date.
     */
    public function getAvailableSlots($date, $serviceIds = [])
    {
        $cacheKey = 'available_slots_' . $date . '_' . md5(serialize($serviceIds));
        
        return Cache::remember($cacheKey, 300, function () use ($date, $serviceIds) {
            return BookingRestriction::getAvailableSlots($date, $serviceIds);
        });
    }

    /**
     * Get calendar data for a month.
     */
    public function getCalendarData($year, $month)
    {
        $cacheKey = 'calendar_data_' . $year . '_' . $month;
        
        return Cache::remember($cacheKey, 3600, function () use ($year, $month) {
            return BookingRestriction::getCalendarData($year, $month);
        });
    }

    /**
     * Check if a date/time is available.
     */
    public function checkAvailability($date, $time = null, $serviceIds = [])
    {
        $date = Carbon::parse($date);
        return BookingRestriction::isBookingAllowed($date, $time, $serviceIds);
    }

    /**
     * Get booking statistics.
     */
    public function getBookingStats()
    {
        return [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'rescheduled' => Booking::where('status', 'rescheduled')->count(),
            'today' => Booking::whereDate('preferred_date', Carbon::today())->count(),
            'this_week' => Booking::whereBetween('preferred_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'this_month' => Booking::whereMonth('preferred_date', Carbon::now()->month)->count(),
            'upcoming' => Booking::whereDate('preferred_date', '>=', Carbon::today())
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
        ];
    }

    /**
     * Get restriction statistics.
     */
    public function getRestrictionStats()
    {
        return [
            'total' => BookingRestriction::count(),
            'active' => BookingRestriction::where('is_active', true)->count(),
            'capacity_limits' => BookingRestriction::where('type', 'capacity_limit')->count(),
            'closures' => BookingRestriction::whereIn('type', ['shop_closure', 'holiday', 'temporary_closure', 'recurring_closure'])->count(),
            'service_unavailable' => BookingRestriction::where('type', 'service_unavailable')->count(),
        ];
    }

    /**
     * Get upcoming bookings.
     */
    public function getUpcomingBookings($limit = 10)
    {
        return Booking::with(['statusUpdater'])
            ->whereDate('preferred_date', '>=', Carbon::today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('preferred_date')
            ->orderBy('preferred_time')
            ->limit($limit)
            ->get();
    }

    /**
     * Get bookings for a specific date.
     */
    public function getBookingsForDate($date)
    {
        $date = Carbon::parse($date);
        
        return Booking::whereDate('preferred_date', $date)
            ->with(['statusUpdater'])
            ->orderBy('preferred_time')
            ->get();
    }

    /**
     * Get service names from IDs.
     */
    public function getServiceNames(array $serviceIds)
    {
        if (empty($serviceIds)) {
            return 'General Service';
        }
        
        return Service::whereIn('id', $serviceIds)->pluck('name')->implode(', ');
    }

    /**
     * Get service duration from rules.
     */
    public function getServiceDuration(array $serviceIds)
    {
        if (empty($serviceIds)) {
            return null;
        }

        $service = Service::whereIn('id', $serviceIds)->first();
        return $service ? $service->duration_minutes : null;
    }

    /**
     * Clear availability cache.
     */
    protected function clearAvailabilityCache($date)
    {
        $date = Carbon::parse($date);
        
        // Clear specific date cache
        Cache::forget('available_slots_' . $date->format('Y-m-d'));
        
        // Clear month cache
        Cache::forget('calendar_data_' . $date->year . '_' . $date->month);
        
        // Clear any wildcard caches (optional)
        // Cache::flush(); // Use with caution
    }

    /**
     * Reset daily usage counters.
     */
    public function resetDailyUsage()
    {
        $updated = BookingRestriction::where('type', 'capacity_limit')
            ->update(['current_usage' => 0]);
        
        Log::info('Daily usage counters reset', [
            'updated_count' => $updated,
            'reset_by' => auth()->user()->name ?? 'System',
        ]);
        
        return $updated;
    }

    /**
     * Get available categories with their services.
     */
    public function getAvailableCategories()
    {
        return Category::with(['services' => function ($query) {
            $query->where('is_active', true);
        }])->whereHas('services', function ($query) {
            $query->where('is_active', true);
        })->get();
    }

    /**
     * Get booking history for a client.
     */
    public function getClientHistory($phone, $limit = 10)
    {
        return Booking::where('client_phone', $phone)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Check if a date is a holiday.
     */
    public function isHoliday($date)
    {
        $date = Carbon::parse($date);
        $dateString = $date->format('Y-m-d');
        
        $restriction = BookingRestriction::where('type', 'holiday')
            ->where('is_active', true)
            ->where(function ($q) use ($dateString) {
                $q->where('start_date', '<=', $dateString)
                  ->where(function ($q2) use ($dateString) {
                      $q2->whereNull('end_date')
                         ->orWhere('end_date', '>=', $dateString);
                  });
            })
            ->exists();
        
        return $restriction;
    }

    /**
     * Get business hours for a specific day.
     */
    public function getBusinessHours($dayOfWeek = null)
    {
        if ($dayOfWeek === null) {
            $dayOfWeek = Carbon::now()->dayOfWeek;
        }
        
        $schedule = BookingWeeklySchedule::where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();
        
        if (!$schedule) {
            return null;
        }
        
        return [
            'start' => Carbon::parse($schedule->start_time)->format('g:i A'),
            'end' => Carbon::parse($schedule->end_time)->format('g:i A'),
            'is_open' => $schedule->is_available,
            'slot_duration' => $schedule->slot_duration,
            'break_between' => $schedule->break_between_slots,
        ];
    }

    /**
     * Get next available slot for a service.
     */
    public function getNextAvailableSlot($serviceIds = [], $startDate = null)
    {
        $startDate = $startDate ? Carbon::parse($startDate) : Carbon::today();
        $maxDaysToCheck = 30;
        
        for ($i = 0; $i < $maxDaysToCheck; $i++) {
            $date = $startDate->copy()->addDays($i);
            
            $slots = $this->getAvailableSlots($date->format('Y-m-d'), $serviceIds);
            
            if ($slots['is_available'] && !empty($slots['slots'])) {
                foreach ($slots['slots'] as $slot) {
                    if ($slot['is_available']) {
                        return [
                            'date' => $date->format('Y-m-d'),
                            'time' => $slot['time'],
                            'formatted' => $date->format('l, M d, Y') . ' at ' . $slot['formatted'],
                        ];
                    }
                }
            }
        }
        
        return null;
    }

    /**
     * Validate booking data before creation.
     */
    public function validateBookingData(array $data)
    {
        $validated = validator($data, [
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['exists:services,id'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => ['required', 'string', 'max:50'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'string'],
            'location_type' => ['required', 'in:studio,home'],
            'location_details' => ['nullable', 'string'],
            'client_notes' => ['nullable', 'string'],
        ])->validate();

        // Additional validation
        $date = Carbon::parse($validated['preferred_date']);
        
        // Check if date is in the past
        if ($date->lt(Carbon::today())) {
            throw new \Exception('Cannot book for past dates.');
        }

        // Check max advance booking days (from settings)
        $maxAdvanceDays = (int) BookingSetting::get('max_advance_booking_days', 30);
        if ($date->gt(Carbon::today()->addDays($maxAdvanceDays))) {
            throw new \Exception("Bookings can only be made up to {$maxAdvanceDays} days in advance.");
        }

        return $validated;
    }

    /**
     * Initialize default booking settings.
     */
    public function initializeDefaultSettings()
    {
        $settings = [
            ['key' => 'business_name', 'value' => 'Bloom & Glow Mbita', 'group' => 'general'],
            ['key' => 'business_email', 'value' => 'info@bloomandglow.com', 'group' => 'general'],
            ['key' => 'business_phone', 'value' => '+254711317235', 'group' => 'general'],
            ['key' => 'default_slot_capacity', 'value' => '3', 'group' => 'capacity', 'type' => 'number'],
            ['key' => 'max_advance_booking_days', 'value' => '30', 'group' => 'booking', 'type' => 'number'],
            ['key' => 'min_advance_booking_hours', 'value' => '2', 'group' => 'booking', 'type' => 'number'],
            ['key' => 'auto_confirm_booking', 'value' => 'false', 'group' => 'automation', 'type' => 'boolean'],
            ['key' => 'send_sms_notifications', 'value' => 'false', 'group' => 'notifications', 'type' => 'boolean'],
            ['key' => 'send_email_notifications', 'value' => 'false', 'group' => 'notifications', 'type' => 'boolean'],
        ];

        foreach ($settings as $setting) {
            \App\Models\BookingSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    /**
     * Get booking trends data.
     */
    public function getBookingTrends($days = 30)
    {
        $data = [];
        $startDate = Carbon::today()->subDays($days - 1);
        
        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateString = $date->format('Y-m-d');
            
            $data[$dateString] = [
                'date' => $dateString,
                'bookings' => Booking::whereDate('preferred_date', $date)->count(),
                'pending' => Booking::whereDate('preferred_date', $date)->where('status', 'pending')->count(),
                'confirmed' => Booking::whereDate('preferred_date', $date)->where('status', 'confirmed')->count(),
                'completed' => Booking::whereDate('preferred_date', $date)->where('status', 'completed')->count(),
                'cancelled' => Booking::whereDate('preferred_date', $date)->where('status', 'cancelled')->count(),
            ];
        }
        
        return $data;
    }

    /**
     * Get peak hours analysis.
     */
    public function getPeakHours()
    {
        $bookings = Booking::whereDate('preferred_date', '>=', Carbon::now()->subDays(30))
            ->whereIn('status', ['confirmed', 'completed'])
            ->get();
        
        $hours = [];
        foreach ($bookings as $booking) {
            $hour = Carbon::parse($booking->preferred_time)->format('H:00');
            $hours[$hour] = ($hours[$hour] ?? 0) + 1;
        }
        
        arsort($hours);
        
        return $hours;
    }

    /**
     * Get service popularity.
     */
    public function getServicePopularity($limit = 10)
    {
        $bookings = Booking::whereIn('status', ['confirmed', 'completed'])
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->get();
        
        $services = [];
        foreach ($bookings as $booking) {
            $serviceIds = $booking->service_ids ?? [];
            foreach ($serviceIds as $serviceId) {
                $services[$serviceId] = ($services[$serviceId] ?? 0) + 1;
            }
        }
        
        arsort($services);
        
        $topServices = array_slice($services, 0, $limit, true);
        $serviceNames = Service::whereIn('id', array_keys($topServices))
            ->pluck('name', 'id')
            ->toArray();
        
        $result = [];
        foreach ($topServices as $id => $count) {
            $result[] = [
                'service_id' => $id,
                'name' => $serviceNames[$id] ?? 'Unknown',
                'bookings' => $count,
            ];
        }
        
        return $result;
    }
}