<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna boleh memperbarui profil.
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
            | Nama Lengkap
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Email
            |--------------------------------------------------------------------------
            */

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
            | Foto Profil
            |--------------------------------------------------------------------------
            */

            'profile_photo' => [
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

            /*
            | Nama
            */

            'name.required' =>
                'Nama lengkap wajib diisi.',

            'name.string' =>
                'Nama lengkap harus berupa teks.',

            'name.max' =>
                'Nama lengkap maksimal 255 karakter.',


            /*
            | Email
            */

            'email.required' =>
                'Email wajib diisi.',

            'email.string' =>
                'Email harus berupa teks.',

            'email.lowercase' =>
                'Email harus menggunakan huruf kecil.',

            'email.email' =>
                'Format email tidak valid.',

            'email.max' =>
                'Email maksimal 255 karakter.',

            'email.unique' =>
                'Email tersebut sudah digunakan oleh pengguna lain.',


            /*
            | Foto Profil
            */

            'profile_photo.image' =>
                'File yang dipilih harus berupa gambar.',

            'profile_photo.mimes' =>
                'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',

            'profile_photo.max' =>
                'Ukuran foto maksimal 2 MB.',
        ];
    }


    /**
     * Nama atribut agar pesan validasi lebih mudah dipahami.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama lengkap',
            'email' => 'email',
            'profile_photo' => 'foto profil',
        ];
    }
}