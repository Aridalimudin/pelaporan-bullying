<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini MEMODIFIKASI tabel users yang sudah ada (bawaan Laravel).
 * Menambah kolom: nama, username, status, avatar_bg, avatar_color
 * Kolom 'name' bawaan Laravel diganti dengan 'nama'
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom bawaan Laravel yang tidak kita pakai
            // (hanya jika kolom itu ada)
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }

            // Tambah kolom baru (hanya jika belum ada)
            if (! Schema::hasColumn('users', 'nama')) {
                $table->string('nama')->after('id');
            }
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('nama');
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('password');
            }
            if (! Schema::hasColumn('users', 'avatar_bg')) {
                $table->string('avatar_bg', 20)->default('#f0fdf4')->after('status');
            }
            if (! Schema::hasColumn('users', 'avatar_color')) {
                $table->string('avatar_color', 20)->default('#16a34a')->after('avatar_bg');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan kolom bawaan Laravel
            if (! Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id');
            }
            if (! Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }

            // Hapus kolom yang kita tambahkan
            $dropCols = [];
            foreach (['nama', 'username', 'status', 'avatar_bg', 'avatar_color'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $dropCols[] = $col;
                }
            }
            if ($dropCols) {
                $table->dropColumn($dropCols);
            }
        });
    }
};