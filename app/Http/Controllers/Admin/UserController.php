<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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
     * Menampilkan daftar pengguna.
     */
    public function index(Request $request)
    {
        abort_unless(
            auth()->user()->can('users.view'),
            403
        );

        $perPage = (int) $request->input('per_page', 10);

        // Hanya izinkan 10, 20, atau 30 data per halaman.
        if (!in_array($perPage, [10, 20, 30], true)) {
            $perPage = 10;
        }

        $users = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah pengguna.
     */
    public function create()
    {
        abort_unless(
            auth()->user()->can('users.create'),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Role yang tersedia
        |--------------------------------------------------------------------------
        |
        | Hanya role SIMTEPRA yang boleh digunakan.
        |
        */

        $roles = Role::where('guard_name', 'web')
            ->whereIn('name', $this->systemRoles)
            ->orderByRaw("
                CASE
                    WHEN name = 'admin' THEN 1
                    WHEN name = 'viewer' THEN 2
                    WHEN name = 'super-admin' THEN 3
                    ELSE 4
                END
            ")
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Admin tidak boleh membuat Super Admin
        |--------------------------------------------------------------------------
        */

        if (!auth()->user()->hasRole('super-admin')) {
            $roles = $roles
                ->where('name', '!=', 'super-admin')
                ->values();
        }

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request)
    {
        abort_unless(
            auth()->user()->can('users.create'),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],

                'role' => [
                    'required',
                    Rule::in($this->systemRoles),
                ],
            ],
            [
                'name.required' => 'Nama pengguna wajib diisi.',
                'name.string'   => 'Nama pengguna harus berupa teks.',
                'name.max'      => 'Nama pengguna maksimal 255 karakter.',

                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
                'email.max'      => 'Email maksimal 255 karakter.',
                'email.unique'   => 'Email tersebut sudah digunakan oleh pengguna lain.',

                'password.required'  => 'Password wajib diisi.',
                'password.string'    => 'Password harus berupa teks.',
                'password.min'       => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak sama dengan password.',

                'role.required' => 'Silakan pilih role pengguna.',
                'role.in'       => 'Role yang dipilih tidak valid.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Admin tidak boleh membuat Super Admin
        |--------------------------------------------------------------------------
        */

        if (
            $validated['role'] === 'super-admin' &&
            !auth()->user()->hasRole('super-admin')
        ) {
            abort(403, 'Anda tidak memiliki izin untuk membuat pengguna Super Admin.');
        }

        /*
        |--------------------------------------------------------------------------
        | Buat User
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign Role
        |--------------------------------------------------------------------------
        */

        $user->syncRoles([
            $validated['role'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Pengguna berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail pengguna.
     */
    public function show(string $id)
    {
        abort_unless(
            auth()->user()->can('users.view'),
            403
        );

        $user = User::with('roles')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Menampilkan form edit pengguna.
     */
    public function edit(string $id)
    {
        abort_unless(
            auth()->user()->can('users.edit'),
            403
        );

        $user = User::with('roles')->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Admin tidak boleh mengedit Super Admin
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('super-admin') &&
            !auth()->user()->hasRole('super-admin')
        ) {
            abort(
                403,
                'Anda tidak memiliki izin untuk mengedit akun Super Admin.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Role Sistem
        |--------------------------------------------------------------------------
        */

        $roles = Role::where('guard_name', 'web')
            ->whereIn('name', $this->systemRoles)
            ->orderByRaw("
                CASE
                    WHEN name = 'admin' THEN 1
                    WHEN name = 'viewer' THEN 2
                    WHEN name = 'super-admin' THEN 3
                    ELSE 4
                END
            ")
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Admin tidak boleh memberikan Super Admin
        |--------------------------------------------------------------------------
        */

        if (!auth()->user()->hasRole('super-admin')) {
            $roles = $roles
                ->where('name', '!=', 'super-admin')
                ->values();
        }

        return view(
            'admin.users.edit',
            compact('user', 'roles')
        );
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, string $id)
    {
        abort_unless(
            auth()->user()->can('users.edit'),
            403
        );

        $user = User::with('roles')->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Admin tidak boleh mengedit Super Admin
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('super-admin') &&
            !auth()->user()->hasRole('super-admin')
        ) {
            abort(
                403,
                'Anda tidak memiliki izin untuk mengubah akun Super Admin.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email,' . $user->id,
                ],

                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'confirmed',
                ],

                'role' => [
                    'required',
                    Rule::in($this->systemRoles),
                ],
            ],
            [
                'name.required' => 'Nama pengguna wajib diisi.',
                'name.string'   => 'Nama pengguna harus berupa teks.',
                'name.max'      => 'Nama pengguna maksimal 255 karakter.',

                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
                'email.max'      => 'Email maksimal 255 karakter.',
                'email.unique'   => 'Email tersebut sudah digunakan oleh pengguna lain.',

                'password.string'    => 'Password harus berupa teks.',
                'password.min'       => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak sama dengan password.',

                'role.required' => 'Silakan pilih role pengguna.',
                'role.in'       => 'Role yang dipilih tidak valid.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Admin tidak boleh mengubah user menjadi Super Admin
        |--------------------------------------------------------------------------
        */

        if (
            $validated['role'] === 'super-admin' &&
            !auth()->user()->hasRole('super-admin')
        ) {
            abort(
                403,
                'Anda tidak memiliki izin untuk memberikan role Super Admin.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Data Dasar
        |--------------------------------------------------------------------------
        */

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        |
        | Password hanya diubah jika field diisi.
        |
        */

        if (!empty($validated['password'])) {
            $user->password = Hash::make(
                $validated['password']
            );
        }

        $user->save();

        /*
        |--------------------------------------------------------------------------
        | Update Role
        |--------------------------------------------------------------------------
        */

        $user->syncRoles([
            $validated['role'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Data pengguna berhasil diperbarui.'
            );
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy(string $id)
    {
        abort_unless(
            auth()->user()->can('users.delete'),
            403
        );

        $user = User::with('roles')->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Tidak boleh menghapus akun sendiri
        |--------------------------------------------------------------------------
        */

        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'Anda tidak dapat menghapus akun sendiri.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Super Admin hanya dapat dihapus oleh Super Admin
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('super-admin') &&
            !auth()->user()->hasRole('super-admin')
        ) {
            abort(
                403,
                'Anda tidak memiliki izin untuk menghapus akun Super Admin.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus User
        |--------------------------------------------------------------------------
        */

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Pengguna berhasil dihapus.'
            );
    }
}