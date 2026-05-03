<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'status',
        'avatar_bg',
        'avatar_color',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // ──────────────────────────────────────────────────────────
    // RELASI
    // ──────────────────────────────────────────────────────────

    /**
     * Roles yang dimiliki user ini.
     * Pivot table: user_role
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    // ──────────────────────────────────────────────────────────
    // HELPER METHODS
    // ──────────────────────────────────────────────────────────

    /**
     * Ambil semua permission dari seluruh role yang dimiliki user.
     * Hasilnya di-deduplicate berdasarkan id.
     */
    public function getAllPermissions(): Collection
    {
        return $this->roles
            ->flatMap(fn($role) => $role->permissions)
            ->unique('id')
            ->values();
    }

    /**
     * Cek apakah user punya permission tertentu (by slug).
     */
    public function hasPermission(string $slug): bool
    {
        return $this->getAllPermissions()->pluck('slug')->contains($slug);
    }

    /**
     * Cek apakah user punya role tertentu (by slug).
     */
    public function hasRole(string $slug): bool
    {
        return $this->roles->pluck('slug')->contains($slug);
    }

    /**
     * Ambil role pertama user (untuk ditampilkan di UI).
     */
    public function getPrimaryRole(): ?Role
    {
        return $this->roles->first();
    }
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class)->latest();
    }

    public function unreadNotifications()
    {
        return $this->hasMany(\App\Models\Notification::class)
                    ->whereNull('read_at')
                    ->latest();
    }
}