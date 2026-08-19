@extends('layouts.admin')

@section('title', 'Profil Saya')


{{-- =========================================================
     HEADER
========================================================= --}}

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <h1 class="mb-0">
            Profil Saya
        </h1>

    </div>

@stop


{{-- =========================================================
     CONTENT
========================================================= --}}

@section('content')

    {{-- Loader SIMTEPRA --}}
    @include('components.simtepraloader')


    {{-- =========================================================
         NOTIFIKASI
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

                <span aria-hidden="true">
                    &times;
                </span>

            </button>

        </div>

    @endif


    {{-- =========================================================
         HEADER PROFIL
    ========================================================== --}}

    <div class="card mb-3">

        <div
            class="card-body"
            style="
                background: linear-gradient(135deg, #007bff, #4f8df7);
                border-radius: .25rem;
                color: #fff;
            "
        >

            <div class="d-flex align-items-center">


                {{-- =================================================
                     FOTO PROFIL
                ================================================== --}}

                <div class="mr-3">

                    <img
                        src="{{ $user->adminlte_image() }}"
                        alt="Foto Profil {{ $user->name }}"
                        class="rounded-circle"
                        style="
                            width: 85px;
                            height: 85px;
                            object-fit: cover;
                            border: 4px solid rgba(255,255,255,.7);
                        "
                    >

                </div>


                {{-- =================================================
                     INFORMASI USER
                ================================================== --}}

                <div>

                    <h3 class="mb-1">
                        {{ $user->name }}
                    </h3>


                    <div class="mb-2">

                        <i class="fas fa-envelope mr-1"></i>

                        {{ $user->email }}

                    </div>


                    <span class="badge badge-light text-primary">

                        <i class="fas fa-user-shield mr-1"></i>

                        {{ $user->getRoleNames()->first() ?? 'Pengguna' }}

                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PROFIL + KEAMANAN
    ========================================================== --}}

    <div class="card">


        {{-- =====================================================
             TAB NAVIGASI
        ====================================================== --}}

        <div class="card-header p-0">

            <ul
                class="nav nav-tabs"
                id="profileTabs"
                role="tablist"
            >


                {{-- =================================================
                     TAB PROFIL
                ================================================== --}}

                <li class="nav-item">

                    <a
                        class="nav-link {{ $activeTab === 'profil' ? 'active' : '' }}"
                        id="profile-tab"
                        data-toggle="tab"
                        href="#profile"
                        role="tab"
                        aria-controls="profile"
                        aria-selected="{{ $activeTab === 'profil' ? 'true' : 'false' }}"
                    >

                        <i class="fas fa-user mr-1"></i>

                        Profil

                    </a>

                </li>


                {{-- =================================================
                     TAB KEAMANAN
                ================================================== --}}

                <li class="nav-item">

                    <a
                        class="nav-link {{ $activeTab === 'keamanan' ? 'active' : '' }}"
                        id="security-tab"
                        data-toggle="tab"
                        href="#security"
                        role="tab"
                        aria-controls="security"
                        aria-selected="{{ $activeTab === 'keamanan' ? 'true' : 'false' }}"
                    >

                        <i class="fas fa-lock mr-1"></i>

                        Keamanan

                    </a>

                </li>

            </ul>

        </div>


        {{-- =====================================================
             TAB CONTENT
        ====================================================== --}}

        <div class="card-body">

            <div class="tab-content">


                {{-- =================================================
                     TAB PROFIL
                ================================================== --}}

                <div
                    class="tab-pane fade {{ $activeTab === 'profil' ? 'show active' : '' }}"
                    id="profile"
                    role="tabpanel"
                    aria-labelledby="profile-tab"
                >

                    @include(
                        'profile.partials.update-profile-information-form'
                    )

                </div>


                {{-- =================================================
                     TAB KEAMANAN
                ================================================== --}}

                <div
                    class="tab-pane fade {{ $activeTab === 'keamanan' ? 'show active' : '' }}"
                    id="security"
                    role="tabpanel"
                    aria-labelledby="security-tab"
                >

                    @include(
                        'profile.partials.update-password-form'
                    )

                </div>

            </div>

        </div>

    </div>

@stop