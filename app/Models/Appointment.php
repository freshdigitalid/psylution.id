<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Appointment extends BaseModel implements AuditableContract
{
    use Auditable;

    protected $fillable = [
        'user_id',
        'psychologist_id',
        'appointment_date',
        'appointment_time',
        'consultation_type',
        'complaint',
        'notes',
        'status'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
