@extends('layouts.admin')

@section('title', 'Manajemen Role')

@section('content_header')
    <h1>Manajemen Role</h1>
@stop

@section('content')

    @include('components.simtepraloader')
    
    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ session('error') }}

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif


    {{-- Informasi Role Sistem --}}
    <div class="alert alert-info">
        <i class="fas fa-info-circle mr-1"></i>

        SIMTEPRA menggunakan 3 role sistem:
        <strong>Super Admin</strong>,
        <strong>Admin</strong>, dan
        <strong>Viewer</strong>.

        Role sistem tidak dapat dibuat atau dihapus.
    </div>


    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-user-shield mr-1"></i>
                Data Role
            </h3>

            <div class="card-tools">
                <span class="badge badge-info">
                    {{ $roles->count() }} Role Sistem
                </span>
            </div>

        </div>


        <div class="card-body p-0">

            <table class="table table-bordered table-hover mb-0">

                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Role</th>
                        <th width="180">Jumlah Pengguna</th>
                        <th width="130">Aksi</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse($roles as $role)

                        <tr>

                            {{-- No --}}
                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- Nama Role --}}
                            <td>

                                @if($role->name === 'super-admin')

                                    <span class="badge badge-danger">
                                        <i class="fas fa-user-shield mr-1"></i>
                                        Super Admin
                                    </span>

                                @elseif($role->name === 'admin')

                                    <span class="badge badge-primary">
                                        <i class="fas fa-user-cog mr-1"></i>
                                        Admin
                                    </span>

                                @elseif($role->name === 'viewer')

                                    <span class="badge badge-secondary">
                                        <i class="fas fa-eye mr-1"></i>
                                        Viewer
                                    </span>

                                @endif

                            </td>


                            {{-- Jumlah User --}}
                            <td>

                                <i class="fas fa-users mr-1"></i>

                                {{ $role->users_count }}

                                {{ $role->users_count == 1 ? 'User' : 'User' }}

                            </td>


                            {{-- Aksi --}}
                            <td>

                                <a href="{{ route('admin.roles.edit', $role) }}"
                                   class="btn btn-warning btn-sm"
                                   title="Atur Permission">

                                    <i class="fas fa-user-shield mr-1"></i>
                                    Permission

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center py-4">

                                <i class="fas fa-info-circle mr-1"></i>

                                Belum ada data role.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@stop