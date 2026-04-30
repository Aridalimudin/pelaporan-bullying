<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViolationTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('violation_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('violation_types')->insert([
            ['name' => 'Penghinaan & Ejekan',         'category' => 'Verbal',     'description' => 'Menghina, mengejek, atau merendahkan korban melalui kata-kata secara langsung.',                             'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ancaman & Intimidasi Lisan',  'category' => 'Verbal',     'description' => 'Mengancam atau mengintimidasi korban secara lisan untuk memaksanya menuruti keinginan pelaku.',              'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gosip & Fitnah',              'category' => 'Verbal',     'description' => 'Menyebarkan rumor atau informasi palsu tentang korban untuk merusak reputasinya.',                           'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Membentak & Meneriaki',       'category' => 'Verbal',     'description' => 'Berteriak atau membentak korban di depan umum untuk mempermalukan dan merendahkan.',                         'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meremehkan & Merendahkan',    'category' => 'Verbal',     'description' => 'Secara verbal meremehkan kemampuan atau latar belakang korban untuk menurunkan kepercayaan dirinya.',         'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kekerasan Fisik',             'category' => 'Non-Verbal', 'description' => 'Tindakan menyakiti secara fisik seperti memukul, menendang, atau mendorong yang menyebabkan rasa sakit.',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Merusak / Mengambil Barang',  'category' => 'Non-Verbal', 'description' => 'Sengaja merusak, menyembunyikan, atau mengambil barang milik korban sebagai bentuk intimidasi.',             'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pengucilan Sosial',           'category' => 'Non-Verbal', 'description' => 'Mengasingkan korban dari kelompok pertemanan melalui tindakan non-verbal secara sengaja.',                   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gestur & Ekspresi Mengancam', 'category' => 'Non-Verbal', 'description' => 'Menggunakan gestur tubuh atau mimik wajah yang bersifat mengancam atau merendahkan korban.',                 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cyberbullying',               'category' => 'Non-Verbal', 'description' => 'Perundungan melalui media sosial, pesan digital, atau platform online.',                                     'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manipulasi & Pengisolasian',  'category' => 'Non-Verbal', 'description' => 'Memanipulasi hubungan sosial korban untuk mengisolasinya dari lingkungan pertemanan.',                       'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->command->info('✓ Violation Types: ' . DB::table('violation_types')->count() . ' data');
    }
}