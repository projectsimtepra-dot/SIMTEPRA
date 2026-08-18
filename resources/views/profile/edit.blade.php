@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1>Profil Saya</h1>
        </div>

    </div>

@stop


@section('content')

    @include('components.simtepraloader')


    {{-- =========================================================
         NOTIFIKASI BERHASIL
    ========================================================== --}}

    @if(session('status'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            {{ session('status') }}

            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>

        </div>

    @endif


    {{-- =========================================================
         INFORMASI PROFIL
    ========================================================== --}}

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-user-edit mr-1"></i>

                Informasi Profil

            </h3>

        </div>

        <div class="card-body">

            @include(
                'profile.partials.update-profile-information-form'
            )

        </div>

    </div>


    {{-- =========================================================
         UBAH PASSWORD
    ========================================================== --}}

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-lock mr-1"></i>

                Ubah Password

            </h3>

        </div>

        <div class="card-body">

            @include(
                'profile.partials.update-password-form'
            )

        </div>

    </div>


    {{-- =========================================================
         HAPUS AKUN
    ========================================================== --}}

    <div class="card card-danger">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-user-times mr-1"></i>

                Hapus Akun

            </h3>

        </div>

        <div class="card-body">

            @include(
                'profile.partials.delete-user-form'
            )

        </div>

    </div>

@stop