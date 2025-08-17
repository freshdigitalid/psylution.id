<?php

namespace App\Models;

class Location extends BaseModel
{
    protected $table = 'locations';

    protected $fillable = [
        'location_name',
    ];

    public function persons()
    {
        return $this->belongsToMany(Person::class, 'locations_persons', 'location_id', 'person_id');
    }
}
