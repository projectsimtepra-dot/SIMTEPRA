<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update password pengguna.
     */
    public function update(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi Password
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => [
                    'required',
                    'current_password',
                ],

                'password' => [
                    'required',
                    Password::defaults(),
                    'confirmed',
                ],
            ],
            [
                /*
                |----------------------------------------------------------------------
                | Password Saat Ini
                |----------------------------------------------------------------------
                */

                'current_password.required' =>
                    'Password saat ini wajib diisi.',

                'current_password.current_password' =>
                    'Password saat ini yang Anda masukkan salah.',


                /*
                |----------------------------------------------------------------------
                | Password Baru
                |----------------------------------------------------------------------
                */

                'password.required' =>
                    'Password baru wajib diisi.',

                'password.confirmed' =>
                    'Konfirmasi password baru tidak cocok.',

                'password.min' =>
                    'Password baru minimal :min karakter.',

                'password.letters' =>
                    'Password baru harus mengandung huruf.',

                'password.mixed' =>
                    'Password baru harus mengandung huruf besar dan huruf kecil.',

                'password.numbers' =>
                    'Password baru harus mengandung angka.',

                'password.symbols' =>
                    'Password baru harus mengandung simbol.',

                'password.uncompromised' =>
                    'Password baru tidak aman karena pernah ditemukan dalam kebocoran data.',

            ],
            [
                'current_password' =>
                    'password saat ini',

                'password' =>
                    'password baru',

                'password_confirmation' =>
                    'konfirmasi password baru',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Jika Validasi Gagal
        |--------------------------------------------------------------------------
        */

        if ($validator->fails()) {

            return redirect()
                ->route('profile.edit', [
                    'tab' => 'keamanan',
                ])
                ->withErrors(
                    $validator,
                    'updatePassword'
                )
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        $request->user()->update([
            'password' => Hash::make(
                $validator->validated()['password']
            ),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('profile.edit', [
                'tab' => 'keamanan',
            ])
            ->with(
                'status',
                'password-updated'
            );
    }
}