<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * GET /api/admin/permissions
     * Ambil semua permission beserta roles yang memilikinya.
     */
    public function index(): JsonResponse
    {
        $permissions = Permission::with('roles')
            ->orderBy('group')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($p) => $this->formatPermission($p));

        return response()->json([
            'success' => true,
            'data'    => $permissions->values(),
            'stats'   => [
                'total'     => Permission::count(),
                'protected' => Permission::where('is_protected', true)->count(),
                'groups'    => Permission::distinct('group')->count('group'),
            ],
        ]);
    }

    /**
     * POST /api/admin/permissions
     * Tambah permission baru.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'slug'      => 'required|string|unique:permissions,slug|regex:/^[a-z0-9\-]+$/',
            'group'     => 'required|in:Laporan,User,Analitik,Sistem',
            'aksi'      => 'required|in:read,write,delete,manage',
            'deskripsi' => 'nullable|string|max:500',
            'roles'     => 'nullable|array',
            'roles.*'   => 'exists:roles,id',
        ], [
            'nama.required'  => 'Nama permission wajib diisi.',
            'slug.required'  => 'Slug wajib diisi.',
            'slug.unique'    => 'Slug sudah digunakan.',
            'slug.regex'     => 'Slug hanya boleh huruf kecil, angka, dan tanda hubung.',
            'group.required' => 'Grup wajib dipilih.',
            'group.in'       => 'Grup tidak valid.',
            'aksi.required'  => 'Tipe aksi wajib dipilih.',
            'aksi.in'        => 'Tipe aksi tidak valid.',
        ]);

        $permission = Permission::create([
            'nama'         => $request->nama,
            'slug'         => $request->slug,
            'group'        => $request->group,
            'aksi'         => $request->aksi,
            'deskripsi'    => $request->deskripsi,
            'is_protected' => false, // Permission baru tidak pernah protected
        ]);

        // Tambahkan permission ini ke role-role yang dipilih
        if ($request->filled('roles')) {
            foreach ($request->roles as $roleId) {
                $role = Role::find($roleId);
                $role?->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }

        $permission->load('roles');

        return response()->json([
            'success' => true,
            'message' => 'Permission berhasil ditambahkan.',
            'data'    => $this->formatPermission($permission),
        ], 201);
    }

    /**
     * PUT /api/admin/permissions/{id}
     * Update permission.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'slug'      => ['required', 'regex:/^[a-z0-9\-]+$/', Rule::unique('permissions', 'slug')->ignore($id)],
            'group'     => 'required|in:Laporan,User,Analitik,Sistem',
            'aksi'      => 'required|in:read,write,delete,manage',
            'deskripsi' => 'nullable|string|max:500',
            'roles'     => 'nullable|array',
            'roles.*'   => 'exists:roles,id',
        ], [
            'nama.required'  => 'Nama permission wajib diisi.',
            'slug.required'  => 'Slug wajib diisi.',
            'slug.unique'    => 'Slug sudah digunakan.',
            'slug.regex'     => 'Slug hanya boleh huruf kecil, angka, dan tanda hubung.',
            'group.required' => 'Grup wajib dipilih.',
            'aksi.required'  => 'Tipe aksi wajib dipilih.',
        ]);

        $permission->update([
            'nama'      => $request->nama,
            'slug'      => $request->slug,
            'group'     => $request->group,
            'aksi'      => $request->aksi,
            'deskripsi' => $request->deskripsi,
        ]);

        // Sync permission ini ke/dari semua role:
        // Role yang ada di array $request->roles → syncWithoutDetaching
        // Role yang tidak ada → detach permission ini
        $selectedRoleIds = $request->roles ?? [];
        $allRoles = Role::all();

        foreach ($allRoles as $role) {
            if (in_array($role->id, $selectedRoleIds)) {
                $role->permissions()->syncWithoutDetaching([$permission->id]);
            } else {
                $role->permissions()->detach([$permission->id]);
            }
        }

        $permission->load('roles');

        return response()->json([
            'success' => true,
            'message' => 'Permission berhasil diperbarui.',
            'data'    => $this->formatPermission($permission),
        ]);
    }

    /**
     * DELETE /api/admin/permissions/{id}
     * Hapus permission.
     */
    public function destroy(int $id): JsonResponse
    {
        $permission = Permission::findOrFail($id);

        // Permission yang protected tidak boleh dihapus
        if ($permission->is_protected) {
            return response()->json([
                'success' => false,
                'message' => 'Permission ini dilindungi sistem dan tidak dapat dihapus.',
            ], 403);
        }

        $permission->roles()->detach();
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission berhasil dihapus.',
        ]);
    }

    /**
     * Format data permission untuk respons JSON ke frontend.
     */
    private function formatPermission(Permission $permission): array
    {
        return [
            'id'           => $permission->id,
            'nama'         => $permission->nama,
            'slug'         => $permission->slug,
            'group'        => $permission->group,
            'aksi'         => $permission->aksi,
            'deskripsi'    => $permission->deskripsi,
            'is_protected' => $permission->is_protected,
            'roles'        => $permission->roles->map(fn($r) => [
                'id'   => $r->id,
                'nama' => $r->nama,
                'slug' => $r->slug,
                'bg'   => $r->bg_color,
                'c'    => $r->text_color,
            ])->values(),
        ];
    }
}