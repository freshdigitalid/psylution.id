<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Package extends BaseModel
{
    protected $table = 'packages';

    protected $fillable = [
        'title',
        'description',
        'slug',
    ];

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn($value, $attributes) => $value ?: Str::slug($attributes['title'])
        );
    }

    public function details()
    {
        return $this->hasMany(PackageDetail::class);
    }
}
