<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * GET /api/admin/roles
     * Ambil semua role beserta permissions dan jumlah user.
     */
    public function index(): JsonResponse
    {
        $roles = Role::with(['permissions', 'users'])
            ->orderBy('is_system', 'desc')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($r) => $this->formatRole($r));

        return response()->json([
            'success' => true,
            'data'    => $roles->values(),
        ]);
    }

    /**
     * POST /api/admin/roles
     * Tambah role baru.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'slug'          => 'required|string|unique:roles,slug|regex:/^[a-z0-9\-]+$/',
            'deskripsi'     => 'nullable|string|max:500',
            'bg_color'      => 'nullable|string|max:20',
            'text_color'    => 'nullable|string|max:20',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'nama.required'  => 'Nama role wajib diisi.',
            'slug.required'  => 'Slug wajib diisi.',
            'slug.unique'    => 'Slug sudah digunakan.',
            'slug.regex'     => 'Slug hanya boleh huruf kecil, angka, dan tanda hubung.',
        ]);

        $role = Role::create([
            'nama'       => $request->nama,
            'slug'       => $request->slug,
            'deskripsi'  => $request->deskripsi,
            'bg_color'   => $request->bg_color   ?? '#f0fdf4',
            'text_color' => $request->text_color ?? '#16a34a',
            'is_system'  => false,
        ]);

        if ($request->filled('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        $role->load(['permissions', 'users']);

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil ditambahkan.',
            'data'    => $this->formatRole($role),
        ], 201);
    }

    /**
     * PUT /api/admin/roles/{id}
     * Update role.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'nama'          => 'required|string|max:255',
            'slug'          => ['required', 'regex:/^[a-z0-9\-]+$/', Rule::unique('roles', 'slug')->ignore($id)],
            'deskripsi'     => 'nullable|string|max:500',
            'bg_color'      => 'nullable|string|max:20',
            'text_color'    => 'nullable|string|max:20',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ], [
            'nama.required' => 'Nama role wajib diisi.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique'   => 'Slug sudah digunakan.',
            'slug.regex'    => 'Slug hanya boleh huruf kecil, angka, dan tanda hubung.',
        ]);

        $role->update([
            'nama'       => $request->nama,
            'slug'       => $request->slug,
            'deskripsi'  => $request->deskripsi,
            'bg_color'   => $request->bg_color   ?? $role->bg_color,
            'text_color' => $request->text_color ?? $role->text_color,
        ]);

        // Sync permissions (kosongkan dulu kalau array kosong dikirim)
        $role->permissions()->sync($request->permissions ?? []);

        $role->load(['permissions', 'users']);

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil diperbarui.',
            'data'    => $this->formatRole($role),
        ]);
    }

    /**
     * DELETE /api/admin/roles/{id}
     * Hapus role.
     */
    public function destroy(int $id): JsonResponse
    {
        $role = Role::withCount('users')->findOrFail($id);

        // Role sistem tidak boleh dihapus
        if ($role->is_system) {
            return response()->json([
                'success' => false,
                'message' => 'Role sistem tidak dapat dihapus.',
            ], 403);
        }

        // Role yang masih dipakai user tidak boleh dihapus
        if ($role->users_count > 0) {
            return response()->json([
                'success' => false,
                'message' => "Role ini masih digunakan oleh {$role->users_count} user. Pindahkan user terlebih dahulu.",
            ], 422);
        }

        $role->permissions()->detach();
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil dihapus.',
        ]);
    }

    /**
     * Format data role untuk respons JSON ke frontend.
     */
    private function formatRole(Role $role): array
    {
        return [
            'id'        => $role->id,
            'nama'      => $role->nama,
            'slug'      => $role->slug,
            'deskripsi' => $role->deskripsi,
            'bg'        => $role->bg_color,
            'c'         => $role->text_color,
            'is_system' => $role->is_system,
            'userCount' => $role->users->count(),
            'perms'     => $role->permissions->map(fn($p) => [
                'id'   => $p->id,
                'nama' => $p->nama,
                'slug' => $p->slug,
                'group'=> $p->group,
                'aksi' => $p->aksi,
            ])->values(),
        ];
    }
}