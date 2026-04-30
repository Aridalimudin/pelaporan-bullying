<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grade_majors', function (Blueprint $table) {
            // Hapus unique lama pada kolom grade saja
            $table->dropUnique(['grade']);

            // Ganti dengan composite unique: grade + major
            // Artinya "XI-TKJ" boleh ada, "XI-TIF" juga boleh,
            // tapi "XI-TKJ" tidak boleh duplikat
            $table->unique(['grade', 'major']);
        });
    }

    public function down(): void
    {
        Schema::table('grade_majors', function (Blueprint $table) {
            $table->dropUnique(['grade', 'major']);
            $table->unique(['grade']);
        });
    }
};