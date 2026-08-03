<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard index view with metrics, management data, and quick overviews.
     */
    public function index()
    {
        // Real-time booking metrics counters computed from the database
        $stats = [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'total_users' => User::count(),
            'total_services' => Service::count(),
        ];

        // Fetch latest bookings sorted by most recent first
        $latestBookings = Booking::latest()
            ->take(5)
            ->get()
            ->map(function ($booking, $index) {
                $serviceNames = 'General Service';
                if (!empty($booking->service_ids)) {
                    $serviceIdsArray = json_decode($booking->service_ids, true);
                    if (is_array($serviceIdsArray) && count($serviceIdsArray) > 0) {
                        $serviceNames = Service::whereIn('id', $serviceIdsArray)->pluck('name')->implode(', ');
                    }
                } elseif ($booking->service_id) {
                    $serviceNames = optional($booking->service)->name ?? 'General Service';
                }

                return [
                    'id' => $booking->id,
                    'row_no' => str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                    'booked_on' => $booking->created_at->format('M j, Y'),
                    'name' => $booking->client_name,
                    'phone' => $booking->client_phone,
                    'service' => $serviceNames,
                    'appointment_date' => $booking->preferred_date ? \Carbon\Carbon::parse($booking->preferred_date)->format('M j, Y') : 'N/A',
                    'appointment_time' => $booking->preferred_time ? \Carbon\Carbon::parse($booking->preferred_time)->format('h:i A') : 'N/A',
                    'status' => $booking->status,
                ];
            });

        // Fetch categories with their active services for management catalog overview
        $categories = Category::with('services')->get();

        // Fetch recent system users for quick administrative overview
        $recentUsers = User::with('roles')->latest()->take(5)->get();

        return view('backend.index', compact('stats', 'latestBookings', 'categories', 'recentUsers'));
    }
}
