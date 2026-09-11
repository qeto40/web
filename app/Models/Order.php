<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'member_id',
        'service_id',
        'order_number',
        'brief',
        'budget',
        'deadline',
        'status', // pending, processing, in_progress, revision, completed
    ];

    protected $casts = [
        'budget' => 'integer',
        'deadline' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function files()
    {
        return $this->hasMany(OrderFile::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
