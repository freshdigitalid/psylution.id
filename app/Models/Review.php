<?php

namespace App\Models;

class Review extends BaseModel
{ 
    // disable soft delete
    public static function bootSoftDeletes() {}
    public function runSoftDelete() {}

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
