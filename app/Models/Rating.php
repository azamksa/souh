<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /**
     * علاقة مع الطلبات
     */
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    /**
     * علاقة مع التقييمات
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * الحصول على متوسط تقييمات المستخدم
     */
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?: 0;
    }

    /**
     * الحصول على عدد التقييمات
     */
    public function getTotalRatingsAttribute()
    {
        return $this->ratings()->count();
    }

    /**
     * الحصول على الطلبات المعلقة
     */
    public function getPendingRequestsAttribute()
    {
        return $this->requests()->where('status', 'pending')->count();
    }

    /**
     * الحصول على الطلبات الموافقة
     */
    public function getApprovedRequestsAttribute()
    {
        return $this->requests()->where('status', 'approved')->count();
    }

    /**
     * التحقق من أن المستخدم قيم رحلة معينة
     */
    public function hasRatedTrip($tripId)
    {
        return $this->ratings()->where('trip_id', $tripId)->exists();
    }

    /**
     * الحصول على تقييم المستخدم لرحلة معينة
     */
    public function getRatingForTrip($tripId)
    {
        return $this->ratings()->where('trip_id', $tripId)->first();
    }

    /**
     * الحصول على أحدث النشاطات
     */
    public function getRecentActivityAttribute()
    {
        $recentRequests = $this->requests()->latest()->take(3)->get();
        $recentRatings = $this->ratings()->latest()->take(3)->get();
        
        return [
            'requests' => $recentRequests,
            'ratings' => $recentRatings
        ];
    }

    /**
     * نطاق للمستخدمين النشطين
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * نطاق للمديرين
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * نطاق للمستخدمين العاديين
     */
    public function scopeRegular($query)
    {
        return $query->where('is_admin', false);
    }
}