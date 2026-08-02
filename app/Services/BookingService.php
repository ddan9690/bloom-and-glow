<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\BlockedBookingSlot;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * Validate and process a new multi-service booking.
     *
     * @param array $data
     * @return \App\Models\Booking
     * @throws \Exception
     */
    public function createBooking(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            // 1. Fetch selected services and map their categories
            $services = Service::whereIn('id', $data['service_ids'])->with('category')->get();

            // 2. Validate availability against blocked date and time ranges (Global Block)
            $this->validateAvailability($data['preferred_date'], $data['preferred_time']);

            // 3. Create and return the booking record
            return Booking::create([
                'service_ids'       => json_encode($data['service_ids']),
                'client_name'       => $data['client_name'],
                'client_phone'      => $data['client_phone'],
                'preferred_date'    => $data['preferred_date'],
                'preferred_time'    => $data['preferred_time'],
                'location_type'     => $data['location_type'],
                'location_details'  => $data['location_details'] ?? null,
                'client_notes'      => $data['client_notes'] ?? null,
                'status'            => 'pending',
            ]);
        });
    }

    /**
     * Validate if the selected date and time fall within any global blocked slots.
     *
     * @param string $date
     * @param string $time
     * @throws \Exception
     */
    protected function validateAvailability(string $date, string $time): void
    {
        $isBlocked = BlockedBookingSlot::where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->where(function ($query) use ($time) {
                $query->whereNull('start_time') // Whole-day block covers everything
                    ->orWhere(function ($q) use ($time) {
                        // Partial-day time range block check
                        $q->where('start_time', '<=', $time)
                            ->where('end_time', '>=', $time);
                    });
            })
            ->exists();

        if ($isBlocked) {
            throw new \Exception('BLOCKED_SLOT_ERROR: The selected date and time are unavailable for booking.');
        }
    }

    /**
     * Handle booking status updates and rescheduling.
     *
     * @param \App\Models\Booking $booking
     * @param array $data
     * @param int|null $userId
     * @return \App\Models\Booking
     * @throws \Exception
     */
    public function updateBookingStatus(Booking $booking, array $data, ?int $userId = null): Booking
    {
        return DB::transaction(function () use ($booking, $data, $userId) {
            $updateData = [
                'status'            => $data['status'],
                'status_updated_by' => $userId,
            ];

            if (isset($data['admin_notes'])) {
                $updateData['admin_notes'] = $data['admin_notes'];
            }

            // Handle rescheduling logic
            if ($data['status'] === 'rescheduled') {
                $ignoreBlocks = filter_var($data['ignore_blocks'] ?? false, FILTER_VALIDATE_BOOLEAN);

                // Validate availability if moving to a new date/time and not ignored
                if (!$ignoreBlocks) {
                    $this->validateAvailability($data['preferred_date'], $data['preferred_time']);
                }

                if (!$booking->original_date) {
                    $updateData['original_date'] = $booking->preferred_date;
                    $updateData['original_time'] = $booking->preferred_time;
                }

                $updateData['preferred_date'] = $data['preferred_date'];
                $updateData['preferred_time'] = $data['preferred_time'];
            }

            $booking->update($updateData);

            return $booking;
        });
    }
}