<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentOrder extends BaseModel
{
    protected $fillable = [
        'appointment_id',
        'invoice_id',
        'amount',
        'status',
        'payment_method',
        'payment_channel',
        'payment_status',
        'customer_name',
        'customer_email',
        'data'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
            'payment_status' => PaymentStatus::class,
        ];
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}