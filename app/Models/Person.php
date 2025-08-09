<?php

namespace App\Models;

use Parental\HasChildren;

class Person extends BaseModel
{
    use HasChildren;
    protected $table = 'persons';

    protected $fillable = [
        'first_name',
        'last_name',
        'type'
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
