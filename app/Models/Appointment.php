<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;

class Appointment extends BaseModel
{
    use Auditable;

    protected $fillable = [
        'psychologist_id',
        'patient_id',
        'start_time',
        'end_time',
        'complaints'
    ];

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
