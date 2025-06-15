<?php

// app/Models/Visit.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'visit_date',
        'pax_count',
    ];

    // Relationships
    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
}

