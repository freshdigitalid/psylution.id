<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Review extends BaseModel
{
    use HasUuids;
    
    protected $fillable = [
        'appointment_id',
        'reviewer_id',
        'score',
        'notes',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
