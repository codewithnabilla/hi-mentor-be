<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mentor extends Model
{
    protected $table = 'master.mentors';

    /** @use HasFactory<\Database\Factories\MentorFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_uuid',
        'headline',
        'bio',
        'years_of_experience',
        'current_company',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'is_available',
        'is_active',
    ];

    protected $casts = [
        'years_of_experience' => 'integer',
        'is_available' => 'boolean',
        'is_active' => 'boolean',
    ];
}
