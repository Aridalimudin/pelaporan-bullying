<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KorbanAction extends Model
{
    protected $table = 'korban_actions';

    protected $fillable = [
        'name',
        'description',
        'catatan',
    ];
}
