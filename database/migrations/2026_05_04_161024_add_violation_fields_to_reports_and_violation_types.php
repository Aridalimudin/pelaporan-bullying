<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tambah bobot ke violation_types
        Schema::table('violation_types', function (Blueprint $table) {
            $table->unsignedTinyInteger('weight')->default(1)->after('category');
            // weight: bobot dasar per jenis bullying
        });

        // Tambah kolom ke reports
        Schema::table('reports', function (Blueprint $table) {
            $table->json('detected_violations')->nullable()->after('urgency');
            // menyimpan array id violation_type yang terdeteksi
            $table->unsignedTinyInteger('urgency_score')->default(0)->after('detected_violations');
            // total bobot hasil kalkulasi
        });
    }

    public function down(): void
    {
        Schema::table('violation_types', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['detected_violations', 'urgency_score']);
        });
    }
};