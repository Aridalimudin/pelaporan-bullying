<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GradeMajor;
use App\Models\Major;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GradeMajorController extends Controller
{
    /* ═══════════════════════════════════════════
       JURUSAN (MAJORS)
    ═══════════════════════════════════════════ */

    /**
     * GET /api/data-siswa/majors
     * Return array of CODE string — dipakai _allMajors di JS
     * (untuk filter, dropdown kelas, tag)
     */
    public function majorsList(): JsonResponse
    {
        return response()->json(Major::allCodes());
    }

    /**
     * GET /api/data-siswa/majors/full
     * Return array of {name, code} — dipakai daftar jurusan di modal
     */
    public function majorsFullList(): JsonResponse
    {
        return response()->json(Major::allMajors());
    }

    /**
     * POST /api/data-siswa/majors/save
     * Body: { name: "Rekayasa Perangkat Lunak", code: "RPL" }
     */
    public function majorSave(Request $request): JsonResponse
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:majors,name',
            'code' => 'required|string|max:20|unique:majors,code',
        ], [
            'name.required' => 'Nama jurusan wajib diisi.',
            'name.unique'   => 'Nama jurusan sudah ada.',
            'code.required' => 'Kode/inisial jurusan wajib diisi.',
            'code.unique'   => 'Kode ":input" sudah digunakan.',
            'code.max'      => 'Kode maksimal 20 karakter.',
        ]);

        if ($v->fails()) {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }

        $name = trim($request->name);
        $code = strtoupper(trim($request->code));

        Major::create(['name' => $name, 'code' => $code]);

        return response()->json(['status' => 'success', 'name' => $name, 'code' => $code]);
    }

    /**
     * DELETE /api/data-siswa/majors/delete/{code}
     * Hapus berdasarkan code
     */
    public function majorDelete(string $name): JsonResponse
    {
        // $name parameter bisa berupa code atau name — coba keduanya
        Major::where('code', strtoupper($name))
              ->orWhere('name', $name)
              ->delete();

        return response()->json(['status' => 'success']);
    }

    /* ═══════════════════════════════════════════
       KELAS (GRADES) — via grade_majors
    ═══════════════════════════════════════════ */

    /**
     * GET /api/data-siswa/grades
     * Return array of kelas string
     */
    public function gradesList(): JsonResponse
    {
        return response()->json(GradeMajor::allGrades());
    }

    /**
     * GET /api/data-siswa/grade-majors
     * Return semua pasangan [{grade, major}]
     */
    public function pairsList(): JsonResponse
    {
        return response()->json(GradeMajor::allPairs());
    }

    /**
     * GET /api/data-siswa/grades-by-major/{major}
     */
    public function gradesByMajor(string $major): JsonResponse
    {
        return response()->json(GradeMajor::gradesByMajor($major));
    }

    /**
     * POST /api/data-siswa/grades/save
     * Body: { grade: "XA", major: "RPL" }
     * major = CODE jurusan
     */
    public function gradeSave(Request $request): JsonResponse
    {
        $v = Validator::make($request->all(), [
            'grade' => [
                'required', 'string', 'max:20',
                Rule::unique('grade_majors')->where(function ($query) use ($request) {
                    return $query->where('major', strtoupper(trim($request->major)));
                }),
            ],
            'major' => 'required|string|max:20|exists:majors,code',
        ], [
            'grade.required' => 'Nama kelas wajib diisi.',
            'grade.max'      => 'Nama kelas maksimal 20 karakter.',
            'grade.unique'   => 'Kelas ":input" sudah terdaftar.',
            'major.required' => 'Jurusan wajib dipilih.',
            'major.exists'   => 'Jurusan tidak ditemukan. Tambahkan jurusan terlebih dahulu.',
        ]);

        if ($v->fails()) {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }

        $grade = strtoupper(trim($request->grade));
        $major = strtoupper(trim($request->major));

        GradeMajor::create(['grade' => $grade, 'major' => $major]);

        return response()->json([
            'status' => 'success',
            'data'   => ['grade' => $grade, 'major' => $major],
        ]);
    }

    /**
     * DELETE /api/data-siswa/grades/delete/{grade}
     */
    public function gradeDelete(string $grade): JsonResponse
    {
        GradeMajor::where('grade', $grade)->delete();

        return response()->json(['status' => 'success']);
    }

    /**
     * GET /api/data-siswa/major-by-grade/{grade}
     */
    public function majorByGrade(string $grade): JsonResponse
    {
        $major = GradeMajor::majorByGrade($grade);

        if (!$major) {
            return response()->json(['status' => 'error', 'message' => 'Kelas tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 'success', 'major' => $major]);
    }
}