@extends('layouts.admin')

@section('title', 'Manajemen Permission')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Manajemen Permission</h1>

        @can('permissions.create')
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i>
                Tambah Permission
            </a>
        @endcan
    </div>
@stop

@section('content')

    @include('components.simtepraloader')

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ session('error') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif


    <div class="card">

        {{-- =========================================================
             CARD HEADER
        ========================================================== --}}
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-key mr-1"></i>
                Daftar Permission
            </h3>

            <div class="card-tools">
                <span class="badge badge-primary">
                    {{ $permissions->total() }} Permission
                </span>
            </div>
        </div>


        {{-- =========================================================
             FILTER / JUMLAH DATA
        ========================================================== --}}
        <div class="card-body border-bottom py-3">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                {{-- Tampilkan jumlah data --}}
                <form method="GET"
                      action="{{ route('admin.permissions.index') }}"
                      class="form-inline">

                    {{-- Pertahankan parameter pencarian jika nanti ditambahkan --}}
                    @if(request('search'))
                        <input type="hidden"
                               name="search"
                               value="{{ request('search') }}">
                    @endif

                    <label for="per_page" class="mb-0 mr-2 font-weight-normal">
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

                    @if($permissions->total() > 0)

                        Menampilkan
                        <strong>{{ $permissions->firstItem() }}</strong>
                        -
                        <strong>{{ $permissions->lastItem() }}</strong>
                        dari
                        <strong>{{ $permissions->total() }}</strong>
                        data

                    @else

                        Tidak ada data

                    @endif

                </div>

            </div>

        </div>


        {{-- =========================================================
             TABLE
        ========================================================== --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-bordered mb-0">

                    <thead>
                        <tr>
                            <th width="70">No</th>
                            <th>Nama Permission</th>
                            <th width="150">Guard</th>
                            <th width="180">Dibuat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($permissions as $permission)

                            <tr>

                                <td>
                                    {{ $permissions->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <span class="badge badge-info">
                                        {{ $permission->name }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge badge-secondary">
                                        {{ $permission->guard_name }}
                                    </span>
                                </td>

                                <td>
                                    {{ $permission->created_at?->format('d-m-Y H:i') ?? '-' }}
                                </td>

                                <td>

                                    @can('permissions.edit')

                                        <a href="{{ route('admin.permissions.edit', $permission) }}"
                                           class="btn btn-warning btn-sm"
                                           title="Edit">

                                            <i class="fas fa-edit"></i>

                                        </a>

                                    @endcan


                                    @can('permissions.delete')

                                        <form action="{{ route('admin.permissions.destroy', $permission) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus permission ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    title="Hapus">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                    @endcan

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-5">

                                    <i class="fas fa-key fa-2x text-muted mb-3"></i>

                                    <p class="mb-0">
                                        Belum ada permission.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =========================================================
             PAGINATION
        ========================================================== --}}
        @if($permissions->hasPages())

            <div class="card-footer">

                <div class="d-flex justify-content-end">

                    {{ $permissions->withQueryString()->links('pagination::bootstrap-4') }}

                </div>

            </div>

        @endif

    </div>

@stop