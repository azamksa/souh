<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use App\Models\Rating;
use App\Models\Request as TripRequest; // لو عندك موديل للطلبات
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
{
    // إحصائيات الرحلات
    $totalTrips = Trip::count();
    $activeTrips = Trip::where('is_active', 1)->count();

    // إحصائيات المستخدمين
    $totalUsers = User::count();
    // لو عندك is_active للمستخدمين، عرفه مثل:
    // $activeUsers = User::where('is_active', 1)->count();

    // إحصائيات الطلبات
    $totalRequests = TripRequest::count();
    $pendingRequests = TripRequest::where('status', 'pending')->count();
    $approvedRequests = TripRequest::where('status', 'approved')->count();
    $rejectedRequests = TripRequest::where('status', 'rejected')->count();

    // إحصائيات التقييمات
    $totalRatings = Rating::count();
    $averageRating = Rating::avg('rating');

    $featuredTrips = Trip::where('is_featured', true)->count();
    $fiveStarRatings = Rating::where('rating', 5)->count();
    $ratingsWithReviews = Rating::whereNotNull('review')->count();

    // إحصائيات الوجهات
    $destinationStats = Trip::select(
        'destination',
        'id', // أضف هذا إذا كنت تحتاجه (أو احذفه من select لو مش لازم)
        DB::raw('count(*) as trips_count'),
        DB::raw('avg((select avg(rating) from ratings where ratings.trip_id = trips.id)) as avg_rating'),
        DB::raw('(select count(*) from ratings where ratings.trip_id = trips.id) as total_ratings')
    )
    ->groupBy('destination', 'id') // أضف 'id' هنا أو الأعمدة الأخرى حسب الموجود في select
    ->get();


    // أفضل الرحلات تقييماً
    $topRatedTrips = Trip::withCount('ratings')
        ->withAvg('ratings', 'rating')
        ->orderByDesc('ratings_avg_rating')
        ->take(8)
        ->get();

    // أكثر الرحلات طلباً
    $mostRequestedTrips = Trip::withCount('requests')
        ->orderByDesc('requests_count')
        ->take(8)
        ->get();

    // الأنشطة الأخيرة (مثال)
    $recentActivities = [
        [
            'title' => 'تمت إضافة رحلة جديدة',
            'description' => 'تمت إضافة رحلة إلى جدة',
            'time' => now()->subHours(5),
            'color' => 'green',
            'icon' => 'fa-plus-circle',
        ],
    ];

    // أحدث التقييمات
    $recentRatings = Rating::with('user', 'trip')
        ->orderByDesc('created_at')
        ->take(10)
        ->get();

    // الإحصائيات الشهرية
    $monthlyStats = Trip::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as trips')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // توزيع التقييمات
    $ratingDistribution = Rating::select('rating', DB::raw('count(*) as count'))
        ->groupBy('rating')
        ->pluck('count', 'rating')
        ->toArray();

    // تحضير مصفوف stats للعرض
    $stats = [
        'total_trips' => $totalTrips,
        'active_trips' => $activeTrips,
        'total_users' => $totalUsers,
        // 'active_users' => $activeUsers,
        'total_requests' => $totalRequests,
        'pending_requests' => $pendingRequests,
        'approved_requests' => $approvedRequests,
        'rejected_requests' => $rejectedRequests,
        'total_ratings' => $totalRatings,
        'average_rating' => $averageRating,
        'featured_trips' => $featuredTrips,
        'five_star_ratings' => $fiveStarRatings,
        'ratings_with_reviews' => $ratingsWithReviews,
    ];

    return view('reports.index', compact(
        'stats',
        'destinationStats',
        'topRatedTrips',
        'mostRequestedTrips',
        'recentActivities',
        'recentRatings',
        'monthlyStats',
        'ratingDistribution'
    ));
}

}
