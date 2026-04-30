<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportPerson extends Model
{
    // Eksplisit karena Laravel auto-pluralize 'person' → 'people'
    protected $table = 'report_persons';

    protected $fillable = [
        'report_id',
        'role',
        'student_id',
        'name_manual',
        'grade_manual', // ← tambah
        'major_manual',
        'notes',
    ];

    /* ── Relasi ─────────────────────────────────────── */

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /* ── Helper ─────────────────────────────────────── */

    /**
     * Nama yang ditampilkan: prioritaskan data siswa, fallback ke manual.
     */
    public function displayName(): string
    {
        return $this->student?->fullname ?? $this->name_manual ?? '(tidak diketahui)';
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'pelaku' => 'Pelaku',
            'korban' => 'Korban',
            'saksi'  => 'Saksi',
            default  => ucfirst($this->role),
        };
    }
}