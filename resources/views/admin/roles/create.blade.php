@extends('layouts.admin')

@section('title', 'Tambah Role')

@section('content_header')
    <h1>Tambah Role</h1>
@stop

@section('content')

    @include('components.simtepraloader')
    
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-shield mr-1"></i>
                Form Tambah Role
            </h3>
        </div>

        <form action="{{ route('admin.roles.store') }}" method="POST">

            @csrf

            <div class="card-body">

                {{-- Error --}}
                @if($errors->any())
                    <div class="alert alert-danger">

                        <strong>Terjadi kesalahan:</strong>

                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>
                @endif


                {{-- Nama Role --}}
                <div class="form-group">

                    <label for="name">
                        Nama Role
                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Contoh: admin"
                           required>

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="form-text text-muted">
                        Contoh nama role:
                        <code>admin</code>,
                        <code>viewer</code>.
                    </small>

                </div>


                {{-- Permission --}}
                <div class="form-group">

                    <label>
                        Permission
                    </label>

                    <div class="border rounded p-3">

                        @forelse($permissions as $permission)

                            <div class="custom-control custom-checkbox mb-2">

                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="permission_{{ $permission->id }}"
                                       name="permissions[]"
                                       value="{{ $permission->name }}"
                                       {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>

                                <label class="custom-control-label"
                                       for="permission_{{ $permission->id }}">

                                    {{ $permission->name }}

                                </label>

                            </div>

                        @empty

                            <p class="text-muted mb-0">
                                Belum ada permission.
                            </p>

                        @endforelse

                    </div>

                </div>

            </div>


            <div class="card-footer">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan
                </button>

                <a href="{{ route('admin.roles.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left"></i>
                    Kembali

                </a>

            </div>

        </form>

    </div>

@stop