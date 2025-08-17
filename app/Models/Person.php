<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Parental\HasChildren;

class Person extends BaseModel implements AuditableContract
{
    use HasChildren, Auditable;
    protected $table = 'persons';

    protected $fillable = [
        'first_name',
        'last_name',
        'description',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
        'user_id',
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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'locations_persons', 'person_id', 'location_id');
    }
}
