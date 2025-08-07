<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'rating',
        'review'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    // Events
    protected static function boot()
    {
        parent::boot();
        
        static::saved(function ($rating) {
            $rating->trip->updateRatingStats();
        });
        
        static::deleted(function ($rating) {
            $rating->trip->updateRatingStats();
        });
    }

    // Scopes
    public function scopeHighRating($query, $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    public function scopeLowRating($query, $maxRating = 2)
    {
        return $query->where('rating', '<=', $maxRating);
    }

    public function scopeWithReview($query)
    {
        return $query->whereNotNull('review')
                    ->where('review', '!=', '');
    }

    public function scopeRecentRatings($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // خصائص محسوبة
    public function getRatingInArabicAttribute()
    {
        $ratings = [
            1 => 'ضعيف جداً',
            2 => 'ضعيف',
            3 => 'متوسط',
            4 => 'جيد',
            5 => 'ممتاز'
        ];

        return $ratings[$this->rating] ?? 'غير محدد';
    }

    public function getRatingColorAttribute()
    {
        if ($this->rating >= 4) return 'green';
        if ($this->rating == 3) return 'yellow';
        return 'red';
    }

    public function getIsPositiveAttribute()
    {
        return $this->rating >= 4;
    }

    public function getIsNegativeAttribute()
    {
        return $this->rating <= 2;
    }

    // دوال إحصائية
    public static function getAverageRating()
    {
        return static::avg('rating') ?: 0;
    }

    public static function getRatingDistribution()
    {
        $distribution = [];
        $total = static::count();
        
        for ($i = 1; $i <= 5; $i++) {
            $count = static::where('rating', $i)->count();
            $percentage = $total > 0 ? round(($count / $total) * 100, 1) : 0;
            
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }
        
        return $distribution;
    }

    public static function getMonthlyRatings($months = 12)
    {
        $stats = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            $monthlyRatings = static::whereBetween('created_at', [$monthStart, $monthEnd])->get();
            
            $stats[] = [
                'month' => $date->format('Y-m'),
                'month_name' => $date->format('F Y'),
                'count' => $monthlyRatings->count(),
                'average' => $monthlyRatings->avg('rating') ?: 0,
                'with_review' => $monthlyRatings->where('review', '!=', null)->where('review', '!=', '')->count()
            ];
        }
        
        return collect($stats);
    }

    public static function getTopRatedTrips($limit = 10)
    {
        return static::select('trip_id')
            ->selectRaw('AVG(rating) as avg_rating')
            ->selectRaw('COUNT(*) as rating_count')
            ->with('trip')
            ->groupBy('trip_id')
            ->having('rating_count', '>=', 3)
            ->orderBy('avg_rating', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getRecentReviews($limit = 10)
    {
        return static::with(['user', 'trip'])
            ->whereNotNull('review')
            ->where('review', '!=', '')
            ->latest()
            ->limit($limit)
            ->get();
    }

    // للتحقق من صحة البيانات
    public static function rules()
    {
        return [
            'trip_id' => 'required|exists:trips,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000'
        ];
    }
}