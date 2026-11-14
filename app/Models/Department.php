<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'icon',
        'image',
        'short_description',
        'description',
        'facilities',
        'location',
        'phone_ext',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'facilities' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
