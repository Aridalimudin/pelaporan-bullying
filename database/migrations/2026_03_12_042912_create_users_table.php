<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi ini MENGGANTIKAN tabel users bawaan Laravel.
 * Jika kamu menjalankan migrate:fresh, tabel lama akan di-drop dulu.
 *
 * Kolom yang ditambah dari default Laravel:
 *   - nama          : nama lengkap
 *   - username      : untuk login (selain email)
 *   - status        : aktif | nonaktif
 *   - avatar_bg     : warna background avatar
 *   - avatar_color  : warna teks avatar
 *
 * Kolom yang DIHAPUS dari default Laravel:
 *   - name          : diganti 'nama'
 *   - email_verified_at : tidak dipakai
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('avatar_bg', 20)->default('#f0fdf4');
            $table->string('avatar_color', 20)->default('#16a34a');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};