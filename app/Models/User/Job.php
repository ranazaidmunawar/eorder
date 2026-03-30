<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    protected $fillable = [
        'jcategory_id',
        'language_id',
        'user_id',
        'title',
        'slug',
        'vacancy',
        'deadline',
        'experience',
        'job_responsibilities',
        'employment_status',
        'educational_requirements',
        'experience_requirements',
        'additional_requirements',
        'job_location',
        'salary',
        'benefits',
        'read_before_apply',
        'email',
        'serial_number',
        'meta_keywords',
        'meta_description'
    ];

    public function jcategory(): BelongsTo
    {
        return $this->belongsTo(Jcategory::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
