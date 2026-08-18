<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna boleh melakukan request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('profile.edit') ?? false;
    }

    /**
     * Aturan validasi profile.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Data Akun
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)
                    ->ignore($this->user()->id),
            ],


            /*
            |--------------------------------------------------------------------------
            | Data Profile
            |--------------------------------------------------------------------------
            */

            'nama_lengkap' => [
                'required',
                'string',
                'max:255',
            ],

            'nip' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('profiles', 'nip')
                    ->ignore(
                        $this->user()?->profile?->id
                    ),
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:20',
            ],

            'jabatan' => [
                'nullable',
                'string',
                'max:150',
            ],

            'instansi' => [
                'nullable',
                'string',
                'max:150',
            ],

            'alamat' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }

    /**
     * Pesan validasi Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [

            'name.required' =>
                'Nama akun wajib diisi.',

            'name.string' =>
                'Nama akun harus berupa teks.',

            'name.max' =>
                'Nama akun maksimal 255 karakter.',


            'email.required' =>
                'Email wajib diisi.',

            'email.string' =>
                'Email harus berupa teks.',

            'email.email' =>
                'Format email tidak valid.',

            'email.lowercase' =>
                'Email harus menggunakan huruf kecil.',

            'email.max' =>
                'Email maksimal 255 karakter.',

            'email.unique' =>
                'Email tersebut sudah digunakan oleh pengguna lain.',


            'nama_lengkap.required' =>
                'Nama lengkap wajib diisi.',

            'nama_lengkap.string' =>
                'Nama lengkap harus berupa teks.',

            'nama_lengkap.max' =>
                'Nama lengkap maksimal 255 karakter.',


            'nip.string' =>
                'NIP harus berupa teks.',

            'nip.max' =>
                'NIP maksimal 30 karakter.',

            'nip.unique' =>
                'NIP tersebut sudah digunakan oleh pengguna lain.',


            'no_hp.string' =>
                'Nomor HP harus berupa teks.',

            'no_hp.max' =>
                'Nomor HP maksimal 20 karakter.',


            'jabatan.string' =>
                'Jabatan harus berupa teks.',

            'jabatan.max' =>
                'Jabatan maksimal 150 karakter.',


            'instansi.string' =>
                'Instansi harus berupa teks.',

            'instansi.max' =>
                'Instansi maksimal 150 karakter.',


            'alamat.string' =>
                'Alamat harus berupa teks.',

            'alamat.max' =>
                'Alamat maksimal 1000 karakter.',


            'foto.image' =>
                'File yang dipilih harus berupa gambar.',

            'foto.mimes' =>
                'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',

            'foto.max' =>
                'Ukuran foto maksimal 2 MB.',
        ];
    }

    /**
     * Nama atribut agar pesan validasi lebih mudah dipahami.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama akun',
            'email' => 'email',
            'nama_lengkap' => 'nama lengkap',
            'nip' => 'NIP',
            'no_hp' => 'nomor HP',
            'jabatan' => 'jabatan',
            'instansi' => 'instansi',
            'alamat' => 'alamat',
            'foto' => 'foto profil',
        ];
    }
}