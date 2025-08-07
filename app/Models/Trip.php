<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'destination',
        'price',
        'start_date',
        'end_date',
        'image_url',
        'is_active',
        'is_featured',
        'average_rating',
        'total_ratings'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'average_rating' => 'decimal:2'
    ];

    // العلاقات
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // الخصائص المحسوبة
    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price) . ' ريال';
    }

    // دوال التقييم
    public function updateRatingStats()
    {
        $ratings = $this->ratings;
        
        if ($ratings->count() > 0) {
            $this->average_rating = $ratings->avg('rating');
            $this->total_ratings = $ratings->count();
        } else {
            $this->average_rating = 0;
            $this->total_ratings = 0;
        }
        
        $this->save();
    }

    public function userRating($userId)
    {
        return $this->ratings()->where('user_id', $userId)->first();
    }

    public function latestRatings($limit = 10)
    {
        return $this->ratings()
            ->with('user')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getRatingDistribution()
    {
        $distribution = [];
        $total = $this->ratings->count();
        
        for ($i = 1; $i <= 5; $i++) {
            $count = $this->ratings->where('rating', $i)->count();
            $percentage = $total > 0 ? round(($count / $total) * 100, 1) : 0;
            
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }
        
        return $distribution;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeWithHighRating($query, $minRating = 4)
    {
        return $query->where('average_rating', '>=', $minRating)
                    ->where('total_ratings', '>=', 3);
    }

    // للبحث والفلترة
    public function scopeByDestination($query, $destination)
    {
        return $query->where('destination', 'like', '%' . $destination . '%');
    }

    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate);
    }

    // للإحصائيات
    public static function getPopularDestinations($limit = 10)
    {
        return static::select('destination')
            ->selectRaw('COUNT(*) as trips_count')
            ->selectRaw('AVG(average_rating) as avg_rating')
            ->selectRaw('SUM(total_ratings) as total_ratings')
            ->groupBy('destination')
            ->orderBy('trips_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getMonthlyStats($months = 12)
    {
        $stats = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            $stats[] = [
                'month' => $date->format('Y-m'),
                'month_name' => $date->format('F Y'),
                'count' => static::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
                'active_count' => static::whereBetween('created_at', [$monthStart, $monthEnd])
                                      ->where('is_active', true)->count()
            ];
        }
        
        return collect($stats);
    }
}