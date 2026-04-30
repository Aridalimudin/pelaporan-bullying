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
        Schema::table('report_follow_ups', function (Blueprint $table) {
            $table->string('pelaksana')->nullable()->after('catatan_tambahan');
            $table->enum('keterlibatan_ortu', ['tidak', 'ya', 'opsional'])
                ->default('tidak')->after('pelaksana');
        });
    }

    public function down(): void
    {
        Schema::table('report_follow_ups', function (Blueprint $table) {
            $table->dropColumn(['pelaksana', 'keterlibatan_ortu']);
        });
    }
};
