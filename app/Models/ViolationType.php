<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViolationType extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'weight',      // ← ini yang penting
        'keywords',
    ];

    public function getKeywordsArray(): array
    {
        $base = [strtolower($this->name)];

        // Pecah nama jadi kata per kata (min 4 huruf)
        foreach (explode(' ', strtolower($this->name)) as $w) {
            if (strlen($w) >= 4) $base[] = $w;
        }

        // Tambah keywords dari kolom DB (dipisah koma)
        if (!empty($this->keywords)) {
            foreach (explode(',', $this->keywords) as $kw) {
                $trimmed = strtolower(trim($kw));
                if ($trimmed) $base[] = $trimmed;
            }
        }

        return array_unique($base);
    }
}