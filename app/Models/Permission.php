<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'nama',
        'slug',
        'group',
        'aksi',
        'deskripsi',
        'is_protected',
    ];

    protected $casts = [
        'is_protected' => 'boolean',
    ];

    /**
     * Roles yang memiliki permission ini.
     * Pivot table: role_permission
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }
}