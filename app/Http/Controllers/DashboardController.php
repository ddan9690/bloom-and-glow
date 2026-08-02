<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard index view with metrics and management data.
     */
    public function index()
    {
        // Dummy data placeholders for counters and recent bookings matching the UI
        $stats = [
            'pending' => 5,
            'confirmed' => 24,
            'completed' => 142,
            'cancelled' => 3,
        ];

        $latestBookings = [
            [
                'id' => '01',
                'booked_on' => 'Aug 2, 2026',
                'name' => 'Brenda Achieng',
                'phone' => '0712 345 678',
                'service' => 'Classic Haircut',
                'appointment_date' => 'Aug 3, 10:00 AM',
            ],
            [
                'id' => '02',
                'booked_on' => 'Aug 2, 2026',
                'name' => 'Kevin Otieno',
                'phone' => '0722 987 654',
                'service' => 'Beard Trim & Grooming',
                'appointment_date' => 'Aug 2, 02:30 PM',
            ],
            [
                'id' => '03',
                'booked_on' => 'Aug 1, 2026',
                'name' => 'Sharon Akinyi',
                'phone' => '0733 112 233',
                'service' => 'Glow Facial Treatment',
                'appointment_date' => 'Aug 4, 11:00 AM',
            ],
        ];

        return view('backend.index', compact('stats', 'latestBookings'));
    }
}