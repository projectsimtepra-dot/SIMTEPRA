@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content_header')
    <h1>Edit Role</h1>
@stop

@section('content')

    @include('components.simtepraloader')
    
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


    {{-- Informasi --}}
    <div class="alert alert-info">
        <i class="fas fa-info-circle mr-1"></i>

        Atur permission yang dimiliki oleh role
        <strong>{{ ucwords(str_replace('-', ' ', $role->name)) }}</strong>.
    </div>


    <div class="card">

        {{-- Card Header --}}
        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-user-shield mr-1"></i>

                Permission Role:
                <strong>
                    {{ ucwords(str_replace('-', ' ', $role->name)) }}
                </strong>
            </h3>

        </div>


        {{-- Form --}}
        <form action="{{ route('admin.roles.update', $role) }}"
              method="POST">

            @csrf
            @method('PUT')


            <div class="card-body">

                {{-- Nama Role --}}
                <div class="form-group">

                    <label>Nama Role</label>

                    <input type="text"
                           class="form-control"
                           value="{{ ucwords(str_replace('-', ' ', $role->name)) }}"
                           readonly>

                </div>


                <hr>


                {{-- Permission --}}
                <h5 class="mb-3">

                    <i class="fas fa-key mr-1"></i>
                    Daftar Permission

                </h5>


                @php
                    $groupedPermissions = $permissions->groupBy(function ($permission) {

                        return explode('.', $permission->name)[0];

                    });
                @endphp


                @foreach($groupedPermissions as $group => $groupPermissions)

                    <div class="card card-outline card-primary mb-3">

                        <div class="card-header">

                            <h3 class="card-title text-capitalize">

                                <i class="fas fa-folder mr-1"></i>

                                {{ str_replace('-', ' ', $group) }}

                            </h3>

                        </div>


                        <div class="card-body">

                            <div class="row">

                                @foreach($groupPermissions as $permission)

                                    <div class="col-md-4 mb-2">

                                        <div class="custom-control custom-checkbox">

                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="permission_{{ $permission->id }}"
                                                   name="permissions[]"
                                                   value="{{ $permission->id }}"

                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}

                                                {{ $role->name === 'super-admin' ? 'checked disabled' : '' }}>

                                            <label class="custom-control-label"
                                                   for="permission_{{ $permission->id }}">

                                                {{ $permission->name }}

                                            </label>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Footer --}}
            <div class="card-footer">

                <a href="{{ route('admin.roles.index') }}"
                   class="btn btn-secondary">

                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali

                </a>


                @if($role->name !== 'super-admin')

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-save mr-1"></i>
                        Simpan Permission

                    </button>

                @else

                    <span class="text-muted ml-2">

                        <i class="fas fa-lock mr-1"></i>

                        Permission Super Admin tidak dapat diubah.

                    </span>

                @endif

            </div>

        </form>

    </div>

@stop