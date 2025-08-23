<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Appointment extends BaseModel implements AuditableContract
{
    use Auditable;

    protected $fillable = [
        'psychologist_id',
        'patient_id',
        'start_time',
        'end_time',
        'complaints',
        'is_online',
        'status',
        'meet_url'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => AppointmentStatus::class,
        ];
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
