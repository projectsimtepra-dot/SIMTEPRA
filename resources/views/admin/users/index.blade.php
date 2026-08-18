@extends('layouts.admin')

@section('title', 'Pengguna SIMTEPRA')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Daftar Pengguna</h1>

        @can('users.create')
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus mr-1"></i>
                Tambah Pengguna
            </a>
        @endcan
    </div>
@stop


@section('content')

    @include('components.simtepraloader')


    {{-- =========================================================
         NOTIFIKASI SUCCESS
    ========================================================== --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>
    @endif


    {{-- =========================================================
         NOTIFIKASI ERROR
    ========================================================== --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ session('error') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>
    @endif


    {{-- =========================================================
         CARD DATA PENGGUNA
    ========================================================== --}}
    <div class="card">


        {{-- =====================================================
             CARD HEADER
        ====================================================== --}}
        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-users mr-1"></i>
                Data Pengguna
            </h3>

            <div class="card-tools">

                <span class="badge badge-primary">
                    {{ $users->total() }} Pengguna
                </span>

            </div>

        </div>


        {{-- =====================================================
             FILTER JUMLAH DATA
        ====================================================== --}}
        <div class="card-body border-bottom py-3">

            <div class="d-flex justify-content-between align-items-center flex-wrap">


                {{-- Tampilkan jumlah data --}}
                <form method="GET"
                      action="{{ route('admin.users.index') }}"
                      class="form-inline">

                    <label for="per_page"
                           class="mb-0 mr-2 font-weight-normal">

                        Tampilkan:

                    </label>


                    <select name="per_page"
                            id="per_page"
                            class="form-control form-control-sm"
                            onchange="this.form.submit()">

                        <option value="10"
                            {{ request('per_page', 10) == 10 ? 'selected' : '' }}>
                            10
                        </option>

                        <option value="20"
                            {{ request('per_page') == 20 ? 'selected' : '' }}>
                            20
                        </option>

                        <option value="30"
                            {{ request('per_page') == 30 ? 'selected' : '' }}>
                            30
                        </option>

                    </select>


                    <span class="ml-2">
                        data per halaman
                    </span>

                </form>


                {{-- Informasi jumlah data --}}
                <div class="text-muted small mt-2 mt-md-0">

                    @if($users->total() > 0)

                        Menampilkan
                        <strong>{{ $users->firstItem() }}</strong>
                        -
                        <strong>{{ $users->lastItem() }}</strong>
                        dari
                        <strong>{{ $users->total() }}</strong>
                        data

                    @else

                        Tidak ada data

                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
             TABLE
        ====================================================== --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-striped table-bordered mb-0">


                    {{-- TABLE HEADER --}}
                    <thead>

                        <tr>

                            <th width="60" class="text-center">
                                No
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th width="160" class="text-center">
                                Status
                            </th>

                            <th width="150" class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    {{-- TABLE BODY --}}
                    <tbody>

                        @forelse($users as $user)

                            <tr>


                                {{-- =================================================
                                     NOMOR
                                ================================================== --}}
                                <td class="text-center">

                                    {{ $users->firstItem() + $loop->index }}

                                </td>


                                {{-- =================================================
                                     NAMA
                                ================================================== --}}
                                <td>

                                    <strong>
                                        {{ $user->name }}
                                    </strong>

                                </td>


                                {{-- =================================================
                                     EMAIL
                                ================================================== --}}
                                <td>

                                    {{ $user->email }}

                                </td>


                                {{-- =================================================
                                     ROLE
                                ================================================== --}}
                                <td>

                                    @forelse($user->roles as $role)

                                        @php

                                            $roleBadge = match($role->name) {

                                                'super-admin' => 'danger',

                                                'admin-tepra' => 'primary',

                                                'operator-opd' => 'info',

                                                'verifikator' => 'warning',

                                                'pimpinan' => 'success',

                                                default => 'secondary',

                                            };

                                        @endphp


                                        <span class="badge badge-{{ $roleBadge }}">

                                            {{ ucwords(str_replace('-', ' ', $role->name)) }}

                                        </span>

                                    @empty

                                        <span class="badge badge-secondary">

                                            Belum ada role

                                        </span>

                                    @endforelse

                                </td>


                                {{-- =================================================
                                     STATUS
                                ================================================== --}}
                                <td class="text-center">

                                    @if($user->email_verified_at)

                                        <span class="badge badge-success">

                                            <i class="fas fa-check-circle mr-1"></i>
                                            Aktif

                                        </span>

                                    @else

                                        <span class="badge badge-warning">

                                            <i class="fas fa-clock mr-1"></i>
                                            Belum Verifikasi

                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                     AKSI
                                ================================================== --}}
                                <td class="text-center">


                                    {{-- EDIT --}}
                                    @can('users.edit')

                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Edit">

                                            <i class="fas fa-edit"></i>

                                        </a>

                                    @endcan


                                    {{-- HAPUS --}}
                                    @can('users.delete')

                                        @if($user->id !== auth()->id())

                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Hapus">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        @endif

                                    @endcan

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>

                                    <p class="text-muted mb-0">

                                        Belum ada data pengguna.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
             PAGINATION
        ====================================================== --}}
        @if($users->hasPages())

            <div class="card-footer">

                <div class="d-flex justify-content-end">

                    {{ $users->withQueryString()->links('pagination::bootstrap-4') }}

                </div>

            </div>

        @endif


    </div>

@stop