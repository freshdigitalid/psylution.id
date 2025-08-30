<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role_id',
        'is_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean'
        ];
    }

    /**
     * Get the panel instance associated with the user.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return (
            ($this->role->name === 'admin' && $panel->getId() === 'admin') ||
            ($this->role->name === 'patient' && $panel->getId() === 'patient') ||
            ($this->role->name === 'psychologist' && $panel->getId() === 'psychologist')
        );
    }

    /**
     * Get the user's role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user's social providers.
     */
    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    /**
     * Get the user's OTP codes.
     */
    public function otps()
    {
        return $this->hasMany(UserOtp::class);
    }

    public function isAuthenticated(): bool
    {
        return $this->exists;
    }
}
