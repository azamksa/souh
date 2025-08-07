<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'is_featured',
        'is_active',
        'average_rating',
        'total_ratings'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'average_rating' => 'decimal:2',
        'total_ratings' => 'integer'
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
     * الحصول على أحدث التقييمات
     */
    public function latestRatings($limit = 5)
    {
        return $this->ratings()->with('user')->latest()->take($limit)->get();
    }

    /**
     * الحصول على تقييم المستخدم الحالي
     */
    public function userRating($userId)
    {
        return $this->ratings()->where('user_id', $userId)->first();
    }

    /**
     * حساب توزيع النجوم
     */
    public function getRatingDistribution()
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $this->ratings()->where('rating', $i)->count();
            $percentage = $this->total_ratings > 0 ? round(($count / $this->total_ratings) * 100, 1) : 0;
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }
        return $distribution;
    }

    /**
     * الحصول على النجوم كنص
     */
    public function getStarsAttribute()
    {
        $fullStars = floor($this->average_rating);
        $hasHalfStar = $this->average_rating - $fullStars >= 0.5;
        
        return [
            'full' => $fullStars,
            'half' => $hasHalfStar ? 1 : 0,
            'empty' => 5 - $fullStars - ($hasHalfStar ? 1 : 0)
        ];
    }

    /**
     * نطاق للرحلات النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * نطاق للرحلات المميزة
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * نطاق للرحلات الأعلى تقييماً
     */
    public function scopeTopRated($query)
    {
        return $query->where('total_ratings', '>', 0)->orderByDesc('average_rating');
    }

    /**
     * الحصول على مدة الرحلة بالأيام
     */
    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * الحصول على السعر مع التنسيق
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0) . ' ريال';
    }
}