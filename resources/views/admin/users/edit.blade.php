@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <h1 class="mb-0">
            Edit Pengguna
        </h1>
    </div>

@stop


@section('content')

    @include('components.simtepraloader')


    {{-- =========================================================
         ERROR VALIDASI SERVER
    ========================================================== --}}
    @if ($errors->any())

        <div class="alert alert-danger alert-dismissible fade show">

            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Terjadi Kesalahan
            </h5>

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Tutup">

                <span aria-hidden="true">
                    &times;
                </span>

            </button>

        </div>

    @endif


    {{-- =========================================================
         CARD FORM
    ========================================================== --}}
    <div class="card">

        {{-- HEADER --}}
        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-user-edit mr-1"></i>

                Form Edit Pengguna

            </h3>

        </div>


        {{-- =====================================================
             FORM
        ====================================================== --}}
        <form
            action="{{ route('admin.users.update', $user->id) }}"
            method="POST"
            id="editUserForm"
            novalidate
        >

            @csrf
            @method('PUT')


            <div class="card-body">


                {{-- =================================================
                     NAMA PENGGUNA
                ================================================== --}}
                <div class="form-group">

                    <label for="name">

                        Nama Pengguna

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $user->name) }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Masukkan nama pengguna"
                        autocomplete="name"
                        autofocus
                    >

                    <div id="nameError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Nama pengguna wajib diisi.

                    </div>

                    @error('name')

                        <div class="invalid-feedback d-block">

                            <i class="fas fa-exclamation-circle mr-1"></i>

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- =================================================
                     EMAIL
                ================================================== --}}
                <div class="form-group">

                    <label for="email">

                        Email

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $user->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Masukkan email"
                        autocomplete="email"
                    >

                    <div id="emailError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Email wajib diisi.

                    </div>

                    @error('email')

                        <div class="invalid-feedback d-block">

                            <i class="fas fa-exclamation-circle mr-1"></i>

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- =================================================
                     ROLE
                ================================================== --}}
                <div class="form-group">

                    <label for="role">

                        Role

                        <span class="text-danger">*</span>

                    </label>

                    <select
                        name="role"
                        id="role"
                        class="form-control @error('role') is-invalid @enderror"
                    >

                        <option value="">
                            -- Pilih Role --
                        </option>

                        @foreach ($roles as $role)

                            <option
                                value="{{ $role->name }}"
                                {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}
                            >

                                {{ ucwords(str_replace('-', ' ', $role->name)) }}

                            </option>

                        @endforeach

                    </select>

                    <div id="roleError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Silakan pilih role pengguna.

                    </div>

                    @error('role')

                        <div class="invalid-feedback d-block">

                            <i class="fas fa-exclamation-circle mr-1"></i>

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- =================================================
                     PEMBATAS
                ================================================== --}}
                <hr>


                {{-- =================================================
                     BAGIAN PASSWORD
                ================================================== --}}
                <div class="mb-3">

                    <h5>

                        <i class="fas fa-lock mr-1"></i>

                        Ubah Password

                    </h5>

                    <small class="text-muted">

                        Kosongkan kedua kolom password jika tidak ingin
                        mengubah password pengguna.

                    </small>

                </div>


                {{-- =================================================
                     PASSWORD BARU
                ================================================== --}}
                <div class="form-group">

                    <label for="password">

                        Password Baru

                    </label>

                    <div class="input-group">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter"
                            minlength="8"
                            autocomplete="new-password"
                        >

                        <div class="input-group-append">

                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                data-password-toggle="password"
                                title="Tampilkan password"
                                aria-label="Tampilkan password"
                            >

                                <i class="fas fa-eye"></i>

                            </button>

                        </div>

                    </div>


                    <div id="passwordError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Password baru minimal 8 karakter.

                    </div>


                    @error('password')

                        <div class="invalid-feedback d-block">

                            <i class="fas fa-exclamation-circle mr-1"></i>

                            {{ $message }}

                        </div>

                    @enderror


                    <small class="form-text text-muted">

                        <i class="fas fa-info-circle mr-1"></i>

                        Kosongkan jika password tidak ingin diubah.

                    </small>

                </div>


                {{-- =================================================
                     KONFIRMASI PASSWORD
                ================================================== --}}
                <div class="form-group">

                    <label for="password_confirmation">

                        Konfirmasi Password Baru

                    </label>

                    <div class="input-group">

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password baru"
                            minlength="8"
                            autocomplete="new-password"
                        >

                        <div class="input-group-append">

                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                data-password-toggle="password_confirmation"
                                title="Tampilkan password"
                                aria-label="Tampilkan password"
                            >

                                <i class="fas fa-eye"></i>

                            </button>

                        </div>

                    </div>


                    <div id="passwordConfirmationError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Konfirmasi password wajib diisi jika password baru diisi.

                    </div>

                </div>

            </div>


            {{-- =================================================
                 FOOTER
            ================================================== --}}
            <div class="card-footer">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-danger"
                >

                    <i class="fas fa-times mr-1"></i>

                    Batal

                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                    id="btnSimpan"
                >

                    <i class="fas fa-save mr-1"></i>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

@stop


{{-- =============================================================
     JAVASCRIPT VALIDASI
============================================================= --}}
@push('js')

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */

    const form =
        document.getElementById('editUserForm');

    if (!form) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | INPUT
    |--------------------------------------------------------------------------
    */

    const nameInput =
        document.getElementById('name');

    const emailInput =
        document.getElementById('email');

    const roleInput =
        document.getElementById('role');

    const passwordInput =
        document.getElementById('password');

    const confirmationInput =
        document.getElementById('password_confirmation');


    /*
    |--------------------------------------------------------------------------
    | ERROR ELEMENT
    |--------------------------------------------------------------------------
    */

    const nameError =
        document.getElementById('nameError');

    const emailError =
        document.getElementById('emailError');

    const roleError =
        document.getElementById('roleError');

    const passwordError =
        document.getElementById('passwordError');

    const confirmationError =
        document.getElementById('passwordConfirmationError');


    /*
    |--------------------------------------------------------------------------
    | SHOW ERROR
    |--------------------------------------------------------------------------
    */

    function showError(input, errorElement, message) {

        input.classList.add('is-invalid');

        errorElement.innerHTML =
            '<i class="fas fa-exclamation-circle mr-1"></i> ' +
            message;

        errorElement.style.display = 'block';

    }


    /*
    |--------------------------------------------------------------------------
    | HIDE ERROR
    |--------------------------------------------------------------------------
    */

    function hideError(input, errorElement) {

        input.classList.remove('is-invalid');

        errorElement.style.display = 'none';

    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function (event) {

        event.preventDefault();

        let valid = true;


        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        hideError(nameInput, nameError);
        hideError(emailInput, emailError);
        hideError(roleInput, roleError);
        hideError(passwordInput, passwordError);
        hideError(
            confirmationInput,
            confirmationError
        );


        /*
        |--------------------------------------------------------------------------
        | NAMA
        |--------------------------------------------------------------------------
        */

        if (nameInput.value.trim() === '') {

            showError(
                nameInput,
                nameError,
                'Nama pengguna wajib diisi.'
            );

            valid = false;

        }


        /*
        |--------------------------------------------------------------------------
        | EMAIL
        |--------------------------------------------------------------------------
        */

        const email =
            emailInput.value.trim();

        if (email === '') {

            showError(
                emailInput,
                emailError,
                'Email wajib diisi.'
            );

            valid = false;

        } else {

            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(email)) {

                showError(
                    emailInput,
                    emailError,
                    'Format email tidak valid.'
                );

                valid = false;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        if (roleInput.value === '') {

            showError(
                roleInput,
                roleError,
                'Silakan pilih role pengguna.'
            );

            valid = false;

        }


        /*
        |--------------------------------------------------------------------------
        | PASSWORD BARU
        |--------------------------------------------------------------------------
        |
        | Password boleh kosong pada form edit.
        |
        */

        const password =
            passwordInput.value;

        const confirmation =
            confirmationInput.value;


        if (password !== '') {

            if (password.length < 8) {

                showError(
                    passwordInput,
                    passwordError,
                    'Password baru minimal 8 karakter.'
                );

                valid = false;

            }


            /*
            |--------------------------------------------------------------------------
            | KONFIRMASI PASSWORD
            |--------------------------------------------------------------------------
            */

            if (confirmation === '') {

                showError(
                    confirmationInput,
                    confirmationError,
                    'Konfirmasi password wajib diisi.'
                );

                valid = false;

            } else if (confirmation !== password) {

                showError(
                    confirmationInput,
                    confirmationError,
                    'Konfirmasi password tidak sama dengan password baru.'
                );

                valid = false;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | KONFIRMASI DIISI TAPI PASSWORD KOSONG
        |--------------------------------------------------------------------------
        */

        if (
            password === '' &&
            confirmation !== ''
        ) {

            showError(
                passwordInput,
                passwordError,
                'Silakan isi password baru terlebih dahulu.'
            );

            valid = false;

        }


        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK VALID
        |--------------------------------------------------------------------------
        */

        if (!valid) {

            const firstError =
                form.querySelector('.is-invalid');

            if (firstError) {

                firstError.focus();

                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

            }

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | SUBMIT
        |--------------------------------------------------------------------------
        */

        const submitButton =
            document.getElementById('btnSimpan');

        if (submitButton) {

            submitButton.disabled = true;

            submitButton.innerHTML =
                '<i class="fas fa-spinner fa-spin mr-1"></i> ' +
                'Menyimpan...';

        }


        form.submit();

    });


    /*
    |--------------------------------------------------------------------------
    | VALIDASI NAMA SAAT MENGETIK
    |--------------------------------------------------------------------------
    */

    nameInput.addEventListener('input', function () {

        if (this.value.trim() !== '') {

            hideError(
                this,
                nameError
            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | VALIDASI EMAIL SAAT MENGETIK
    |--------------------------------------------------------------------------
    */

    emailInput.addEventListener('input', function () {

        if (this.value.trim() !== '') {

            hideError(
                this,
                emailError
            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | VALIDASI ROLE
    |--------------------------------------------------------------------------
    */

    roleInput.addEventListener('change', function () {

        if (this.value !== '') {

            hideError(
                this,
                roleError
            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | PASSWORD BARU
    |--------------------------------------------------------------------------
    */

    passwordInput.addEventListener('input', function () {

        const password =
            this.value;

        const confirmation =
            confirmationInput.value;


        /*
        | Password kosong = boleh
        */

        if (password === '') {

            hideError(
                this,
                passwordError
            );

        }


        /*
        | Password kurang dari 8 karakter
        */

        else if (password.length < 8) {

            showError(
                this,
                passwordError,
                'Password baru minimal 8 karakter.'
            );

        }


        /*
        | Password sudah valid
        */

        else {

            hideError(
                this,
                passwordError
            );

        }


        /*
        | Cek konfirmasi jika sudah diisi
        */

        if (confirmation !== '') {

            if (confirmation === password) {

                hideError(
                    confirmationInput,
                    confirmationError
                );

            } else {

                showError(
                    confirmationInput,
                    confirmationError,
                    'Konfirmasi password tidak sama dengan password baru.'
                );

            }

        }

    });


    /*
    |--------------------------------------------------------------------------
    | KONFIRMASI PASSWORD
    |--------------------------------------------------------------------------
    */

    confirmationInput.addEventListener(
        'input',
        function () {

            const confirmation =
                this.value;

            const password =
                passwordInput.value;


            /*
            | Dua-duanya kosong = tidak masalah
            */

            if (
                password === '' &&
                confirmation === ''
            ) {

                hideError(
                    this,
                    confirmationError
                );

                return;

            }


            /*
            | Konfirmasi diisi tapi password kosong
            */

            if (
                password === '' &&
                confirmation !== ''
            ) {

                showError(
                    passwordInput,
                    passwordError,
                    'Silakan isi password baru terlebih dahulu.'
                );

                return;

            }


            /*
            | Konfirmasi kosong
            */

            if (confirmation === '') {

                showError(
                    this,
                    confirmationError,
                    'Konfirmasi password wajib diisi.'
                );

                return;

            }


            /*
            | Password tidak sama
            */

            if (confirmation !== password) {

                showError(
                    this,
                    confirmationError,
                    'Konfirmasi password tidak sama dengan password baru.'
                );

                return;

            }


            /*
            | Password cocok
            */

            hideError(
                this,
                confirmationError
            );

        }
    );

});

</script>

@endpush