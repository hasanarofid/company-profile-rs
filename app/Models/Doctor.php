<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'slug',
        'specialization',
        'sub_specialization',
        'sip_number',
        'photo',
        'education',
        'experience_years',
        'bio',
        'consultation_fee',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'experience_years' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class)->orderBy('day_order')->orderBy('start_time');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}

