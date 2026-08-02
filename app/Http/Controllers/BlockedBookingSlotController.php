<?php

namespace App\Http\Controllers;

use App\Models\BlockedBookingSlot;
use Illuminate\Http\Request;

class BlockedBookingSlotController extends Controller
{
    /**
     * Display a listing of blocked booking slots.
     */
    public function index()
    {
        $blockedSlots = BlockedBookingSlot::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $blockedSlots,
        ]);
    }

    /**
     * Store a newly created blocked booking slot in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'days_of_week' => ['nullable', 'array'],
            'days_of_week.*' => ['integer', 'between:0,6'], // 0 = Sunday, 1 = Monday, etc.
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $blockedSlot = BlockedBookingSlot::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Blocked booking slot created successfully.',
            'data' => $blockedSlot,
        ], 201);
    }

    /**
     * Display the specified blocked booking slot.
     */
    public function show(BlockedBookingSlot $blockedBookingSlot)
    {
        return response()->json([
            'success' => true,
            'data' => $blockedBookingSlot,
        ]);
    }

    /**
     * Update the specified blocked booking slot in storage.
     */
    public function update(Request $request, BlockedBookingSlot $blockedBookingSlot)
    {
        $validated = $request->validate([
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['sometimes', 'required', 'date', 'after_or_equal:start_date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'days_of_week' => ['nullable', 'array'],
            'days_of_week.*' => ['integer', 'between:0,6'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $blockedBookingSlot->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Blocked booking slot updated successfully.',
            'data' => $blockedBookingSlot,
        ]);
    }

    /**
     * Remove the specified blocked booking slot from storage.
     */
    public function destroy(BlockedBookingSlot $blockedBookingSlot)
    {
        $blockedBookingSlot->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blocked booking slot deleted successfully.',
        ]);
    }
}