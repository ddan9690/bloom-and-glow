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

        $query = Booking::with(['service', 'statusUpdater'])->latest();

        if ($status && in_array($status, ['pending', 'confirmed', 'completed', 'cancelled', 'rescheduled'])) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(15)->withQueryString();

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
     * Update the booking status or reschedule details.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,rescheduled,cancelled',
            'preferred_date' => 'nullable|required_if:status,rescheduled|date',
            'preferred_time' => 'nullable|required_if:status,rescheduled',
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
}
