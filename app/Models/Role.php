<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasUuids;

    protected $fillable = [
        'uuid',
        'name',
        'guard_name',
        'description',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
