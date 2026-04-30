<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisciplineActionSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('discipline_actions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('discipline_actions')->insert([
            [
                'name' => 'Teguran Lisan', 'level' => 'Ringan', 'duration' => 'Saat itu',
                'executor' => 'Wali Kelas', 'parent_involvement' => 'tidak',
                'description' => 'Teguran secara langsung kepada pelaku untuk menghentikan perilaku bullying dan memberikan peringatan awal.',
                'condition' => 'Pelanggaran pertama kali dan bersifat ringan.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Surat Peringatan', 'level' => 'Ringan', 'duration' => 'Permanen',
                'executor' => 'Wali Kelas', 'parent_involvement' => 'tidak',
                'description' => 'Pemberian surat peringatan tertulis yang dicatat dalam buku catatan pelanggaran siswa.',
                'condition' => 'Pelanggaran berulang setelah teguran lisan.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Konseling Individual', 'level' => 'Ringan', 'duration' => '1-3 sesi',
                'executor' => 'Guru BK', 'parent_involvement' => 'tidak',
                'description' => 'Sesi konseling tatap muka untuk memahami akar masalah dan memberikan pembinaan karakter kepada pelaku.',
                'condition' => 'Pelanggaran verbal ringan atau pengucilan sosial.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Mediasi dengan Korban', 'level' => 'Sedang', 'duration' => '1-2 hari',
                'executor' => 'Guru BK', 'parent_involvement' => 'opsional',
                'description' => 'Pertemuan terfasilitasi antara pelaku dan korban untuk menyelesaikan konflik dan membangun rekonsiliasi.',
                'condition' => 'Konflik interpersonal yang dapat diselesaikan secara damai.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Pemanggilan Orang Tua', 'level' => 'Sedang', 'duration' => '1 pertemuan',
                'executor' => 'Kesiswaan', 'parent_involvement' => 'ya',
                'description' => 'Pemanggilan resmi orang tua/wali untuk berdiskusi mengenai perilaku siswa dan menyusun rencana perbaikan bersama.',
                'condition' => 'Pelanggaran sedang atau berulang.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Skorsing 1-3 Hari', 'level' => 'Sedang', 'duration' => '1-3 hari',
                'executor' => 'Kepala Sekolah', 'parent_involvement' => 'ya',
                'description' => 'Pemberhentian sementara dari kegiatan sekolah selama 1-3 hari sebagai konsekuensi atas pelanggaran yang serius.',
                'condition' => 'Pelanggaran fisik ringan atau bullying verbal yang berulang.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Pembinaan Intensif BK', 'level' => 'Sedang', 'duration' => '2 minggu',
                'executor' => 'Guru BK', 'parent_involvement' => 'ya',
                'description' => 'Program pembinaan karakter intensif oleh Guru BK yang meliputi konseling, refleksi, dan kegiatan sosial positif.',
                'condition' => 'Pelaku dengan pola perilaku agresif berulang.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Skorsing 1-2 Minggu', 'level' => 'Berat', 'duration' => '1-2 minggu',
                'executor' => 'Kepala Sekolah', 'parent_involvement' => 'ya',
                'description' => 'Pemberhentian sementara jangka panjang dengan kewajiban orang tua menandatangani surat pernyataan kesanggupan.',
                'condition' => 'Kekerasan fisik berat atau intimidasi serius yang terdokumentasi.',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Dikeluarkan dari Sekolah', 'level' => 'Berat', 'duration' => 'Permanen',
                'executor' => 'Kepala Sekolah', 'parent_involvement' => 'ya',
                'description' => 'Pengeluaran permanen dari sekolah sebagai tindakan terakhir atas pelanggaran berat yang mengancam keselamatan siswa.',
                'condition' => 'Kekerasan ekstrem, ancaman berbahaya, atau pelanggaran berulang.',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        $this->command->info('✓ Discipline Actions: ' . DB::table('discipline_actions')->count() . ' data');
    }
}