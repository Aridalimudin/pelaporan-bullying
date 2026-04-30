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
        Schema::table('report_persons', function (Blueprint $table) {
            if (!Schema::hasColumn('report_persons', 'notes')) {
                $table->text('notes')->nullable()->after('name_manual');
            }
        });
    }

    public function down(): void
    {
        Schema::table('report_persons', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
};
