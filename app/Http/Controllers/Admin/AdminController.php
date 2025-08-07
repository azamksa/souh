<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use App\Models\Request as TripRequest;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        // إحصائيات عامة
        $stats = [
            'total_trips' => Trip::count(),
            'active_trips' => Trip::where('is_active', true)->count(),
            'inactive_trips' => Trip::where('is_active', false)->count(),
            'featured_trips' => Trip::where('is_featured', true)->count(),
            
            'total_users' => User::where('is_admin', false)->count(),
            'active_users' => User::where('is_admin', false)->where('is_active', true)->count(),
            'inactive_users' => User::where('is_admin', false)->where('is_active', false)->count(),
            'admin_users' => User::where('is_admin', true)->count(),
            
            'total_requests' => TripRequest::count(),
            'pending_requests' => TripRequest::where('status', 'pending')->count(),
            'approved_requests' => TripRequest::where('status', 'approved')->count(),
            'rejected_requests' => TripRequest::where('status', 'rejected')->count(),
            
            'total_ratings' => Rating::count(),
            'average_rating' => Rating::avg('rating') ?: 0,
            'ratings_with_reviews' => Rating::whereNotNull('review')->where('review', '!=', '')->count(),
            'five_star_ratings' => Rating::where('rating', 5)->count(),
        ];

        // إحصائيات شهرية (آخر 12 شهر)
        $monthlyStats = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            $monthlyStats->push([
                'month' => $date->format('M Y'),
                'month_ar' => $this->getArabicMonth($date->format('n')) . ' ' . $date->format('Y'),
                'trips' => Trip::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
                'requests' => TripRequest::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
                'ratings' => Rating::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
                'users' => User::where('is_admin', false)->whereBetween('created_at', [$monthStart, $monthEnd])->count(),
            ]);
        }

        // أفضل الرحلات حسب التقييم
        $topRatedTrips = Trip::withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->having('ratings_count', '>=', 3)
            ->orderBy('ratings_avg_rating', 'desc')
            ->take(10)
            ->get();

        // أكثر الرحلات طلباً
        $mostRequestedTrips = Trip::withCount('requests')
            ->having('requests_count', '>', 0)
            ->orderBy('requests_count', 'desc')
            ->take(10)
            ->get();

        // إحصائيات التقييمات
        $ratingDistribution = Rating::select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->pluck('count', 'rating')
            ->toArray();

        // ملء التقييمات المفقودة بصفر
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }
        ksort($ratingDistribution);

        // أحدث الأنشطة
        $recentActivities = collect();
        
        // أحدث الطلبات
        TripRequest::with(['user', 'trip'])
            ->latest()
            ->take(5)
            ->get()
            ->each(function ($request) use ($recentActivities) {
                $recentActivities->push([
                    'type' => 'request',
                    'icon' => 'fa-clipboard-list',
                    'color' => $request->status === 'pending' ? 'yellow' : ($request->status === 'approved' ? 'green' : 'red'),
                    'title' => 'طلب رحلة جديد',
                    'description' => $request->user->name . ' طلب رحلة ' . $request->trip->title,
                    'time' => $request->created_at,
                ]);
            });

        // أحدث التقييمات
        Rating::with(['user', 'trip'])
            ->latest()
            ->take(5)
            ->get()
            ->each(function ($rating) use ($recentActivities) {
                $recentActivities->push([
                    'type' => 'rating',
                    'icon' => 'fa-star',
                    'color' => 'yellow',
                    'title' => 'تقييم جديد',
                    'description' => $rating->user->name . ' قيّم رحلة ' . $rating->trip->title . ' بـ ' . $rating->rating . ' نجوم',
                    'time' => $rating->created_at,
                ]);
            });

        // أحدث المستخدمين
        User::where('is_admin', false)
            ->latest()
            ->take(5)
            ->get()
            ->each(function ($user) use ($recentActivities) {
                $recentActivities->push([
                    'type' => 'user',
                    'icon' => 'fa-user-plus',
                    'color' => 'blue',
                    'title' => 'عضو جديد',
                    'description' => 'انضم ' . $user->name . ' إلى الموقع',
                    'time' => $user->created_at,
                ]);
            });

        $recentActivities = $recentActivities->sortByDesc('time')->take(15);

        // التقييمات الأخيرة مع التفاصيل
        $recentRatings = Rating::with(['user', 'trip'])
            ->latest()
            ->take(10)
            ->get();

        // إحصائيات الوجهات
        $destinationStats = Trip::select('destination', DB::raw('count(*) as trips_count'), 
                                       DB::raw('AVG(average_rating) as avg_rating'),
                                       DB::raw('SUM(total_ratings) as total_ratings'))
            ->groupBy('destination')
            ->orderBy('trips_count', 'desc')
            ->get();

        return view('admin.reports.index', compact(
            'stats',
            'monthlyStats',
            'topRatedTrips',
            'mostRequestedTrips',
            'ratingDistribution',
            'recentActivities',
            'recentRatings',
            'destinationStats'
        ));
    }

    private function getArabicMonth($monthNumber)
    {
        $months = [
            1 => 'يناير',
            2 => 'فبراير',
            3 => 'مارس',
            4 => 'أبريل',
            5 => 'مايو',
            6 => 'يونيو',
            7 => 'يوليو',
            8 => 'أغسطس',
            9 => 'سبتمبر',
            10 => 'أكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر'
        ];

        return $months[$monthNumber];
    }

    public function exportData(Request $request)
    {
        $type = $request->get('type', 'all');
        
        // تصدير البيانات بصيغة CSV أو PDF
        // يمكن تطوير هذه الوظيفة لاحقاً
        
        return response()->json([
            'success' => true,
            'message' => 'سيتم تطوير وظيفة التصدير قريباً'
        ]);
    }
}