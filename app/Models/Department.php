<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    protected $table = 'master.departments';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    use HasUuids, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'code',
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

    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            'master.department_skill',
            'department_uuid',
            'skill_uuid',
            'uuid',
            'uuid'
        );
    }
}
