<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    protected $fillable = [
        'fullname', 'nis', 'grade', 'major',
        'gender', 'phone', 'email', 'report_history'
    ];

    /* ── Relasi ke laporan ─────────────────────── */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /* ── Grades (via DB facade, tanpa model terpisah) ── */
    public static function allGrades(): array
    {
        return DB::table('grades')->orderBy('name')->pluck('name')->toArray();
    }

    public static function addGrade(string $name): void
    {
        DB::table('grades')->insertOrIgnore(['name' => strtoupper(trim($name)), 'created_at' => now(), 'updated_at' => now()]);
    }

    public static function removeGrade(string $name): void
    {
        DB::table('grades')->where('name', $name)->delete();
    }

    /* ── Majors (via DB facade, tanpa model terpisah) ── */
    public static function allMajors(): array
    {
        return DB::table('majors')->orderBy('name')->pluck('name')->toArray();
    }

    public static function addMajor(string $name): void
    {
        DB::table('majors')->insertOrIgnore(['name' => strtoupper(trim($name)), 'created_at' => now(), 'updated_at' => now()]);
    }

    public static function removeMajor(string $name): void
    {
        DB::table('majors')->where('name', $name)->delete();
    }
}