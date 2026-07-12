<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'route',
        'icon',
        'parent_uuid',
        'order',
        'permission',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function parent()
    {
        return $this->belongsTo(
            Menu::class,
            'parent_uuid',
            'uuid'
        );
    }

    public function children()
    {
        return $this->hasMany(
            Menu::class,
            'parent_uuid',
            'uuid'
        )->orderBy('order');
    }
}
