<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('students')->truncate();
        DB::table('grades')->truncate();
        DB::table('majors')->truncate();

        // ── Grades ──────────────────────────────
        DB::table('grades')->insert([
            ['name' => 'X',   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'XI',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'XII', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Majors ──────────────────────────────
        DB::table('majors')->insert([
            ['name' => 'RPL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'TKJ', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MM',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'AK',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PM',  'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Students ────────────────────────────
        $students = [
            // Kelas X RPL
            ['fullname' => 'Aldi Firmansyah',       'nis' => '2024001', 'grade' => 'X',   'major' => 'RPL', 'gender' => 'L', 'phone' => '081234567001', 'email' => 'aldi.f@siswa.sch.id',       'report_history' => 0],
            ['fullname' => 'Bunga Ramadhani',        'nis' => '2024002', 'grade' => 'X',   'major' => 'RPL', 'gender' => 'P', 'phone' => '081234567002', 'email' => 'bunga.r@siswa.sch.id',      'report_history' => 1],
            ['fullname' => 'Cahyo Nugroho',          'nis' => '2024003', 'grade' => 'X',   'major' => 'RPL', 'gender' => 'L', 'phone' => '081234567003', 'email' => 'cahyo.n@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Dewi Kusumawati',        'nis' => '2024004', 'grade' => 'X',   'major' => 'RPL', 'gender' => 'P', 'phone' => '081234567004', 'email' => 'dewi.k@siswa.sch.id',       'report_history' => 0],
            ['fullname' => 'Evan Prasetyo',          'nis' => '2024005', 'grade' => 'X',   'major' => 'RPL', 'gender' => 'L', 'phone' => '081234567005', 'email' => 'evan.p@siswa.sch.id',       'report_history' => 2],

            // Kelas X TKJ
            ['fullname' => 'Farah Aulia',            'nis' => '2024006', 'grade' => 'X',   'major' => 'TKJ', 'gender' => 'P', 'phone' => '081234567006', 'email' => 'farah.a@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Gilang Ramadhan',        'nis' => '2024007', 'grade' => 'X',   'major' => 'TKJ', 'gender' => 'L', 'phone' => '081234567007', 'email' => 'gilang.r@siswa.sch.id',     'report_history' => 3],
            ['fullname' => 'Hana Pertiwi',           'nis' => '2024008', 'grade' => 'X',   'major' => 'TKJ', 'gender' => 'P', 'phone' => '081234567008', 'email' => 'hana.p@siswa.sch.id',       'report_history' => 0],
            ['fullname' => 'Ilham Saputra',          'nis' => '2024009', 'grade' => 'X',   'major' => 'TKJ', 'gender' => 'L', 'phone' => '081234567009', 'email' => 'ilham.s@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Julia Anggraeni',        'nis' => '2024010', 'grade' => 'X',   'major' => 'TKJ', 'gender' => 'P', 'phone' => '081234567010', 'email' => 'julia.a@siswa.sch.id',      'report_history' => 1],

            // Kelas X MM
            ['fullname' => 'Kevin Setiawan',         'nis' => '2024011', 'grade' => 'X',   'major' => 'MM',  'gender' => 'L', 'phone' => '081234567011', 'email' => 'kevin.s@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Laila Nuraini',          'nis' => '2024012', 'grade' => 'X',   'major' => 'MM',  'gender' => 'P', 'phone' => '081234567012', 'email' => 'laila.n@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Muhammad Rizki',         'nis' => '2024013', 'grade' => 'X',   'major' => 'MM',  'gender' => 'L', 'phone' => '081234567013', 'email' => 'mrizki@siswa.sch.id',       'report_history' => 0],

            // Kelas XI RPL
            ['fullname' => 'Nadia Safitri',          'nis' => '2023001', 'grade' => 'XI',  'major' => 'RPL', 'gender' => 'P', 'phone' => '081234567014', 'email' => 'nadia.s@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Omar Abdillah',          'nis' => '2023002', 'grade' => 'XI',  'major' => 'RPL', 'gender' => 'L', 'phone' => '081234567015', 'email' => 'omar.a@siswa.sch.id',       'report_history' => 1],
            ['fullname' => 'Putri Handayani',        'nis' => '2023003', 'grade' => 'XI',  'major' => 'RPL', 'gender' => 'P', 'phone' => '081234567016', 'email' => 'putri.h@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Qori Hidayat',           'nis' => '2023004', 'grade' => 'XI',  'major' => 'RPL', 'gender' => 'L', 'phone' => '081234567017', 'email' => 'qori.h@siswa.sch.id',       'report_history' => 2],
            ['fullname' => 'Rini Wulandari',         'nis' => '2023005', 'grade' => 'XI',  'major' => 'RPL', 'gender' => 'P', 'phone' => '081234567018', 'email' => 'rini.w@siswa.sch.id',       'report_history' => 0],

            // Kelas XI TKJ
            ['fullname' => 'Sandi Pratama',          'nis' => '2023006', 'grade' => 'XI',  'major' => 'TKJ', 'gender' => 'L', 'phone' => '081234567019', 'email' => 'sandi.p@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Tika Aprilia',           'nis' => '2023007', 'grade' => 'XI',  'major' => 'TKJ', 'gender' => 'P', 'phone' => '081234567020', 'email' => 'tika.a@siswa.sch.id',       'report_history' => 0],
            ['fullname' => 'Umar Faruq',             'nis' => '2023008', 'grade' => 'XI',  'major' => 'TKJ', 'gender' => 'L', 'phone' => '081234567021', 'email' => 'umar.f@siswa.sch.id',       'report_history' => 4],
            ['fullname' => 'Vina Melinda',           'nis' => '2023009', 'grade' => 'XI',  'major' => 'TKJ', 'gender' => 'P', 'phone' => '081234567022', 'email' => 'vina.m@siswa.sch.id',       'report_history' => 0],
            ['fullname' => 'Wahyu Santoso',          'nis' => '2023010', 'grade' => 'XI',  'major' => 'TKJ', 'gender' => 'L', 'phone' => '081234567023', 'email' => 'wahyu.s@siswa.sch.id',      'report_history' => 1],

            // Kelas XI AK
            ['fullname' => 'Xena Claudia',           'nis' => '2023011', 'grade' => 'XI',  'major' => 'AK',  'gender' => 'P', 'phone' => '081234567024', 'email' => 'xena.c@siswa.sch.id',       'report_history' => 0],
            ['fullname' => 'Yusuf Aditya',           'nis' => '2023012', 'grade' => 'XI',  'major' => 'AK',  'gender' => 'L', 'phone' => '081234567025', 'email' => 'yusuf.a@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Zahra Maulida',          'nis' => '2023013', 'grade' => 'XI',  'major' => 'AK',  'gender' => 'P', 'phone' => '081234567026', 'email' => 'zahra.m@siswa.sch.id',      'report_history' => 0],

            // Kelas XII RPL
            ['fullname' => 'Agus Trianto',           'nis' => '2022001', 'grade' => 'XII', 'major' => 'RPL', 'gender' => 'L', 'phone' => '081234567027', 'email' => 'agus.t@siswa.sch.id',       'report_history' => 0],
            ['fullname' => 'Bella Oktavia',          'nis' => '2022002', 'grade' => 'XII', 'major' => 'RPL', 'gender' => 'P', 'phone' => '081234567028', 'email' => 'bella.o@siswa.sch.id',      'report_history' => 1],
            ['fullname' => 'Chandra Wijaya',         'nis' => '2022003', 'grade' => 'XII', 'major' => 'RPL', 'gender' => 'L', 'phone' => '081234567029', 'email' => 'chandra.w@siswa.sch.id',    'report_history' => 2],
            ['fullname' => 'Diana Puspita',          'nis' => '2022004', 'grade' => 'XII', 'major' => 'RPL', 'gender' => 'P', 'phone' => '081234567030', 'email' => 'diana.p@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Eko Budi Santoso',       'nis' => '2022005', 'grade' => 'XII', 'major' => 'RPL', 'gender' => 'L', 'phone' => '081234567031', 'email' => 'eko.b@siswa.sch.id',        'report_history' => 0],

            // Kelas XII TKJ
            ['fullname' => 'Fitri Rahayu',           'nis' => '2022006', 'grade' => 'XII', 'major' => 'TKJ', 'gender' => 'P', 'phone' => '081234567032', 'email' => 'fitri.r@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Guntur Prabowo',         'nis' => '2022007', 'grade' => 'XII', 'major' => 'TKJ', 'gender' => 'L', 'phone' => '081234567033', 'email' => 'guntur.p@siswa.sch.id',     'report_history' => 3],
            ['fullname' => 'Hesti Winarni',          'nis' => '2022008', 'grade' => 'XII', 'major' => 'TKJ', 'gender' => 'P', 'phone' => '081234567034', 'email' => 'hesti.w@siswa.sch.id',      'report_history' => 0],
            ['fullname' => 'Ivan Kurniawan',         'nis' => '2022009', 'grade' => 'XII', 'major' => 'TKJ', 'gender' => 'L', 'phone' => '081234567035', 'email' => 'ivan.k@siswa.sch.id',       'report_history' => 1],
            ['fullname' => 'Jihan Fauziah',          'nis' => '2022010', 'grade' => 'XII', 'major' => 'TKJ', 'gender' => 'P', 'phone' => '081234567036', 'email' => 'jihan.f@siswa.sch.id',      'report_history' => 0],

            // Kelas XII PM
            ['fullname' => 'Krisna Bayu',            'nis' => '2022011', 'grade' => 'XII', 'major' => 'PM',  'gender' => 'L', 'phone' => '081234567037', 'email' => 'krisna.b@siswa.sch.id',     'report_history' => 0],
            ['fullname' => 'Leni Susanti',           'nis' => '2022012', 'grade' => 'XII', 'major' => 'PM',  'gender' => 'P', 'phone' => '081234567038', 'email' => 'leni.s@siswa.sch.id',       'report_history' => 0],
            ['fullname' => 'Mirza Fadillah',         'nis' => '2022013', 'grade' => 'XII', 'major' => 'PM',  'gender' => 'L', 'phone' => '081234567039', 'email' => 'mirza.f@siswa.sch.id',      'report_history' => 2],
        ];

        foreach ($students as $s) {
            DB::table('students')->insert(array_merge($s, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $this->command->info('✓ Grades  : ' . DB::table('grades')->count() . ' data');
        $this->command->info('✓ Majors  : ' . DB::table('majors')->count() . ' data');
        $this->command->info('✓ Students: ' . DB::table('students')->count() . ' data');
    }
}