<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookingRestriction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'target_type',
        'target_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'recurring_days',
        'is_recurring',
        'max_capacity',
        'current_usage',
        'reason',
        'description',
        'meta',
        'is_active',
        'is_soft_limit',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'recurring_days' => 'array',
        'is_recurring' => 'boolean',
        'is_active' => 'boolean',
        'is_soft_limit' => 'boolean',
        'meta' => 'array',
        'current_usage' => 'integer',
    ];

    /**
     * Get client-friendly generic message based on restriction type.
     */
    public function getClientMessageAttribute()
    {
        $messages = [
            'capacity_limit' => 'This time slot is fully booked. Please choose another time.',
            'shop_closure' => 'Not available for booking. Please choose another date.',
            'holiday' => 'Not available for booking. Please choose another date.',
            'temporary_closure' => 'Not available for booking. Please choose another date.',
            'recurring_closure' => 'Not available for booking on this day. Please choose another date.',
            'service_unavailable' => 'This service is currently unavailable. Please choose another service.',
            'time_restriction' => 'This time slot is not available. Please choose another time.',
        ];

        return $messages[$this->type] ?? 'This time slot is not available. Please choose another date or time.';
    }

    /**
     * Get the target model.
     */
    public function target()
    {
        if ($this->target_type === 'category') {
            return $this->belongsTo(Category::class, 'target_id');
        } elseif ($this->target_type === 'service') {
            return $this->belongsTo(Service::class, 'target_id');
        }
        return null;
    }

    /**
     * Get the user who created this restriction.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this restriction.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope for active restrictions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if a booking is allowed.
     */
    public static function isBookingAllowed($date, $time = null, $serviceIds = [])
    {
        $date = Carbon::parse($date);

        // Check shop closures
        $closureResult = self::checkShopClosure($date, $time);
        if (!$closureResult['allowed']) {
            return [
                'allowed' => false,
                'message' => $closureResult['message'],
                'type' => 'closure',
            ];
        }

        // Check service availability
        if (!empty($serviceIds)) {
            $unavailableResult = self::checkServiceAvailability($date, $time, $serviceIds);
            if (!$unavailableResult['allowed']) {
                return [
                    'allowed' => false,
                    'message' => $unavailableResult['message'],
                    'type' => 'service_unavailable',
                ];
            }
        }

        // Check capacity limits
        $capacityResult = self::checkCapacity($date, $time, $serviceIds);
        if (!$capacityResult['allowed']) {
            return [
                'allowed' => false,
                'message' => $capacityResult['message'],
                'type' => 'capacity',
                'capacity_info' => $capacityResult,
            ];
        }

        return [
            'allowed' => true,
            'message' => null,
        ];
    }

    /**
     * Check shop closure.
     */
    public static function checkShopClosure($date, $time = null)
    {
        $date = Carbon::parse($date);
        $dateString = $date->format('Y-m-d');

        $restriction = self::active()
            ->whereIn('type', ['shop_closure', 'holiday', 'temporary_closure', 'recurring_closure'])
            ->where(function ($q) use ($dateString) {
                $q->where(function ($q2) use ($dateString) {
                    $q2->whereNull('start_date')
                        ->orWhere('start_date', '<=', $dateString)
                        ->where(function ($q3) use ($dateString) {
                            $q3->whereNull('end_date')
                                ->orWhere('end_date', '>=', $dateString);
                        });
                })
                    ->orWhere(function ($q2) {
                        $q2->where('is_recurring', true)
                            ->whereJsonContains('recurring_days', Carbon::now()->dayOfWeek);
                    });
            })
            ->first();

        if (!$restriction) {
            return ['allowed' => true];
        }

        if ($time && $restriction->start_time && $restriction->end_time) {
            $timeObj = Carbon::parse($time);
            $startTime = Carbon::parse($restriction->start_time);
            $endTime = Carbon::parse($restriction->end_time);

            if ($timeObj->between($startTime, $endTime, true)) {
                return [
                    'allowed' => false,
                    'message' => $restriction->client_message,
                ];
            }
            return ['allowed' => true];
        }

        if ($restriction->start_time === null && $restriction->end_time === null) {
            return [
                'allowed' => false,
                'message' => $restriction->client_message,
            ];
        }

        return ['allowed' => true];
    }

    /**
     * Check service availability.
     */
    public static function checkServiceAvailability($date, $time = null, $serviceIds = [])
    {
        if (empty($serviceIds)) {
            return ['allowed' => true];
        }

        $date = Carbon::parse($date);
        $dateString = $date->format('Y-m-d');

        $unavailableServices = self::active()
            ->where('type', 'service_unavailable')
            ->where('target_type', 'service')
            ->whereIn('target_id', $serviceIds)
            ->where(function ($q) use ($dateString) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', $dateString)
                    ->where(function ($q2) use ($dateString) {
                        $q2->whereNull('end_date')
                            ->orWhere('end_date', '>=', $dateString);
                    });
            })
            ->first();

        if ($unavailableServices) {
            return [
                'allowed' => false,
                'message' => $unavailableServices->client_message,
            ];
        }

        return ['allowed' => true];
    }

    /**
     * Check capacity limits.
     */
    public static function checkCapacity($date, $time = null, $serviceIds = [])
    {
        $date = Carbon::parse($date);
        $dateString = $date->format('Y-m-d');

        // Check global capacity
        $globalRestriction = self::active()
            ->where('type', 'capacity_limit')
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
            $currentBookings = Booking::whereDate('preferred_date', $date)
                ->whereIn('status', ['pending', 'confirmed'])
                ->count();

            $globalRestriction->current_usage = $currentBookings;
            $globalRestriction->save();

            if ($currentBookings >= $globalRestriction->max_capacity) {
                return [
                    'allowed' => false,
                    'message' => $globalRestriction->client_message,
                    'current_usage' => $currentBookings,
                    'max_capacity' => $globalRestriction->max_capacity,
                    'remaining' => 0,
                ];
            }
        }

        // Check category and service capacities
        if (!empty($serviceIds)) {
            $categories = Service::whereIn('id', $serviceIds)
                ->pluck('category_id')
                ->unique();

            foreach ($categories as $categoryId) {
                $categoryRestriction = self::active()
                    ->where('type', 'capacity_limit')
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
                    $categoryBookings = Booking::whereDate('preferred_date', $date)
                        ->whereJsonContains('service_ids', $categoryId)
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->count();

                    $categoryRestriction->current_usage = $categoryBookings;
                    $categoryRestriction->save();

                    if ($categoryBookings >= $categoryRestriction->max_capacity) {
                        return [
                            'allowed' => false,
                            'message' => $categoryRestriction->client_message,
                            'current_usage' => $categoryBookings,
                            'max_capacity' => $categoryRestriction->max_capacity,
                            'remaining' => 0,
                        ];
                    }
                }
            }

            foreach ($serviceIds as $serviceId) {
                $serviceRestriction = self::active()
                    ->where('type', 'capacity_limit')
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
                    $serviceBookings = Booking::whereDate('preferred_date', $date)
                        ->whereJsonContains('service_ids', $serviceId)
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->count();

                    $serviceRestriction->current_usage = $serviceBookings;
                    $serviceRestriction->save();

                    if ($serviceBookings >= $serviceRestriction->max_capacity) {
                        return [
                            'allowed' => false,
                            'message' => $serviceRestriction->client_message,
                            'current_usage' => $serviceBookings,
                            'max_capacity' => $serviceRestriction->max_capacity,
                            'remaining' => 0,
                        ];
                    }
                }
            }
        }

        return ['allowed' => true];
    }

    /**
     * Get calendar data.
     */
    public static function getCalendarData($year, $month)
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        $calendar = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $dateString = $current->format('Y-m-d');
            $closureResult = self::checkShopClosure($current);

            $calendar[$dateString] = [
                'date' => $dateString,
                'is_available' => $closureResult['allowed'],
                'message' => $closureResult['allowed'] ? null : $closureResult['message'],
            ];

            $current->addDay();
        }

        return $calendar;
    }

    /**
     * Get available slots.
     */
    public static function getAvailableSlots($date, $serviceIds = [], $slotDuration = 60)
    {
        $date = Carbon::parse($date);
        $slots = [];

        $closureResult = self::checkShopClosure($date);
        if (!$closureResult['allowed']) {
            return [
                'date' => $date->format('Y-m-d'),
                'is_available' => false,
                'message' => $closureResult['message'],
                'slots' => [],
            ];
        }

        $schedule = BookingWeeklySchedule::where('day_of_week', $date->dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (!$schedule) {
            return [
                'date' => $date->format('Y-m-d'),
                'is_available' => false,
                'message' => 'Not available for booking on this day.',
                'slots' => [],
            ];
        }

        $startTime = Carbon::parse($schedule->start_time);
        $endTime = Carbon::parse($schedule->end_time);
        $duration = $slotDuration ?? $schedule->slot_duration;

        while ($startTime->lt($endTime)) {
            $slotEnd = $startTime->copy()->addMinutes($duration);

            if ($slotEnd->gt($endTime)) {
                break;
            }

            $timeString = $startTime->format('H:i:s');
            $bookingCheck = self::isBookingAllowed($date, $timeString, $serviceIds);

            $slots[] = [
                'time' => $timeString,
                'formatted' => $startTime->format('g:i A'),
                'end_time' => $slotEnd->format('H:i:s'),
                'end_formatted' => $slotEnd->format('g:i A'),
                'is_available' => $bookingCheck['allowed'],
                'message' => $bookingCheck['allowed'] ? null : $bookingCheck['message'],
            ];

            $startTime->addMinutes($duration + ($schedule->break_between_slots ?? 0));
        }

        return [
            'date' => $date->format('Y-m-d'),
            'is_available' => true,
            'message' => null,
            'slots' => $slots,
        ];
    }
}
