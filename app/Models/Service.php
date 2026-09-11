<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'title',
        'slug',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
