@extends('layouts.admin')

@section('title', 'Dashboard SIMTEPRA')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    @include('components.simtepraloader')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Dashboard SIMTEPRA
            </h3>
        </div>

        <div class="card-body">
            <p class="mb-0">
                Selamat datang di Sistem Informasi Monitoring dan Evaluasi
                Pengadaan Pemerintah (SIMTEPRA).
            </p>
        </div>
    </div>

@stop