<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'title',
        'slug',
        'description',
        'status', // draft, pending, approved, rejected
        'thumbnail',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function images()
    {
        return $this->hasMany(PortfolioImage::class);
    }
}
