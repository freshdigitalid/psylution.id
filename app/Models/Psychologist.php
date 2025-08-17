<?php

namespace App\Models;

use Parental\HasParent;

class Psychologist extends Person
{
    use HasParent;

    protected $fillable = [
        'experience',
        'education',
    ];

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, 'psychologists_specializations', 'psychologist_id', 'specialization_id');
    }
}
