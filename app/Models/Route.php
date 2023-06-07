<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_location_lat',
        'start_location_lng',
        'end_location_lat',
        'end_location_lng',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'route_likes', 'route_id', 'user_id');
    }

    public function likedByCurrentUser()
{
    $userId = auth()->user()->id;

    return $this->likes()->where('user_id', $userId)->exists();
}

}
