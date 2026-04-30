<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nama'         => 'Ahmad Fauzi',
                'username'     => 'admin',
                'email'        => 'ahmad.fauzi@smkm3.sch.id',
                'password'     => Hash::make('admin123'),
                'status'       => 'aktif',
                'avatar_bg'    => '#fdf4ff',
                'avatar_color' => '#9333ea',
                'role_slug'    => 'superadmin',
            ],
            [
                'nama'         => 'Sari Dewi',
                'username'     => 'sari.dewi',
                'email'        => 'sari.dewi@smkm3.sch.id',
                'password'     => Hash::make('password123'),
                'status'       => 'aktif',
                'avatar_bg'    => '#f0fdf4',
                'avatar_color' => '#16a34a',
                'role_slug'    => 'kesiswaan',
            ],
            [
                'nama'         => 'Budi Santoso',
                'username'     => 'budi.santoso',
                'email'        => 'budi.santoso@smkm3.sch.id',
                'password'     => Hash::make('password123'),
                'status'       => 'aktif',
                'avatar_bg'    => '#eff6ff',
                'avatar_color' => '#3b82f6',
                'role_slug'    => 'guru-bk',
            ],
            [
                'nama'         => 'Rina Kartika',
                'username'     => 'rina.kartika',
                'email'        => 'rina.kartika@smkm3.sch.id',
                'password'     => Hash::make('password123'),
                'status'       => 'aktif',
                'avatar_bg'    => '#fff7ed',
                'avatar_color' => '#ea580c',
                'role_slug'    => 'wali-kelas',
            ],
            [
                'nama'         => 'Deni Pratama',
                'username'     => 'deni.pratama',
                'email'        => 'deni.pratama@smkm3.sch.id',
                'password'     => Hash::make('password123'),
                'status'       => 'aktif',
                'avatar_bg'    => '#f0fdf4',
                'avatar_color' => '#16a34a',
                'role_slug'    => 'kesiswaan',
            ],
            [
                'nama'         => 'Mega Wulandari',
                'username'     => 'mega.wulandari',
                'email'        => 'mega.wulandari@smkm3.sch.id',
                'password'     => Hash::make('password123'),
                'status'       => 'aktif',
                'avatar_bg'    => '#eff6ff',
                'avatar_color' => '#3b82f6',
                'role_slug'    => 'guru-bk',
            ],
            [
                'nama'         => 'Hendra Wijaya',
                'username'     => 'hendra.wijaya',
                'email'        => 'hendra.wijaya@smkm3.sch.id',
                'password'     => Hash::make('password123'),
                'status'       => 'nonaktif',
                'avatar_bg'    => '#f9fafb',
                'avatar_color' => '#6b7280',
                'role_slug'    => 'wali-kelas',
            ],
            [
                'nama'         => 'Putri Anggraini',
                'username'     => 'putri.anggraini',
                'email'        => 'putri.anggraini@smkm3.sch.id',
                'password'     => Hash::make('password123'),
                'status'       => 'nonaktif',
                'avatar_bg'    => '#f9fafb',
                'avatar_color' => '#6b7280',
                'role_slug'    => 'wali-kelas',
            ],
        ];

        foreach ($users as $userData) {
            $roleSlug = $userData['role_slug'];
            unset($userData['role_slug']);

            $user = User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );

            $role = Role::where('slug', $roleSlug)->first();
            if ($role) {
                // syncWithoutDetaching agar tidak hapus role lain kalau ada
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
        }
    }
}