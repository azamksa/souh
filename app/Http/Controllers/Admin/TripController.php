<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::latest()->paginate(10);
        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        return view('admin.trips.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'destination' => 'required|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image_url' => 'required|url',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        Trip::create($validated);

        return redirect()->route('admin.trips.index')->with('success', 'تمت إضافة الرحلة بنجاح');
    }

    public function edit(Trip $trip)
    {
        return view('admin.trips.edit', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'destination' => 'required|string',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image_url' => 'required|url',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $trip->update($validated);

        return redirect()->route('admin.trips.index')->with('success', 'تم تحديث الرحلة بنجاح');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('admin.trips.index')->with('success', 'تم حذف الرحلة بنجاح');
    }
}