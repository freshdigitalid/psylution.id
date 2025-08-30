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
        return $this->belongsToMany(Person::class, 'persons_locations', 'location_id', 'person_id');
    }
}
