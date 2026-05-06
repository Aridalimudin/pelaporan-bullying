<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────────────────
        // 1. PERMISSIONS
        // ─────────────────────────────────────────────────────
        $permissions = [

            // Grup: Master Data
            [
                'nama'         => 'Kelola Master Data',
                'slug'         => 'manage-master-data',
                'group'        => 'Master Data',
                'aksi'         => 'manage',
                'deskripsi'    => 'Mengelola data siswa, jurusan, kelas, jenis pelanggaran, dan tindakan disiplin.',
                'is_protected' => false,
            ],
            // Grup: Laporan
            [
                'nama'         => 'Lihat Laporan',
                'slug'         => 'view-laporan',
                'group'        => 'Laporan',
                'aksi'         => 'read',
                'deskripsi'    => 'Melihat daftar dan detail laporan bullying yang masuk.',
                'is_protected' => true,
            ],
            [
                'nama'         => 'Buat Laporan',
                'slug'         => 'create-laporan',
                'group'        => 'Laporan',
                'aksi'         => 'write',
                'deskripsi'    => 'Membuat dan mengajukan laporan bullying baru ke sistem.',
                'is_protected' => false,
            ],
            [
                'nama'         => 'Verifikasi Laporan',
                'slug'         => 'verify-laporan',
                'group'        => 'Laporan',
                'aksi'         => 'write',
                'deskripsi'    => 'Memverifikasi laporan yang masuk sebelum diproses lebih lanjut.',
                'is_protected' => false,
            ],
            [
                'nama'         => 'Proses Laporan',
                'slug'         => 'process-laporan',
                'group'        => 'Laporan',
                'aksi'         => 'manage',
                'deskripsi'    => 'Melakukan tindak lanjut dan menyelesaikan laporan bullying.',
                'is_protected' => false,
            ],
            [
                'nama'         => 'Tolak Laporan',
                'slug'         => 'reject-laporan',
                'group'        => 'Laporan',
                'aksi'         => 'write',
                'deskripsi'    => 'Menolak laporan dengan alasan yang valid dan terdokumentasi.',
                'is_protected' => false,
            ],

            // Grup: User
            [
                'nama'         => 'Kelola User',
                'slug'         => 'manage-user',
                'group'        => 'User',
                'aksi'         => 'manage',
                'deskripsi'    => 'Menambah, mengedit, dan menghapus akun pengguna sistem.',
                'is_protected' => true,
            ],
            [
                'nama'         => 'Kelola Role',
                'slug'         => 'manage-role',
                'group'        => 'User',
                'aksi'         => 'manage',
                'deskripsi'    => 'Menambah dan mengatur role beserta hak akses yang dimiliki.',
                'is_protected' => true,
            ],
            [
                'nama'         => 'Kelola Permission',
                'slug'         => 'manage-permission',
                'group'        => 'User',
                'aksi'         => 'manage',
                'deskripsi'    => 'Menambah dan mengatur permission yang tersedia di sistem.',
                'is_protected' => true,
            ],

            // Grup: Analitik
            [
                'nama'         => 'Lihat Rekapitulasi',
                'slug'         => 'view-rekap',
                'group'        => 'Analitik',
                'aksi'         => 'read',
                'deskripsi'    => 'Melihat laporan rekapitulasi kasus per bulan dan semester.',
                'is_protected' => false,
            ],
            [
                'nama'         => 'Export Data',
                'slug'         => 'export-data',
                'group'        => 'Analitik',
                'aksi'         => 'read',
                'deskripsi'    => 'Mengunduh data laporan dalam format Excel atau PDF.',
                'is_protected' => false,
            ],

            // Grup: Sistem
            [
                'nama'         => 'Pengaturan Sistem',
                'slug'         => 'system-settings',
                'group'        => 'Sistem',
                'aksi'         => 'manage',
                'deskripsi'    => 'Mengakses dan mengubah pengaturan umum aplikasi.',
                'is_protected' => true,
            ],
            [
                'nama'         => 'Log Aktivitas',
                'slug'         => 'view-logs',
                'group'        => 'Sistem',
                'aksi'         => 'read',
                'deskripsi'    => 'Melihat riwayat aktivitas dan audit log seluruh pengguna.',
                'is_protected' => true,
            ],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['slug' => $perm['slug']],
                $perm
            );
        }

        // ─────────────────────────────────────────────────────
        // 2. ROLES + sync permissions
        // ─────────────────────────────────────────────────────
        $roles = [
            [
                'nama'       => 'Super Admin',
                'slug'       => 'superadmin',
                'deskripsi'  => 'Akses penuh ke seluruh fitur sistem tanpa batasan.',
                'bg_color'   => '#fdf4ff',
                'text_color' => '#9333ea',
                'is_system'  => true,
                // Super Admin dapat semua permission
                'perms'      => Permission::pluck('slug')->toArray(),
            ],
            [
                'nama'       => 'Kesiswaan',
                'slug'       => 'kesiswaan',
                'deskripsi'  => 'Mengelola laporan bullying, verifikasi, dan proses tindak lanjut.',
                'bg_color'   => '#f0fdf4',
                'text_color' => '#16a34a',
                'is_system'  => false,
                'perms'      => [
                    'view-laporan',
                    'create-laporan',
                    'verify-laporan',
                    'process-laporan',
                    'reject-laporan',
                    'view-rekap',
                    'export-data',
                    'manage-master-data',
                ],
            ],
            [
                'nama'       => 'Guru BK',
                'slug'       => 'guru-bk',
                'deskripsi'  => 'Memproses dan memberikan tindak lanjut pada laporan yang masuk.',
                'bg_color'   => '#eff6ff',
                'text_color' => '#3b82f6',
                'is_system'  => false,
                'perms'      => [
                    'view-laporan',
                    'verify-laporan',
                    'process-laporan',
                ],
            ],
            [
                'nama'       => 'Wali Kelas',
                'slug'       => 'wali-kelas',
                'deskripsi'  => 'Melihat laporan terkait kelas yang diampu dan menerima notifikasi.',
                'bg_color'   => '#fff7ed',
                'text_color' => '#ea580c',
                'is_system'  => false,
                'perms'      => [
                    'view-laporan',
                    'create-laporan',
                ],
            ],
        ];

        foreach ($roles as $roleData) {
            $permSlugs = $roleData['perms'];
            unset($roleData['perms']);

            $role = Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );

            // Sync permissions ke pivot table role_permission
            $permissionIds = Permission::whereIn('slug', $permSlugs)->pluck('id');
            $role->permissions()->sync($permissionIds);
        }
    }
}