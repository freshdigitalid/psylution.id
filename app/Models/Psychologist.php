<?php

namespace App\Models;

use Parental\HasParent;

class Psychologist extends Person
{
    use HasParent;

    protected $fillable = [
        'experience',
        'education',
        'employment_start_date',
        'is_online',
        'is_offline'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'employment_start_date' => 'datetime',
        ];
    }

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'psychologists_specializations', 'psychologist_id', 'specialization_id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'psychologists_packages', 'psychologist_id', 'package_id');
    }
}
