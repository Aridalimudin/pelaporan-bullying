<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'type', 'title', 'body',
        'icon', 'color', 'related_id', 'related_type',
        'url', 'read_at',
    ];

    protected $casts = ['read_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }
}