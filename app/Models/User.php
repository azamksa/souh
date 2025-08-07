<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean'
        ];
    }

    // العلاقات
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    public function scopeRegularUsers($query)
    {
        return $query->where('is_admin', false);
    }

    // خصائص محسوبة
    public function getAverageRatingAttribute()
    {
        return $this->ratings->avg('rating') ?: 0;
    }

    public function getTotalRatingsAttribute()
    {
        return $this->ratings->count();
    }

    public function getTotalRequestsAttribute()
    {
        return $this->requests->count();
    }

    public function getApprovedRequestsAttribute()
    {
        return $this->requests->where('status', 'approved')->count();
    }

    public function getPendingRequestsAttribute()
    {
        return $this->requests->where('status', 'pending')->count();
    }

    public function getRejectedRequestsAttribute()
    {
        return $this->requests->where('status', 'rejected')->count();
    }

    // دوال مساعدة
    public function hasRatedTrip($tripId)
    {
        return $this->ratings()->where('trip_id', $tripId)->exists();
    }

    public function hasRequestedTrip($tripId)
    {
        return $this->requests()->where('trip_id', $tripId)->exists();
    }

    public function getLastRatingFor($tripId)
    {
        return $this->ratings()->where('trip_id', $tripId)->latest()->first();
    }

    public function getLastRequestFor($tripId)
    {
        return $this->requests()->where('trip_id', $tripId)->latest()->first();
    }

    // إحصائيات المستخدم
    public function getRatingStats()
    {
        $ratings = $this->ratings;
        
        return [
            'total' => $ratings->count(),
            'average' => $ratings->avg('rating') ?: 0,
            'five_stars' => $ratings->where('rating', 5)->count(),
            'four_stars' => $ratings->where('rating', 4)->count(),
            'three_stars' => $ratings->where('rating', 3)->count(),
            'two_stars' => $ratings->where('rating', 2)->count(),
            'one_star' => $ratings->where('rating', 1)->count(),
            'with_review' => $ratings->whereNotNull('review')->where('review', '!=', '')->count()
        ];
    }

    public function getRequestStats()
    {
        $requests = $this->requests;
        
        return [
            'total' => $requests->count(),
            'approved' => $requests->where('status', 'approved')->count(),
            'pending' => $requests->where('status', 'pending')->count(),
            'rejected' => $requests->where('status', 'rejected')->count(),
            'approval_rate' => $requests->count() > 0 ? 
                round(($requests->where('status', 'approved')->count() / $requests->count()) * 100, 1) : 0
        ];
    }

    // للأنشطة الأخيرة
    public function getRecentRatings($limit = 5)
    {
        return $this->ratings()->with('trip')->latest()->limit($limit)->get();
    }

    public function getRecentRequests($limit = 5)
    {
        return $this->requests()->with('trip')->latest()->limit($limit)->get();
    }

    // للتحقق من الصلاحيات
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isActive()
    {
        return $this->is_active;
    }

    public function canRate()
    {
        return $this->is_active && !$this->is_admin;
    }

    public function canRequest()
    {
        return $this->is_active && !$this->is_admin;
    }

    // إحصائيات عامة للمستخدمين
    public static function getUserStats()
    {
        return [
            'total' => static::count(),
            'active' => static::where('is_active', true)->count(),
            'inactive' => static::where('is_active', false)->count(),
            'admins' => static::where('is_admin', true)->count(),
            'regular' => static::where('is_admin', false)->count(),
            'with_ratings' => static::whereHas('ratings')->count(),
            'with_requests' => static::whereHas('requests')->count()
        ];
    }

    public static function getMonthlyRegistrations($months = 12)
    {
        $stats = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            $stats[] = [
                'month' => $date->format('Y-m'),
                'month_name' => $date->format('F Y'),
                'count' => static::where('is_admin', false)
                               ->whereBetween('created_at', [$monthStart, $monthEnd])
                               ->count(),
                'admin_count' => static::where('is_admin', true)
                                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                                    ->count()
            ];
        }
        
        return collect($stats);
    }
}