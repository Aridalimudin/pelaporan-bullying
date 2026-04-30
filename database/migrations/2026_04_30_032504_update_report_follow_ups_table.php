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
            $table->foreignId('discipline_action_id')
                ->nullable()
                ->after('report_id')
                ->constrained('discipline_actions')
                ->nullOnDelete();

            $table->text('catatan_tambahan')->nullable()->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('report_follow_ups', function (Blueprint $table) {
            $table->dropForeign(['discipline_action_id']);
            $table->dropColumn(['discipline_action_id', 'catatan_tambahan']);
        });
    }
};
