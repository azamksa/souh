<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Request;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Http\Request as HttpRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_trips' => Trip::count(),
            'total_requests' => Request::count(),
            'total_users' => User::count(),
            'total_ratings' => Rating::count(),
            'pending_requests' => Request::where('status', 'pending')->count(),
            'active_trips' => Trip::where('is_active', true)->count(),
            'recent_requests' => Request::with(['user', 'trip'])
                ->latest()
                ->take(5)
                ->get(),
            'recent_ratings' => Rating::with(['user', 'trip'])
                ->latest()
                ->take(5)
                ->get(),
            'top_rated_trips' => Trip::where('total_ratings', '>', 0)
                ->orderByDesc('average_rating')
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function requests()
    {
        $requests = Request::with(['user', 'trip'])
            ->latest()
            ->paginate(15);

        return view('admin.requests.index', compact('requests'));
    }

    public function updateRequestStatus(HttpRequest $request, Request $tripRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $tripRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function ratings()
    {
        $ratings = Rating::with(['user', 'trip'])
            ->latest()
            ->paginate(15);

        return view('admin.ratings.index', compact('ratings'));
    }

    public function users()
    {
        $users = User::withCount(['requests', 'ratings'])
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function toggleUserStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'تم تفعيل' : 'تم إلغاء تفعيل';
        return redirect()->back()->with('success', $status . ' المستخدم بنجاح');
    }
}