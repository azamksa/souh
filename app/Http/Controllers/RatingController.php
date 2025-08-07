<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Trip;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * إضافة أو تحديث تقييم
     */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        Rating::addRating(
            $request->trip_id,
            auth()->id(),
            $request->rating,
            $request->review
        );

        return redirect()->back()->with('success', 'تم إضافة تقييمك بنجاح');
    }

    /**
     * عرض تقييمات الرحلة
     */
    public function show(Trip $trip)
    {
        $ratings = Rating::with('user')
            ->where('trip_id', $trip->id)
            ->latest()
            ->paginate(10);

        $userRating = null;
        if (auth()->check()) {
            $userRating = Rating::where('trip_id', $trip->id)
                               ->where('user_id', auth()->id())
                               ->first();
        }

        return view('ratings.show', compact('trip', 'ratings', 'userRating'));
    }

    /**
     * حذف تقييم (للمديرين فقط)
     */
    public function destroy(Rating $rating)
    {
        $tripId = $rating->trip_id;
        $rating->delete();
        
        // إعادة حساب متوسط التقييم
        Rating::updateTripRating($tripId);
        
        return redirect()->back()->with('success', 'تم حذف التقييم بنجاح');
    }
}