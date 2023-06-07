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
}
