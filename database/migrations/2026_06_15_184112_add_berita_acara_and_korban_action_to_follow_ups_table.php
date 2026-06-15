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
            $table->foreignId('discipline_action_id_korban')
                ->nullable()
                ->constrained('discipline_actions')
                ->nullOnDelete();
            $table->text('catatan_korban')->nullable();
            $table->string('nomor_berita_acara')->nullable();
            $table->date('tanggal_berita_acara')->nullable();
            $table->text('isi_berita_acara')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_follow_ups', function (Blueprint $table) {
            $table->dropForeign(['discipline_action_id_korban']);
            $table->dropColumn([
                'discipline_action_id_korban',
                'catatan_korban',
                'nomor_berita_acara',
                'tanggal_berita_acara',
                'isi_berita_acara'
            ]);
        });
    }
};
