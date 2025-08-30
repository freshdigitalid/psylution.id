<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'type',
        'price',
        'currency',
        'duration_minutes',
        'description',
        'features',
        'psychologist_criteria',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'psychologist_criteria' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
