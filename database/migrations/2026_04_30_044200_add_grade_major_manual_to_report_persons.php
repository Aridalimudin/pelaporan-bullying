<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('report_persons', function (Blueprint $table) {
            $table->string('grade_manual')->nullable()->after('name_manual');
            $table->string('major_manual')->nullable()->after('grade_manual');
        });
    }

    public function down(): void {
        Schema::table('report_persons', function (Blueprint $table) {
            $table->dropColumn(['grade_manual', 'major_manual']);
        });
    }
};
