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
            ['name' => 'Ejekan',          'category' => 'Verbal',     'weight' => 2, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Julukan',         'category' => 'Verbal',     'weight' => 2, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Olok',            'category' => 'Verbal',     'weight' => 2, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Menghina',        'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Merendahkan',     'category' => 'Verbal',     'weight' => 2, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sindiran',        'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mempermalukan',   'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gosip',           'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kontrol',         'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ancaman',         'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intimidasi',      'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Paksaan',         'category' => 'Verbal',     'weight' => 5, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sinis',           'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mengatur',        'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Eksploitasi',     'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sebar',           'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Isolasi',         'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fitnah',          'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Eksposur',        'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pengabaian',      'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dorong',          'category' => 'Non-Verbal', 'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jambak',          'category' => 'Non-Verbal', 'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pukul',           'category' => 'Non-Verbal', 'weight' => 5, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tendang',         'category' => 'Non-Verbal', 'weight' => 5, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tonjok',          'category' => 'Non-Verbal', 'weight' => 5, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Peras',           'category' => 'Non-Verbal', 'weight' => 5, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rampas',          'category' => 'Non-Verbal', 'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rusak',           'category' => 'Non-Verbal', 'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sekap',           'category' => 'Non-Verbal', 'weight' => 5, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hadang',          'category' => 'Non-Verbal', 'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pengucilan',      'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Teror',           'category' => 'Verbal',     'weight' => 5, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cemooh',          'category' => 'Verbal',     'weight' => 3, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Isolasi',         'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tekanan',         'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pengasingan',     'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manipulasi',      'category' => 'Verbal',     'weight' => 4, 'description' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->command->info('✓ Violation Types: ' . DB::table('violation_types')->count() . ' data');
    }
}