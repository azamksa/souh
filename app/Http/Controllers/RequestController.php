<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\Trip;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function create(Trip $trip)
    {
        return view('requests.create', compact('trip'));
    }

    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        Request::create($validated);

        return redirect()->route('requests.index')->with('success', 'تم إرسال الطلب بنجاح');
    }

    public function index()
    {
        $requests = Request::where('user_id', auth()->id())->get();
        return view('requests.index', compact('requests'));
    }
}