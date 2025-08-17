<?php

namespace App\Models;

use App\Enums\UserRole;
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
        'password',
        'role'
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
            'role' => UserRole::class,
        ];
    }

    /**
     * Get the panel instance associated with the user.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return (
            ($this->role === UserRole::Admin && $panel->getId() === 'admin') ||
            ($this->role === UserRole::Patient && $panel->getId() === 'patient') ||
            ($this->role === UserRole::Psychologist && $panel->getId() === 'psychologist')
        );
    }

    /**
     * Get the user's social providers.
     */
    public function providers()
    {
        return $this->hasMany(Provider::class);
    }
    
    /**
     * Get the user's person profile.
     */
    public function person()
    {
        return $this->hasOne(Person::class);
    }
}
