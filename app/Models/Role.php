<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Get the users that belong to this role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if the role is admin.
     */
    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    /**
     * Check if the role is psychologist.
     */
    public function isPsychologist(): bool
    {
        return $this->name === 'psychologist';
    }

    /**
     * Check if the role is patient.
     */
    public function isPatient(): bool
    {
        return $this->name === 'patient';
    }
}
