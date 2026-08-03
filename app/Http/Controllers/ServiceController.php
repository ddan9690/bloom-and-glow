<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->latest()->paginate(10);
        return view('backend.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::where('available', 'yes')->get();
        return view('backend.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:yes,no',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);

        return redirect()->route('management.services.index')->with('success', 'Service created successfully.');
    }

    public function show(Service $service, $slug = null)
    {
        $service->load('category');
        return view('backend.services.show', compact('service'));
    }

    public function edit(Service $service, $slug = null)
    {
        $categories = Category::where('available', 'yes')->get();
        return view('backend.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:yes,no',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('management.services.index')->with('success', 'Service updated successfully.');
    }

    public function toggleStatus(Service $service, $slug = null)
    {
        $newStatus = ($service->status ?? $service->available) === 'yes' ? 'no' : 'yes';
        $service->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Service status updated successfully.');
    }

    public function destroy(Service $service, $slug = null)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('management.services.index')->with('success', 'Service deleted successfully.');
    }
}
