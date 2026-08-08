<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'nis'      => 'required|string',
            'password' => 'required|string',
        ]);

        $student = Student::where('nis', $request->nis)->first();

        if (! $student || ! Hash::check($request->password, $student->password)) {
            return response()->json([
                'success' => false,
                'message' => 'NIS atau password salah.',
            ], 401);
        }

        if (! $student->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda telah dinonaktifkan. Hubungi guru atau admin.',
            ], 403);
        }

        Auth::guard('student')->login($student, $request->boolean('remember'));
        $request->session()->regenerate();

        return response()->json([
            'success'    => true,
            'message'    => 'Login berhasil.',
            'csrf_token' => csrf_token(),
            'redirect'   => route('siswa.dashboard'),
            'student'  => [
                'id'       => $student->id,
                'fullname' => $student->fullname,
                'nis'      => $student->nis,
                'grade'    => $student->grade,
                'major'    => $student->major,
                'email'    => $student->email,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success'  => true,
            'redirect' => route('lapor.index'),
        ]);
    }

    public function me(): JsonResponse
    {
        $student = Auth::guard('student')->user();

        if (! $student) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        return response()->json([
            'success' => true,
            'student' => [
                'id'       => $student->id,
                'fullname' => $student->fullname,
                'nis'      => $student->nis,
                'grade'    => $student->grade,
                'major'    => $student->major,
                'email'    => $student->email,
            ],
        ]);
    }
}
