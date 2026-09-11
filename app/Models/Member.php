<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'availability',
        'verified',
        'bio',
        'cover_image',
        'profile_photo',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
