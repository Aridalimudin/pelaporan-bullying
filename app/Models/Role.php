<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'bg_color',
        'text_color',
        'is_system',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    /**
     * Permissions yang dimiliki role ini.
     * Pivot table: role_permission
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Users yang memiliki role ini.
     * Pivot table: user_role
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    /**
     * Cek apakah role ini punya permission tertentu (by slug).
     */
    public function hasPermission(string $slug): bool
    {
        return $this->permissions->pluck('slug')->contains($slug);
    }
}