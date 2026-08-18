<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Role yang digunakan oleh sistem SIMTEPRA.
     */
    private array $systemRoles = [
        'super-admin',
        'admin',
        'viewer',
    ];


    /**
     * Menampilkan daftar role.
     */
    public function index()
    {
        abort_unless(
            auth()->user()->can('roles.view'),
            403
        );

        $roles = Role::withCount('users')
            ->where('guard_name', 'web')
            ->whereIn('name', $this->systemRoles)
            ->orderByRaw("
                CASE
                    WHEN name = 'super-admin' THEN 1
                    WHEN name = 'admin' THEN 2
                    WHEN name = 'viewer' THEN 3
                    ELSE 4
                END
            ")
            ->get();

        return view('admin.roles.index', compact('roles'));
    }


    /**
     * Form tambah role.
     *
     * SIMTEPRA hanya menggunakan role sistem
     * yang sudah ditentukan.
     */
    public function create()
    {
        abort_unless(
            auth()->user()->can('roles.create'),
            403
        );

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'error',
                'Role SIMTEPRA sudah ditetapkan: Super Admin, Admin, dan Viewer.'
            );
    }


    /**
     * Simpan role baru.
     *
     * Role sistem tidak dapat dibuat melalui halaman ini.
     */
    public function store(Request $request)
    {
        abort_unless(
            auth()->user()->can('roles.create'),
            403
        );

        return redirect()
            ->route('admin.roles.index')
            ->with(
                'error',
                'Tidak dapat membuat role baru. SIMTEPRA hanya menggunakan Super Admin, Admin, dan Viewer.'
            );
    }


    /**
     * Form edit role.
     */
    public function edit(Role $role)
    {
        abort_unless(
            auth()->user()->can('roles.edit'),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Validasi Role
        |--------------------------------------------------------------------------
        */

        if ($role->guard_name !== 'web') {
            abort(404);
        }

        if (!in_array($role->name, $this->systemRoles, true)) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Permission
        |--------------------------------------------------------------------------
        */

        $permissions = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Permission yang dimiliki Role
        |--------------------------------------------------------------------------
        */

        $rolePermissions = $role->permissions
            ->pluck('id')
            ->toArray();


        return view('admin.roles.edit', compact(
            'role',
            'permissions',
            'rolePermissions'
        ));
    }


    /**
     * Update permission role.
     */
    public function update(Request $request, Role $role)
    {
        abort_unless(
            auth()->user()->can('roles.edit'),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Validasi Role
        |--------------------------------------------------------------------------
        */

        if ($role->guard_name !== 'web') {
            abort(404);
        }

        if (!in_array($role->name, $this->systemRoles, true)) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi Permission
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'permissions' => [
                    'nullable',
                    'array',
                ],

                'permissions.*' => [
                    'integer',
                    Rule::exists('permissions', 'id')
                        ->where(
                            fn ($query) =>
                                $query->where('guard_name', 'web')
                        ),
                ],
            ],
            [
                'permissions.array' =>
                    'Format permission tidak valid.',

                'permissions.*.integer' =>
                    'Permission yang dipilih tidak valid.',

                'permissions.*.exists' =>
                    'Permission yang dipilih tidak tersedia.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        |
        | Super Admin selalu memiliki seluruh permission.
        | Permission tidak boleh dikurangi.
        |
        */

        if ($role->name === 'super-admin') {

            $role->syncPermissions(
                Permission::where('guard_name', 'web')->get()
            );

            return redirect()
                ->route('admin.roles.index')
                ->with(
                    'success',
                    'Super Admin selalu memiliki seluruh permission sistem.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN & VIEWER
        |--------------------------------------------------------------------------
        */

        $permissionIds = $validated['permissions'] ?? [];


        $permissions = Permission::whereIn(
                'id',
                $permissionIds
            )
            ->where('guard_name', 'web')
            ->get();


        $role->syncPermissions($permissions);


        $roleName = match ($role->name) {
            'admin' => 'Admin',
            'viewer' => 'Viewer',
            default => ucfirst($role->name),
        };


        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                "Permission role {$roleName} berhasil diperbarui."
            );
    }


    /**
     * Menghapus role.
     *
     * Role sistem SIMTEPRA tidak boleh dihapus.
     */
    public function destroy(Role $role)
    {
        abort_unless(
            auth()->user()->can('roles.delete'),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Validasi Guard
        |--------------------------------------------------------------------------
        */

        if ($role->guard_name !== 'web') {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | Lindungi Role Sistem
        |--------------------------------------------------------------------------
        */

        if (in_array($role->name, $this->systemRoles, true)) {

            return redirect()
                ->route('admin.roles.index')
                ->with(
                    'error',
                    'Role Super Admin, Admin, dan Viewer merupakan role sistem dan tidak dapat dihapus.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Role yang masih digunakan
        |--------------------------------------------------------------------------
        */

        if ($role->users()->exists()) {

            return redirect()
                ->route('admin.roles.index')
                ->with(
                    'error',
                    'Role tidak dapat dihapus karena masih digunakan oleh pengguna.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Hapus Role
        |--------------------------------------------------------------------------
        */

        $role->delete();


        return redirect()
            ->route('admin.roles.index')
            ->with(
                'success',
                'Role berhasil dihapus.'
            );
    }
}