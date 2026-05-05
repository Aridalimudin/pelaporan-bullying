<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('reporter_type', ['siswa', 'ortu'])->default('siswa')->after('email');
            $table->string('reporter_name',  150)->nullable()->after('reporter_type');
            $table->string('reporter_phone', 20)->nullable()->after('reporter_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['reporter_type', 'reporter_name', 'reporter_phone']);
        });
    }
};
