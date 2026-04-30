<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUpFile extends Model
{
    protected $fillable = [
        'follow_up_id',
        'original_name',
        'stored_name',
        'mime_type',    
        'size',
    ];
}