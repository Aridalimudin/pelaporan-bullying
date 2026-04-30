<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table    = 'majors';
    protected $fillable = ['name', 'code'];

    /**
     * Return array of code string — untuk filter/dropdown kelas & _allMajors di JS
     */
    public static function allCodes(): array
    {
        return static::query()
            ->whereNotNull('code')
            ->where('code', '!=', '')
            ->orderBy('code')
            ->pluck('code')
            ->toArray();
    }

    /**
     * Return array of {name, code} — untuk daftar jurusan di modal (tampil lengkap)
     */
    public static function allMajors(): array
    {
        return static::query()
            ->whereNotNull('code')
            ->where('code', '!=', '')
            ->orderBy('name')
            ->get(['name', 'code'])
            ->toArray();
    }
}