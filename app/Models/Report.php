<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ReportFeedback;

class Report extends Model
{
    protected $fillable = [
        'ticket_code',
        'nisn',
        'email',
        'student_id',
        'deskripsi',
        'status',
        'catatan_admin',
        'rejection_reason',
        'urgency',
        'incident_date',
        'incident_time',
        'incident_location',
        'handled_by',
        'handled_at',
        'last_reminder_at',
        'reminder_count',
    ];

    protected $casts = [
        'incident_date'    => 'date',
        'handled_at'       => 'datetime',
        'last_reminder_at' => 'datetime',
    ];

    // ══════════════════════════════════════════════
    // RELASI
    // ══════════════════════════════════════════════

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ReportFile::class);
    }

    public function persons(): HasMany
    {
        return $this->hasMany(ReportPerson::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ReportActivity::class)->orderByDesc('created_at');
    }

    // ── Scoped relations per role ────────────────

    public function pelaku(): HasMany
    {
        return $this->hasMany(ReportPerson::class)->where('role', 'pelaku');
    }

    public function korban(): HasMany
    {
        return $this->hasMany(ReportPerson::class)->where('role', 'korban');
    }

    public function saksi(): HasMany
    {
        return $this->hasMany(ReportPerson::class)->where('role', 'saksi');
    }

    // ══════════════════════════════════════════════
    // HELPERS
    // ══════════════════════════════════════════════

    /**
     * Generate kode tiket unik.
     * Format: KRF-DDMMYY-XXXX (contoh: KRF-140326-AB12)
     */
    public static function generateTicketCode(): string
    {
        $date = now()->format('dmy');

        do {
            $unique = strtoupper(substr(uniqid(), -4));
            $code   = "KRF-{$date}-{$unique}";
        } while (self::where('ticket_code', $code)->exists());

        return $code;
    }

    /**
     * Label status untuk tampilan.
     */
    public function statusLabel(): string
    {
        return match ($this->status) {
            'masuk'    => 'Laporan Masuk',
            'menunggu' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
            default    => ucfirst($this->status),
        };
    }

    /**
     * Warna badge status.
     */
    public function statusColor(): string
    {
        return match ($this->status) {
            'masuk'    => 'blue',
            'menunggu' => 'yellow',
            'diproses' => 'orange',
            'selesai'  => 'green',
            'ditolak'  => 'red',
            default    => 'gray',
        };
    }

    /**
     * Label urgensi untuk tampilan.
     */
    public function urgencyLabel(): string
    {
        return match ($this->urgency) {
            'tinggi' => 'Tinggi',
            'sedang' => 'Sedang',
            'rendah' => 'Rendah',
            default  => '-',
        };
    }

    /**
     * Cek apakah pelaku & korban sudah diisi.
     * Digunakan untuk auto-trigger status 'diproses'.
     */
    public function hasRequiredPersons(): bool
    {
        $hasPelaku = $this->persons()->where('role', 'pelaku')->exists();
        $hasKorban = $this->persons()->where('role', 'korban')->exists();

        return $hasPelaku && $hasKorban;
    }

    /**
     * Catat log aktivitas laporan.
     *
     * @param  string       $description  Teks singkat aktivitas
     * @param  string|null  $fromStatus   Status sebelumnya
     * @param  string|null  $toStatus     Status sesudahnya
     * @param  string|null  $notes        Catatan tambahan
     * @param  int|null     $actorId      ID user pelaku aksi (null = sistem/publik)
     */
    public function logActivity(
        string  $description,
        ?string $fromStatus = null,
        ?string $toStatus   = null,
        ?string $notes      = null,
        ?int    $actorId    = null,
        string  $actorType  = 'sistem'   // 'sistem' | 'pelapor' | 'admin'
    ): void {
        $this->activities()->create([
            'description' => $description,
            'from_status' => $fromStatus,
            'to_status'   => $toStatus,
            'notes'       => $notes,
            'actor_id'    => $actorId,
            'actor_type'  => $actorType,  // ← simpan ke DB
        ]);
    }

    /**
     * Cek apakah reminder bisa dikirim (cooldown 24 jam).
     */
    public function canSendReminder(): bool
    {
        // Maksimal 2x per hari, reset tiap tengah malam
        $todayCount = $this->activities()
            ->where('description', 'like', '%reminder%')
            ->whereDate('created_at', today())
            ->count();

        return $todayCount < 2;
    }
    public function followUp()
    {
        return $this->hasOne(ReportFollowUp::class);
    }
    public function feedback()
    {
        return $this->hasOne(ReportFeedback::class);
    }
    public function getRejectedFromStage(): string
    {
        $map = [
            'masuk'    => 'laporan-masuk',
            'menunggu' => 'menunggu-verifikasi',
            'diproses' => 'proses-laporan',
        ];

        // rejected_from_stage adalah kolom yang menyimpan status sebelum ditolak
        // Jika kolom belum ada, fallback ke catatan_admin atau default
        $raw = $this->rejected_from_stage ?? 'masuk';

        return $map[$raw] ?? 'laporan-masuk';
    }
}