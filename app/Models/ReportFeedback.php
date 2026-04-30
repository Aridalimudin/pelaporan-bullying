<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportFeedback extends Model
{
    protected $table = 'report_feedbacks';
    protected $fillable = [
        'report_id',
        'rating',
        'pesan',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}