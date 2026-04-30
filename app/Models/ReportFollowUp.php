<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportFollowUp extends Model
{
    protected $fillable = [
        'report_id',
        'discipline_action_id',
        'jenis_tindakan',
        'tanggal_pelaksanaan',
        'deskripsi',
        'catatan_tambahan',
        'pelaksana',           // <--- PASTIKAN INI ADA
        'keterlibatan_ortu',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function disciplineAction()
    {
        return $this->belongsTo(DisciplineAction::class);
    }

    public function files()
    {
        return $this->hasMany(FollowUpFile::class, 'follow_up_id');
    }
}