<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Schedule extends BaseModel
{
    // disable soft delete
    public static function bootSoftDeletes() {}
    public function runSoftDelete() {}
    
    protected $table = 'schedules';

    protected $fillable = [
        'psychologist_id',
        'start_time',
        'end_time',
        'break_start_time',
        'break_end_time',
    ];

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }
}
