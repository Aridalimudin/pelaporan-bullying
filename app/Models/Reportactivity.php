<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportActivity extends Model
{
    // ← Ubah ke true agar timestamps otomatis
    public $timestamps = true;

    protected $fillable = [
        'report_id',
        'actor_id',
        'actor_type', // ← TAMBAH INI
        'from_status',
        'to_status',
        'description',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}