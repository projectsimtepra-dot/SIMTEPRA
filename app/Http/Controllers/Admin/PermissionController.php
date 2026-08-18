<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Menampilkan daftar permission.
     */
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('permissions.view'), 403);

        $perPage = (int) $request->input('per_page', 10);

        // Hanya izinkan 10, 20, atau 30 data per halaman
        if (!in_array($perPage, [10, 20, 30], true)) {
            $perPage = 10;
        }

        $permissions = Permission::where('guard_name', 'web')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.permissions.index', compact('permissions'));
    }


    /**
     * Menampilkan form tambah permission.
     */
    public function create()
    {
        abort_unless(auth()->user()->can('permissions.create'), 403);

        return view('admin.permissions.create');
    }


    /**
     * Menyimpan permission baru.
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('permissions.create'), 403);

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('permissions', 'name')
                        ->where(fn ($query) => $query->where('guard_name', 'web')),
                ],
            ],
            [
                'name.required' => 'Nama permission wajib diisi.',
                'name.string'   => 'Nama permission harus berupa teks.',
                'name.max'      => 'Nama permission maksimal 255 karakter.',
                'name.unique'   => 'Nama permission tersebut sudah digunakan.',
            ]
        );

        Permission::create([
            'name'       => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission berhasil ditambahkan.');
    }


    /**
     * Menampilkan form edit permission.
     */
    public function edit(Permission $permission)
    {
        abort_unless(auth()->user()->can('permissions.edit'), 403);

        // Hanya permission dengan guard web yang boleh dikelola.
        if ($permission->guard_name !== 'web') {
            abort(404);
        }

        return view('admin.permissions.edit', compact('permission'));
    }


    /**
     * Memperbarui permission.
     */
    public function update(Request $request, Permission $permission)
    {
        abort_unless(auth()->user()->can('permissions.edit'), 403);

        // Pastikan permission menggunakan guard web.
        if ($permission->guard_name !== 'web') {
            abort(404);
        }

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('permissions', 'name')
                        ->where(fn ($query) => $query->where('guard_name', 'web'))
                        ->ignore($permission->id),
                ],
            ],
            [
                'name.required' => 'Nama permission wajib diisi.',
                'name.string'   => 'Nama permission harus berupa teks.',
                'name.max'      => 'Nama permission maksimal 255 karakter.',
                'name.unique'   => 'Nama permission tersebut sudah digunakan.',
            ]
        );

        $permission->update([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }


    /**
     * Menghapus permission.
     */
    public function destroy(Permission $permission)
    {
        abort_unless(auth()->user()->can('permissions.delete'), 403);

        // Pastikan permission menggunakan guard web.
        if ($permission->guard_name !== 'web') {
            abort(404);
        }

        // Jangan hapus permission jika masih digunakan oleh role.
        if ($permission->roles()->exists()) {
            return redirect()
                ->route('admin.permissions.index')
                ->with(
                    'error',
                    'Permission tidak dapat dihapus karena masih digunakan oleh role.'
                );
        }

        $permission->delete();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission berhasil dihapus.');
    }
}