<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
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

        $user = auth()->user();

        $activeTab = request()->query('tab', 'profil');

        return view(
            'profile.edit',
            compact('user', 'activeTab')
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


        /*
        |--------------------------------------------------------------------------
        | Upload Foto Profil
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_photo')) {

            /*
            |----------------------------------------------------------------------
            | Hapus Foto Lama
            |----------------------------------------------------------------------
            */

            if (
                $user->profile_photo &&
                Storage::disk('public')->exists($user->profile_photo)
            ) {
                Storage::disk('public')->delete(
                    $user->profile_photo
                );
            }


            /*
            |----------------------------------------------------------------------
            | Simpan Foto Baru
            |----------------------------------------------------------------------
            */

            $user->profile_photo = $request
                ->file('profile_photo')
                ->store('profiles', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Perubahan
        |--------------------------------------------------------------------------
        */

        $user->save();


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
}