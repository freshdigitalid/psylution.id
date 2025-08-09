<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Psikolog extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'psikologs';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'license_number',
        'specialization',
        'experience_years',
        'is_active',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'experience_years' => 'integer',
        ];
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isVerified(): bool
    {
        return $this->is_verified;
    }
} 