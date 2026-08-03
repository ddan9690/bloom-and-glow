<?php

namespace App\Http\Controllers;

use App\Models\BookingRestriction;
use App\Models\BookingWeeklySchedule;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;

class BookingRestrictionController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;

        // Apply permission middleware
        $this->middleware('permission:manage bookings')->except(['getAvailableSlots', 'getCalendarData']);
        $this->middleware('permission:view bookings')->only(['getAvailableSlots', 'getCalendarData']);
    }

    /**
     * Display a listing of all restrictions with calendar preview.
     */
    public function index(Request $request)
    {
        // Get current month/year for calendar
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);

        // Get restrictions with filters
        $query = BookingRestriction::with(['createdBy', 'target']);

        // Filter by type
        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('is_active', $request->status == 'active');
        }

        // Search by reason or description
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reason', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $restrictions = $query->latest()->paginate(15);

        // Get calendar data for the selected month
        $calendarData = BookingRestriction::getCalendarData($year, $month);

        // Get weekly schedule
        $weeklySchedule = BookingWeeklySchedule::get();

        // Get available targets for dropdowns
        $categories = Category::with('services')->get();
        $services = Service::where('is_active', true)->get();
        $users = User::all();

        // Get stats
        $stats = [
            'total' => BookingRestriction::count(),
            'active' => BookingRestriction::where('is_active', true)->count(),
            'inactive' => BookingRestriction::where('is_active', false)->count(),
            'capacity_limits' => BookingRestriction::where('type', 'capacity_limit')->count(),
            'closures' => BookingRestriction::whereIn('type', ['shop_closure', 'holiday', 'temporary_closure', 'recurring_closure'])->count(),
            'service_unavailable' => BookingRestriction::where('type', 'service_unavailable')->count(),
            'time_restrictions' => BookingRestriction::where('type', 'time_restriction')->count(),
        ];

        // Get restriction types for filter
        $types = BookingRestriction::select('type')->distinct()->pluck('type');

        return view('backend.bookings.restrictions.index', compact(
            'restrictions',
            'calendarData',
            'weeklySchedule',
            'categories',
            'services',
            'users',
            'stats',
            'types',
            'year',
            'month',
            'request'
        ));
    }

    /**
     * Show the form for creating a new restriction.
     */
    public function create()
    {
        $categories = Category::with('services')->get();
        $services = Service::where('is_active', true)->get();
        $weeklySchedule = BookingWeeklySchedule::get();

        return view('backend.bookings.restrictions.create', compact(
            'categories',
            'services',
            'weeklySchedule'
        ));
    }

    /**
     * Store a newly created restriction.
     */
    public function store(Request $request)
    {
        $validated = $this->validateRestriction($request);

        // Prepare data
        $data = [
            'type' => $validated['type'],
            'target_type' => $validated['target_type'] ?? 'all',
            'target_id' => $validated['target_id'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'recurring_days' => $validated['recurring_days'] ?? null,
            'is_recurring' => !empty($validated['recurring_days']),
            'max_capacity' => $validated['max_capacity'] ?? null,
            'reason' => $validated['reason'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'is_soft_limit' => $validated['is_soft_limit'] ?? false,
            'created_by' => auth()->id(),
        ];

        $restriction = BookingRestriction::create($data);

        // Log the creation
        \Log::info('Booking restriction created', [
            'restriction_id' => $restriction->id,
            'type' => $restriction->type,
            'created_by' => auth()->user()->name,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking restriction created successfully.',
                'data' => $restriction
            ]);
        }

        return redirect()->route('management.bookings.restrictions.index')
            ->with('success', 'Booking restriction created successfully.');
    }

    /**
     * Display the specified restriction.
     */
    public function show(BookingRestriction $restriction)
    {
        $restriction->load(['createdBy', 'updatedBy', 'target']);

        // Get booking count affected by this restriction
        $affectedBookings = 0;
        if ($restriction->type === 'capacity_limit') {
            $affectedBookings = \App\Models\Booking::whereDate('preferred_date', '>=', $restriction->start_date ?? '2000-01-01')
                ->whereDate('preferred_date', '<=', $restriction->end_date ?? '2099-12-31')
                ->count();
        }

        return view('backend.bookings.restrictions.show', compact('restriction', 'affectedBookings'));
    }

    /**
     * Show the form for editing the specified restriction.
     */
    public function edit(BookingRestriction $restriction)
    {
        $categories = Category::with('services')->get();
        $services = Service::where('is_active', true)->get();
        $weeklySchedule = BookingWeeklySchedule::get();

        return view('backend.bookings.restrictions.edit', compact(
            'restriction',
            'categories',
            'services',
            'weeklySchedule'
        ));
    }

    /**
     * Update the specified restriction.
     */
    public function update(Request $request, BookingRestriction $restriction)
    {
        $validated = $this->validateRestriction($request, $restriction->id);

        // Prepare data
        $data = [
            'type' => $validated['type'],
            'target_type' => $validated['target_type'] ?? 'all',
            'target_id' => $validated['target_id'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'recurring_days' => $validated['recurring_days'] ?? null,
            'is_recurring' => !empty($validated['recurring_days']),
            'max_capacity' => $validated['max_capacity'] ?? null,
            'reason' => $validated['reason'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? $restriction->is_active,
            'is_soft_limit' => $validated['is_soft_limit'] ?? false,
            'updated_by' => auth()->id(),
        ];

        $restriction->update($data);

        // Log the update
        \Log::info('Booking restriction updated', [
            'restriction_id' => $restriction->id,
            'type' => $restriction->type,
            'updated_by' => auth()->user()->name,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking restriction updated successfully.',
                'data' => $restriction
            ]);
        }

        return redirect()->route('management.bookings.restrictions.index')
            ->with('success', 'Booking restriction updated successfully.');
    }

    /**
     * Toggle the active status of a restriction.
     */
    public function toggle(Request $request, BookingRestriction $restriction)
    {
        $restriction->is_active = !$restriction->is_active;
        $restriction->updated_by = auth()->id();
        $restriction->save();

        $status = $restriction->is_active ? 'activated' : 'deactivated';

        \Log::info('Booking restriction toggled', [
            'restriction_id' => $restriction->id,
            'new_status' => $restriction->is_active,
            'updated_by' => auth()->user()->name,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Restriction {$status} successfully.",
                'is_active' => $restriction->is_active
            ]);
        }

        return redirect()->route('management.bookings.restrictions.index')
            ->with('success', "Restriction {$status} successfully.");
    }

    /**
     * Remove the specified restriction.
     */
    public function destroy(Request $request, BookingRestriction $restriction)
    {
        $restriction->delete();

        Log::info('Booking restriction deleted', [
            'restriction_id' => $restriction->id,
            'type' => $restriction->type,
            'deleted_by' => auth()->user()->name,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Restriction removed successfully.'
            ]);
        }

        return redirect()->route('management.bookings.restrictions.index')
            ->with('success', 'Restriction removed successfully.');
    }

    /**
     * Bulk delete restrictions.
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:booking_restrictions,id']
        ]);

        $deleted = BookingRestriction::whereIn('id', $validated['ids'])->delete();

        \Log::info('Booking restrictions bulk deleted', [
            'count' => $deleted,
            'deleted_by' => auth()->user()->name,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$deleted} restrictions removed successfully."
            ]);
        }

        return redirect()->route('management.bookings.restrictions.index')
            ->with('success', "{$deleted} restrictions removed successfully.");
    }

    /**
     * Bulk toggle restrictions.
     */
    public function bulkToggle(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['exists:booking_restrictions,id'],
            'action' => ['required', 'in:activate,deactivate']
        ]);

        $status = $validated['action'] === 'activate';
        $updated = BookingRestriction::whereIn('id', $validated['ids'])
            ->update([
                'is_active' => $status,
                'updated_by' => auth()->id()
            ]);

        \Log::info('Booking restrictions bulk toggled', [
            'count' => $updated,
            'action' => $validated['action'],
            'updated_by' => auth()->user()->name,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$updated} restrictions updated successfully."
            ]);
        }

        return redirect()->route('management.bookings.restrictions.index')
            ->with('success', "{$updated} restrictions updated successfully.");
    }

    /**
     * Get available slots for a specific date (API endpoint for frontend).
     */
    public function getAvailableSlots(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:services,id'],
        ]);

        $slots = BookingRestriction::getAvailableSlots(
            $validated['date'],
            $validated['service_ids'] ?? []
        );

        return response()->json($slots);
    }

    /**
     * Get calendar data for a month (API endpoint for frontend).
     */
    public function getCalendarData(Request $request)
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $calendar = BookingRestriction::getCalendarData(
            $validated['year'],
            $validated['month']
        );

        return response()->json($calendar);
    }

    /**
     * Export restrictions to CSV.
     */
    public function export(Request $request)
    {
        $restrictions = BookingRestriction::with(['createdBy', 'target'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="booking_restrictions_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($restrictions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Type', 'Target', 'Start Date', 'End Date', 'Reason', 'Status', 'Created By', 'Created At']);

            foreach ($restrictions as $restriction) {
                fputcsv($file, [
                    $restriction->id,
                    $restriction->type,
                    $restriction->target_type . ($restriction->target ? ' - ' . $restriction->target->name : ''),
                    $restriction->start_date ?? 'N/A',
                    $restriction->end_date ?? 'N/A',
                    $restriction->reason ?? 'N/A',
                    $restriction->is_active ? 'Active' : 'Inactive',
                    $restriction->createdBy->name ?? 'N/A',
                    $restriction->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Validate restriction request.
     */
    protected function validateRestriction(Request $request, $id = null)
    {
        $rules = [
            'type' => ['required', 'in:capacity_limit,shop_closure,holiday,temporary_closure,recurring_closure,service_unavailable,time_restriction'],
            'target_type' => ['nullable', 'in:all,category,service'],
            'target_id' => ['nullable', 'required_if:target_type,category,service'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'start_time' => ['nullable', 'string'],
            'end_time' => ['nullable', 'string'],
            'recurring_days' => ['nullable', 'array'],
            'recurring_days.*' => ['integer', 'min:0', 'max:6'],
            'max_capacity' => ['nullable', 'integer', 'min:1'],
            'reason' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
            'is_soft_limit' => ['nullable', 'boolean'],
        ];

        // Custom validation for target_id
        if ($request->target_type === 'category') {
            $rules['target_id'][] = 'exists:categories,id';
        } elseif ($request->target_type === 'service') {
            $rules['target_id'][] = 'exists:services,id';
        }

        // Validate time range
        if ($request->start_time && $request->end_time) {
            $request->validate([
                'end_time' => ['after:start_time']
            ]);
        }

        // Validate recurring days
        if ($request->type === 'recurring_closure' && empty($request->recurring_days)) {
            $rules['recurring_days'][] = 'required';
        }

        return $request->validate($rules);
    }
}
