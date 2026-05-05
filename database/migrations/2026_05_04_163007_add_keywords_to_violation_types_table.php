<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('violation_types', function (Blueprint $table) {
            $table->text('keywords')->nullable()->after('description');
            // Isi dengan kata kunci dipisah koma, misal: "memukul,pukul,tampar,hajar"
        });
    }

    public function down(): void
    {
        Schema::table('violation_types', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });
    }
};