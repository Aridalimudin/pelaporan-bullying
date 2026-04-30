<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * POST /api/admin/login
     *
     * Dipanggil oleh public/js/login-page.js via fetch.
     * Menggunakan session-based auth (guard 'web').
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user by username ATAU email
        $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username)
                    ->first();

        // Cek user ada & password cocok
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah.',
            ], 401);
        }

        // Cek status user
        if ($user->status === 'nonaktif') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.',
            ], 403);
        }

        // Load relasi roles dan permissions
        $user->load('roles.permissions');

        // Login via session (guard web)
        Auth::login($user, $request->boolean('remember'));

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        return response()->json([
            'success'  => true,
            'message'  => 'Login berhasil.',
            'redirect' => route('administrator.dashboard'),
            'user'     => [
                'id'          => $user->id,
                'nama'        => $user->nama,
                'username'    => $user->username,
                'email'       => $user->email,
                'status'      => $user->status,
                'role'        => $user->getPrimaryRole()?->nama,
                'role_slug'   => $user->getPrimaryRole()?->slug,
                'permissions' => $user->getAllPermissions()->pluck('slug')->values(),
                'avatar'      => [
                    'bg' => $user->avatar_bg,
                    'c'  => $user->avatar_color,
                ],
            ],
        ]);
    }

    /**
     * POST /api/admin/logout
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success'  => true,
            'redirect' => route('administrator.login'),
        ]);
    }

    /**
     * GET /api/admin/me
     * Ambil data user yang sedang login (untuk validasi session di JS).
     */
    public function me(): JsonResponse
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user instanceof User) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $user->load('roles.permissions');

        return response()->json([
            'success' => true,
            'user'    => [
                'id'          => $user->id,
                'nama'        => $user->nama,
                'username'    => $user->username,
                'email'       => $user->email,
                'status'      => $user->status,
                'role'        => $user->getPrimaryRole()?->nama,
                'role_slug'   => $user->getPrimaryRole()?->slug,
                'permissions' => $user->getAllPermissions()->pluck('slug')->values(),
                'avatar'      => [
                    'bg' => $user->avatar_bg,
                    'c'  => $user->avatar_color,
                ],
            ],
        ]);
    }
}