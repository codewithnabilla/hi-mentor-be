<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    protected $table = 'master.skills';

    /** @use HasFactory<\Database\Factories\SkillFactory> */
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'master.department_skill',
            'skill_uuid',
            'department_uuid',
            'uuid',
            'uuid'
        );
    }
}
