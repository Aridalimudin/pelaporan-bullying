<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── Tambah kolom ke tabel reports ──────────────────────────────────
        Schema::table('reports', function (Blueprint $table) {
            // Tingkat urgensi (diisi admin saat verifikasi)
            $table->enum('urgency', ['rendah', 'sedang', 'tinggi'])
                  ->nullable()
                  ->after('catatan_admin');

            // Tanggal & lokasi kejadian (diisi oleh pelapor atau admin)
            $table->date('incident_date')->nullable()->after('urgency');
            $table->string('incident_location')->nullable()->after('incident_date');

            // Admin yang menangani
            $table->foreignId('handled_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->after('incident_location');

            $table->timestamp('handled_at')->nullable()->after('handled_by');

            // Reminder: kapan terakhir user kirim reminder & berapa kali
            $table->timestamp('last_reminder_at')->nullable()->after('handled_at');
            $table->unsignedTinyInteger('reminder_count')->default(0)->after('last_reminder_at');
        });

        // ── Tabel pihak-pihak yang terlibat (pelaku/korban/saksi) ──────────
        Schema::create('report_persons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('report_id')
                  ->constrained('reports')
                  ->cascadeOnDelete();

            // Role: pelaku | korban | saksi
            $table->enum('role', ['pelaku', 'korban', 'saksi']);

            // Relasi ke students (nullable — bisa siswa tidak dikenal)
            $table->foreignId('student_id')
                  ->nullable()
                  ->constrained('students')
                  ->nullOnDelete();

            // Nama manual jika tidak ditemukan di DB atau bukan siswa
            $table->string('name_manual')->nullable();

            // Keterangan tambahan per orang (mis. kronologi dari korban)
            $table->text('notes')->nullable();

            $table->timestamps();
        });

        // ── Log aktivitas laporan (timeline history) ───────────────────────
        Schema::create('report_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('report_id')
                  ->constrained('reports')
                  ->cascadeOnDelete();

            // Siapa yang melakukan aksi (null = sistem / publik)
            $table->foreignId('actor_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Status sebelum & sesudah perubahan
            $table->string('from_status')->nullable();
            $table->string('to_status')->nullable();

            // Deskripsi singkat aksi, mis. "Status diubah ke Diproses"
            $table->string('description');

            // Catatan tambahan (alasan penolakan, dll)
            $table->text('notes')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_activities');
        Schema::dropIfExists('report_persons');

        Schema::table('reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('handled_by');
            $table->dropColumn([
                'urgency',
                'incident_date',
                'incident_location',
                'handled_at',
                'last_reminder_at',
                'reminder_count',
            ]);
        });
    }
};