<?php


// app/Models/Redemption.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'points',
        'redeemed_at',
    ];

    protected $dates = ['redeemed_at'];

    // Relationships
    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
}

