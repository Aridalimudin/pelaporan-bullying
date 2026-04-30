<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeMajor extends Model
{
    protected $table    = 'grade_majors';
    protected $fillable = ['grade', 'major'];

    /**
     * Ambil semua jurusan unik yang ada (untuk dropdown filter jurusan)
     */
    public static function allMajors(): array
    {
        return static::select('major')
            ->distinct()
            ->orderBy('major')
            ->pluck('major')
            ->toArray();
    }

    /**
     * Ambil semua kelas yang terdaftar (untuk dropdown filter kelas)
     */
    public static function allGrades(): array
    {
        return static::orderBy('grade')
            ->pluck('grade')
            ->toArray();
    }

    /**
     * Ambil daftar kelas berdasarkan jurusan tertentu
     * Dipakai saat user memilih jurusan di form laporan → filter kelas yang sesuai
     */
    public static function gradesByMajor(string $major): array
    {
        return static::where('major', $major)
            ->orderBy('grade')
            ->pluck('grade')
            ->toArray();
    }

    /**
     * Ambil jurusan dari kelas tertentu
     * Dipakai untuk validasi saat simpan laporan
     */
    public static function majorByGrade(string $grade): ?string
    {
        return static::where('grade', $grade)->value('major');
    }

    /**
     * Ambil semua pasangan sebagai array [{grade, major}]
     * Dipakai untuk render daftar di modal Kelola Kelas
     */
    public static function allPairs(): array
    {
        return static::orderBy('major')->orderBy('grade')
            ->get(['grade', 'major'])
            ->toArray();
    }
}