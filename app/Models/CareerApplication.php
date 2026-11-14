<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_id',
        'applicant_name',
        'email',
        'phone',
        'education',
        'experience_summary',
        'cv_path',
        'cover_letter',
        'status',
        'admin_notes',
    ];

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
    }
}

