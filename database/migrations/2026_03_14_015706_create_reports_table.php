<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // Kode tiket unik, contoh: KRF-140326-AB12
            $table->string('ticket_code')->unique();

            // Data pelapor (dari form)
            $table->string('nisn', 20);
            $table->string('email');

            // Relasi ke students (nullable karena siswa mungkin tidak ada di DB)
            $table->foreignId('student_id')->nullable()->constrained('students')->nullOnDelete();

            // Isi laporan
            $table->text('deskripsi');

            // Status laporan
            $table->enum('status', [
                'masuk',           // baru masuk
                'menunggu',        // menunggu verifikasi
                'diproses',        // sedang diproses
                'selesai',         // selesai ditangani
                'ditolak',         // ditolak
            ])->default('masuk');

            // Catatan dari admin (alasan ditolak, progress, dll)
            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });

        // Tabel untuk file bukti laporan
        Schema::create('report_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->string('original_name');
            $table->string('stored_name');
            $table->string('mime_type');
            $table->unsignedBigInteger('size'); // bytes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_files');
        Schema::dropIfExists('reports');
    }
};