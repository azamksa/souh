<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'status',
        'notes',
        'admin_notes',
        'processed_at',
        'processed_by'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    /**
     * علاقة مع الرحلة
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * علاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة مع المدير الذي عالج الطلب
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * الحصول على حالة الطلب باللغة العربية
     */
    public function getStatusInArabicAttribute()
    {
        $statuses = [
            'pending' => 'قيد المراجعة',
            'approved' => 'موافق عليه',
            'rejected' => 'مرفوض'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * الحصول على لون الحالة
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }

    /**
     * الحصول على أيقونة الحالة
     */
    public function getStatusIconAttribute()
    {
        $icons = [
            'pending' => 'fas fa-clock',
            'approved' => 'fas fa-check',
            'rejected' => 'fas fa-times'
        ];

        return $icons[$this->status] ?? 'fas fa-question';
    }

    /**
     * نطاق للطلبات المعلقة
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * نطاق للطلبات الموافقة
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * نطاق للطلبات المرفوضة
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * نطاق للطلبات الأحدث
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}