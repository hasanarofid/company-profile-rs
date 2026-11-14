<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'department_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'patient_name',
        'patient_phone',
        'patient_email',
        'patient_dob',
        'patient_nik',
        'payment_type',
        'complaint',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'appointment_date' => 'date:Y-m-d',
        'patient_dob' => 'date:Y-m-d',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
