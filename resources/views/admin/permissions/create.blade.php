@extends('layouts.admin')

@section('title', 'Tambah Permission')


@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <h1 class="mb-0">
            Tambah Permission
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
         CARD
    ========================================================== --}}
    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-key mr-1"></i>

                Form Permission

            </h3>

        </div>


        {{-- =====================================================
             FORM
        ====================================================== --}}
        <form
            action="{{ route('admin.permissions.store') }}"
            method="POST"
            id="permissionForm"
            novalidate
        >

            @csrf


            <div class="card-body">


                {{-- =================================================
                     NAMA PERMISSION
                ================================================== --}}
                <div class="form-group">

                    <label for="name">

                        Nama Permission

                        <span class="text-danger">*</span>

                    </label>


                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Contoh: users.view"
                        autocomplete="off"
                        autofocus
                    >


                    {{-- Error dari JavaScript --}}

                    <div id="nameError"
                         class="invalid-feedback">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Nama permission wajib diisi.

                    </div>


                    {{-- Error dari Laravel --}}

                    @error('name')

                        <div class="invalid-feedback d-block">

                            <i class="fas fa-exclamation-circle mr-1"></i>

                            {{ $message }}

                        </div>

                    @enderror


                    <small class="form-text text-muted">

                        <i class="fas fa-info-circle mr-1"></i>

                        Gunakan format seperti:

                        <code>users.view</code>,

                        <code>users.create</code>,

                        <code>reports.export</code>.

                    </small>

                </div>


            </div>


            {{-- =================================================
                 FOOTER
            ================================================== --}}
            <div class="card-footer">

                <a
                    href="{{ route('admin.permissions.index') }}"
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

                    Simpan Permission

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
        document.getElementById('permissionForm');

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


    /*
    |--------------------------------------------------------------------------
    | ERROR
    |--------------------------------------------------------------------------
    */

    const nameError =
        document.getElementById('nameError');


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN ERROR
    |--------------------------------------------------------------------------
    */

    function showError(message) {

        nameInput.classList.add('is-invalid');

        nameError.innerHTML =
            '<i class="fas fa-exclamation-circle mr-1"></i> ' +
            message;

        nameError.style.display = 'block';

    }


    /*
    |--------------------------------------------------------------------------
    | HILANGKAN ERROR
    |--------------------------------------------------------------------------
    */

    function hideError() {

        nameInput.classList.remove('is-invalid');

        nameError.style.display = 'none';

    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT FORM
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function (event) {

        event.preventDefault();


        /*
        | Reset error
        */

        hideError();


        const name =
            nameInput.value.trim();


        /*
        |--------------------------------------------------------------------------
        | KOSONG
        |--------------------------------------------------------------------------
        */

        if (name === '') {

            showError(
                'Nama permission wajib diisi.'
            );

            nameInput.focus();

            nameInput.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT PERMISSION
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | users.view
        | users.create
        | reports.export
        |
        */

        const permissionPattern =
            /^[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+$/;


        if (!permissionPattern.test(name)) {

            showError(
                'Format permission tidak valid. Contoh: users.view'
            );

            nameInput.focus();

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
    | HILANGKAN ERROR SAAT USER MENGETIK
    |--------------------------------------------------------------------------
    */

    nameInput.addEventListener('input', function () {

        const value =
            this.value.trim();


        if (value !== '') {

            hideError();

        }

    });

});

</script>

@endpush