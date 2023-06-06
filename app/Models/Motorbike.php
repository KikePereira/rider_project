<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorbike extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'adquired_at',
        'registration_number',
        'user_id',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
