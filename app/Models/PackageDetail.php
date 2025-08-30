<?php

namespace App\Models;

class PackageDetail extends BaseModel
{
    // disable soft delete
    public static function bootSoftDeletes() {}
    public function runSoftDelete() {}

    protected $table = 'package_details';

    protected $fillable = [
        'title',
        'description',
        'price',
        'is_online',
        'min_yoe',
        'max_yoe',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
