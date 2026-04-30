<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * GET /api/admin/users
     * Ambil semua user beserta role mereka.
     */
    public function index(): JsonResponse
    {
        $users = User::with('roles')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($u) => $this->formatUser($u));

        // Hitung statistik
        $total    = $users->count();
        $aktif    = $users->where('status', 'aktif')->count();
        $nonaktif = $users->where('status', 'nonaktif')->count();

        return response()->json([
            'success' => true,
            'data'    => $users->values(),
            'stats'   => [
                'total'    => $total,
                'aktif'    => $aktif,
                'nonaktif' => $nonaktif,
            ],
        ]);
    }

    /**
     * POST /api/admin/users
     * Tambah user baru.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id'  => 'required|exists:roles,id',
            'status'   => 'in:aktif,nonaktif',
        ], [
            'nama.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'role_id.required'  => 'Role wajib dipilih.',
            'role_id.exists'    => 'Role tidak ditemukan.',
        ]);

        $role = Role::findOrFail($request->role_id);

        $user = User::create([
            'nama'         => $request->nama,
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'status'       => $request->status ?? 'aktif',
            'avatar_bg'    => $role->bg_color,
            'avatar_color' => $role->text_color,
        ]);

        $user->roles()->sync([$role->id]);
        $user->load('roles');

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan.',
            'data'    => $this->formatUser($user),
        ], 201);
    }

    /**
     * PUT /api/admin/users/{id}
     * Update data user.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($id)],
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role_id'  => 'required|exists:roles,id',
            'status'   => 'in:aktif,nonaktif',
        ], [
            'nama.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'role_id.required'  => 'Role wajib dipilih.',
        ]);

        $role = Role::findOrFail($request->role_id);

        $updateData = [
            'nama'         => $request->nama,
            'username'     => $request->username,
            'email'        => $request->email,
            'status'       => $request->status ?? $user->status,
            'avatar_bg'    => $role->bg_color,
            'avatar_color' => $role->text_color,
        ];

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);
        $user->roles()->sync([$role->id]);
        $user->load('roles');

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui.',
            'data'    => $this->formatUser($user),
        ]);
    }

    /**
     * DELETE /api/admin/users/{id}
     * Hapus user.
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        // Tidak boleh hapus diri sendiri
        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus akun Anda sendiri.',
            ], 403);
        }

        $user->roles()->detach();
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus.',
        ]);
    }

    /**
     * Format data user untuk respons JSON ke frontend.
     */
    private function formatUser(User $user): array
    {
        $role = $user->getPrimaryRole();

        return [
            'id'           => $user->id,
            'nama'         => $user->nama,
            'username'     => $user->username,
            'email'        => $user->email,
            'status'       => $user->status,
            'tgl'          => $user->created_at->format('d M Y'),
            'role_id'      => $role?->id,
            'role'         => $role?->slug,
            'role_nama'    => $role?->nama,
            'av'           => [
                'bg' => $user->avatar_bg,
                'c'  => $user->avatar_color,
            ],
        ];
    }
}