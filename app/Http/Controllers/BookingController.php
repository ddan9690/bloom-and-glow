<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of all bookings grouped/filtered by status, ordered by latest.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');

        $query = Booking::with(['statusUpdater'])->latest();

        if ($status && in_array($status, ['pending', 'confirmed', 'completed', 'cancelled', 'rescheduled'])) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(15)->through(function ($booking) {
            $serviceNames = 'General Service';

            if (!empty($booking->service_ids)) {
                $serviceIdsArray = is_array($booking->service_ids)
                    ? $booking->service_ids
                    : json_decode($booking->service_ids, true);

                if (is_array($serviceIdsArray) && count($serviceIdsArray) > 0) {
                    $serviceNames = \App\Models\Service::whereIn('id', $serviceIdsArray)->pluck('name')->implode(', ');
                }
            } elseif ($booking->service_id) {
                $serviceNames = optional($booking->service)->name ?? 'General Service';
            }

            $booking->formatted_services = $serviceNames !== '' ? $serviceNames : 'General Service';
            return $booking;
        })->withQueryString();

        // Count stats for filter tabs
        $counts = [
            'all' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'rescheduled' => Booking::where('status', 'rescheduled')->count(),
        ];

        return view('backend.bookings.index', compact('bookings', 'counts', 'status'));
    }

    /**
     * Show the multi-step booking form.
     */
    public function create()
    {
        $categories = Category::with('services')->get();
        return view('pages.book', compact('categories'));
    }

    /**
     * Store a newly created booking in storage supporting multiple services.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_ids'       => ['required', 'array', 'min:1'],
            'service_ids.*'     => ['exists:services,id'],
            'client_name'       => ['required', 'string', 'max:255'],
            'client_phone'      => ['required', 'string', 'max:50'],
            'preferred_date'    => ['required', 'date', 'after_or_equal:today'],
            'preferred_time'    => ['required', 'string'],
            'location_type'     => ['required', 'in:studio,home'],
            'location_details'  => ['nullable', 'string'],
            'client_notes'      => ['nullable', 'string'],
        ]);

        try {
            $this->bookingService->createBooking($validated);
        } catch (\Exception $e) {
            return back()->withErrors(['preferred_date' => $e->getMessage()])->withInput();
        }

        return redirect()->route('book')->with('success', 'Your booking has been successfully submitted and is pending confirmation!');
    }

    /**
     * Update the booking status.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,rescheduled,cancelled',
            'admin_notes' => 'nullable|string',
            'ignore_blocks' => 'nullable|boolean',
        ]);

        try {
            $this->bookingService->updateBookingStatus($booking, $validated, Auth::id());
        } catch (\Exception $e) {
            return back()->withErrors(['preferred_date' => $e->getMessage()])->withInput();
        }

        return back()->with('success', 'Booking status updated successfully.');
    }

    /**
     * Reschedule the booking date and time.
     */
    public function reschedule(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'preferred_date' => ['required', 'date'],
            'preferred_time' => ['required', 'string'],
        ]);

        try {
            // Capture the initial original date/time if this is the first reschedule
            if (is_null($booking->original_date)) {
                $booking->original_date = $booking->preferred_date;
                $booking->original_time = $booking->preferred_time;
            }

            $booking->preferred_date = $validated['preferred_date'];
            $booking->preferred_time = $validated['preferred_time'];
            $booking->status = 'rescheduled';
            $booking->status_updated_by = Auth::id();
            $booking->save();
        } catch (\Exception $e) {
            return back()->withErrors(['preferred_date' => $e->getMessage()])->withInput();
        }

        return back()->with('success', 'Booking successfully rescheduled!');
    }
}
