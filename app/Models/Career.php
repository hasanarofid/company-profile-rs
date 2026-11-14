<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'employment_type',
        'location',
        'department_name',
        'description',
        'requirements',
        'benefits',
        'deadline',
        'is_active',
    ];

    protected $casts = [
        'requirements' => 'array',
        'benefits' => 'array',
        'deadline' => 'date:Y-m-d',
        'is_active' => 'boolean',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(CareerApplication::class);
    }
}
