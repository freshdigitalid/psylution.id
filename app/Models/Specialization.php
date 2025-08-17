<?php

namespace App\Models;

class Specialization extends BaseModel
{
    protected $table = 'specializations';

    protected $fillable = [
        'specialization_name',
    ];

    public function psychologists()
    {
        return $this->belongsToMany(Psychologist::class, 'psychologists_specializations', 'specialization_id', 'psychologist_id');
    }
}
