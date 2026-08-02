<?php

namespace App\Http\Controllers;

use App\Models\CategoryDailyLimit;
use Illuminate\Http\Request;

class CategoryDailyLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limits = CategoryDailyLimit::with('category')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $limits,
        ]);
    }

    /**
     * Store or update a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'max_limit' => 'required|integer|min:1',
        ]);

        $limit = CategoryDailyLimit::updateOrCreate(
            [
                'category_id' => $validated['category_id'],
                'date' => $validated['date'],
            ],
            [
                'max_limit' => $validated['max_limit'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Category daily limit saved successfully.',
            'data' => $limit,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryDailyLimit $categoryDailyLimit)
    {
        return response()->json([
            'success' => true,
            'data' => $categoryDailyLimit->load('category'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryDailyLimit $categoryDailyLimit)
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'date' => 'sometimes|date',
            'max_limit' => 'sometimes|integer|min:1',
        ]);

        $categoryDailyLimit->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category daily limit updated successfully.',
            'data' => $categoryDailyLimit->load('category'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryDailyLimit $categoryDailyLimit)
    {
        $categoryDailyLimit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category daily limit deleted successfully.',
        ]);
    }
}