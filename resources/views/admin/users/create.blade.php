@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">

        <h1 class="mb-0">
            Tambah Pengguna
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

                <i class="fas fa-user-plus mr-1"></i>

                Form Tambah Pengguna

            </h3>

        </div>


        {{-- =====================================================
             FORM
        ====================================================== --}}
        <form action="{{ route('admin.users.store') }}"
              method="POST"
              id="createUserForm"
              novalidate>

            @csrf


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
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Masukkan nama pengguna"
                        autocomplete="name"
                        autofocus
                    >

                    {{-- Error JavaScript --}}
                    <div id="nameError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Nama pengguna wajib diisi.

                    </div>

                    {{-- Error Laravel --}}
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
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="contoh@simtepra.local"
                        autocomplete="email"
                    >

                    {{-- Error JavaScript --}}
                    <div id="emailError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Email wajib diisi.

                    </div>

                    {{-- Error Laravel --}}
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
                                {{ old('role') === $role->name ? 'selected' : '' }}
                            >

                                {{ ucwords(str_replace('-', ' ', $role->name)) }}

                            </option>

                        @endforeach

                    </select>

                    {{-- Error JavaScript --}}
                    <div id="roleError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Silakan pilih role pengguna.

                    </div>

                    {{-- Error Laravel --}}
                    @error('role')

                        <div class="invalid-feedback d-block">

                            <i class="fas fa-exclamation-circle mr-1"></i>

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- =================================================
                     PASSWORD
                ================================================== --}}
                <div class="form-group">

                    <label for="password">

                        Password

                        <span class="text-danger">*</span>

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

                    {{-- Error JavaScript --}}
                    <div id="passwordError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Password wajib diisi.

                    </div>


                    @error('password')

                        <div class="invalid-feedback d-block">

                            <i class="fas fa-exclamation-circle mr-1"></i>

                            {{ $message }}

                        </div>

                    @else

                        <small class="form-text text-muted">

                            <i class="fas fa-info-circle mr-1"></i>

                            Password minimal 8 karakter.

                        </small>

                    @enderror

                </div>


                {{-- =================================================
                     KONFIRMASI PASSWORD
                ================================================== --}}
                <div class="form-group">

                    <label for="password_confirmation">

                        Konfirmasi Password

                        <span class="text-danger">*</span>

                    </label>


                    <div class="input-group">

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password"
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


                    {{-- Error JavaScript --}}
                    <div id="passwordConfirmationError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Konfirmasi password wajib diisi.

                    </div>


                    @error('password_confirmation')

                        <div class="invalid-feedback d-block">

                            <i class="fas fa-exclamation-circle mr-1"></i>

                            {{ $message }}

                        </div>

                    @enderror

                </div>

            </div>


            {{-- =================================================
                 FOOTER
            ================================================== --}}
            <div class="card-footer">

                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-danger">

                    <i class="fas fa-times mr-1"></i>
                    Batal

                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                    id="btnSimpan"
                >

                    <i class="fas fa-save mr-1"></i>

                    Simpan Pengguna

                </button>

            </div>

        </form>

    </div>

@stop


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}
@push('js')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | TOGGLE PASSWORD
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.password-toggle').forEach(function (button) {

        button.addEventListener('click', function () {

            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);

            if (!input) {
                return;
            }

            const icon = this.querySelector('i');

            if (input.type === 'password') {

                // Tampilkan password
                input.type = 'text';

                if (icon) {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }

                this.setAttribute(
                    'title',
                    'Sembunyikan password'
                );

                this.setAttribute(
                    'aria-label',
                    'Sembunyikan password'
                );

            } else {

                // Sembunyikan password
                input.type = 'password';

                if (icon) {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }

                this.setAttribute(
                    'title',
                    'Tampilkan password'
                );

                this.setAttribute(
                    'aria-label',
                    'Tampilkan password'
                );

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | ELEMENT FORM
    |--------------------------------------------------------------------------
    */

    const form = document.getElementById('createUserForm');

    if (!form) {
        return;
    }

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const roleInput = document.getElementById('role');
    const passwordInput = document.getElementById('password');
    const confirmationInput =
        document.getElementById('password_confirmation');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const roleError = document.getElementById('roleError');
    const passwordError = document.getElementById('passwordError');
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
    | SUBMIT FORM
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function (event) {

        // Matikan validasi bawaan browser
        event.preventDefault();

        let valid = true;


        /*
        |--------------------------------------------------------------------------
        | RESET ERROR
        |--------------------------------------------------------------------------
        */

        hideError(nameInput, nameError);
        hideError(emailInput, emailError);
        hideError(roleInput, roleError);
        hideError(passwordInput, passwordError);
        hideError(confirmationInput, confirmationError);


        /*
        |--------------------------------------------------------------------------
        | NAMA
        |--------------------------------------------------------------------------
        */

        const name = nameInput.value.trim();

        if (name === '') {

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

        const email = emailInput.value.trim();

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
        | PASSWORD
        |--------------------------------------------------------------------------
        */

        const password = passwordInput.value;

        if (password === '') {

            showError(
                passwordInput,
                passwordError,
                'Password wajib diisi.'
            );

            valid = false;

        } else if (password.length < 8) {

            showError(
                passwordInput,
                passwordError,
                'Password minimal 8 karakter.'
            );

            valid = false;

        }


        /*
        |--------------------------------------------------------------------------
        | KONFIRMASI PASSWORD
        |--------------------------------------------------------------------------
        */

        const confirmation =
            confirmationInput.value;

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
                'Konfirmasi password tidak sama dengan password.'
            );

            valid = false;

        }


        /*
        |--------------------------------------------------------------------------
        | JIKA VALIDASI GAGAL
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

        // Kirim form ke Laravel
        form.submit();

    });


    /*
    |--------------------------------------------------------------------------
    | VALIDASI SAAT MENGETIK
    |--------------------------------------------------------------------------
    */

    nameInput.addEventListener('input', function () {

        if (this.value.trim() !== '') {

            hideError(this, nameError);

        }

    });


    emailInput.addEventListener('input', function () {

        if (this.value.trim() !== '') {

            hideError(this, emailError);

        }

    });


    roleInput.addEventListener('change', function () {

        if (this.value !== '') {

            hideError(this, roleError);

        }

    });


    passwordInput.addEventListener('input', function () {

        const password = this.value;

        if (password === '') {

            showError(
                this,
                passwordError,
                'Password wajib diisi.'
            );

        } else if (password.length < 8) {

            showError(
                this,
                passwordError,
                'Password minimal 8 karakter.'
            );

        } else {

            hideError(this, passwordError);

        }


        // Cek konfirmasi password jika sudah diisi
        if (confirmationInput.value !== '') {

            if (confirmationInput.value === password) {

                hideError(
                    confirmationInput,
                    confirmationError
                );

            } else {

                showError(
                    confirmationInput,
                    confirmationError,
                    'Konfirmasi password tidak sama dengan password.'
                );

            }

        }

    });


    confirmationInput.addEventListener('input', function () {

        const confirmation = this.value;
        const password = passwordInput.value;

        if (confirmation === '') {

            showError(
                this,
                confirmationError,
                'Konfirmasi password wajib diisi.'
            );

            return;

        }

        if (confirmation === password) {

            hideError(
                this,
                confirmationError
            );

        } else {

            showError(
                this,
                confirmationError,
                'Konfirmasi password tidak sama dengan password.'
            );

        }

    });

});
</script>

@endpush