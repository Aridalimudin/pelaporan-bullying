<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportFollowUp extends Model
{
    protected $fillable = [
        'report_id',
        'discipline_action_id',
        'korban_action_id',
        'catatan_korban',
        'jenis_tindakan',
        'tanggal_pelaksanaan',
        'deskripsi',
        'catatan_tambahan',
        'pelaksana',           // <--- PASTIKAN INI ADA
        'keterlibatan_ortu',
        'nomor_berita_acara',
        'tanggal_berita_acara',
        'isi_berita_acara',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
        'tanggal_berita_acara' => 'date',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function disciplineAction()
    {
        return $this->belongsTo(DisciplineAction::class);
    }

    public function korbanAction()
    {
        return $this->belongsTo(KorbanAction::class, 'korban_action_id');
    }

    public function files()
    {
        return $this->hasMany(FollowUpFile::class, 'follow_up_id');
    }
}