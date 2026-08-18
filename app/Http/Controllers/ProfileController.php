<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna.
     */
    public function edit(): View
    {
        abort_unless(
            auth()->user()->can('profile.view'),
            403
        );

        $user = auth()->user()->load('profile');

        /*
        |--------------------------------------------------------------------------
        | Buat Profile Otomatis Jika Belum Ada
        |--------------------------------------------------------------------------
        */

        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create([
                'nama_lengkap' => $user->name,
            ]);
        }

        return view(
            'profile.edit',
            compact('user', 'profile')
        );
    }


    /**
     * Memperbarui profil pengguna.
     */
    public function update(
        ProfileUpdateRequest $request
    ): RedirectResponse {

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Data yang Sudah Lolos Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validated();


        /*
        |--------------------------------------------------------------------------
        | Ambil / Buat Profile
        |--------------------------------------------------------------------------
        */

        $profile = $user->profile;

        if (!$profile) {
            $profile = new Profile();

            $profile->user_id = $user->id;
        }


        /*
        |--------------------------------------------------------------------------
        | Update User & Profile
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $user,
            $profile,
            $validated,
            $request
        ) {

            /*
            |--------------------------------------------------------------------------
            | Update Data User
            |--------------------------------------------------------------------------
            */

            $emailChanged = $user->email !== $validated['email'];

            $user->name = $validated['name'];
            $user->email = $validated['email'];

            /*
            |--------------------------------------------------------------------------
            | Jika Email Berubah
            |--------------------------------------------------------------------------
            |
            | Email baru harus diverifikasi kembali.
            |
            */

            if ($emailChanged) {
                $user->email_verified_at = null;
            }

            $user->save();


            /*
            |--------------------------------------------------------------------------
            | Update Data Profile
            |--------------------------------------------------------------------------
            */

            $profile->nama_lengkap =
                $validated['nama_lengkap'];

            $profile->nip =
                $validated['nip'] ?? null;

            $profile->no_hp =
                $validated['no_hp'] ?? null;

            $profile->jabatan =
                $validated['jabatan'] ?? null;

            $profile->instansi =
                $validated['instansi'] ?? null;

            $profile->alamat =
                $validated['alamat'] ?? null;


            /*
            |--------------------------------------------------------------------------
            | Upload Foto Profil
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('foto')) {

                /*
                |--------------------------------------------------------------------------
                | Hapus Foto Lama
                |--------------------------------------------------------------------------
                */

                if (
                    $profile->foto &&
                    Storage::disk('public')
                        ->exists($profile->foto)
                ) {
                    Storage::disk('public')
                        ->delete($profile->foto);
                }


                /*
                |--------------------------------------------------------------------------
                | Simpan Foto Baru
                |--------------------------------------------------------------------------
                */

                $profile->foto = $request
                    ->file('foto')
                    ->store('profiles', 'public');
            }


            $profile->save();
        });


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('profile.edit')
            ->with(
                'status',
                'profile-updated'
            );
    }


    /**
     * Menghapus akun pengguna.
     *
     * Untuk sementara fitur hapus akun
     * tidak digunakan pada SIMTEPRA.
     */
    public function destroy(): never
    {
        abort(404);
    }
}