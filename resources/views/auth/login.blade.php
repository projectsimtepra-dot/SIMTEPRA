<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>Login - SIMTEPRA</title>

    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- AdminLTE --}}
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <style>

        html,
        body {
            height: 100%;
        }

        body {
            background: #f4f6f9;
        }

        .login-page {
            min-height: 100vh;
        }

        .login-box {
            width: 400px;
        }

        .login-logo {
            margin-bottom: 20px;
        }

        .login-logo a {
            color: #343a40;
            font-size: 32px;
            font-weight: 600;
        }

        .login-logo .brand-subtitle {
            display: block;
            font-size: 14px;
            color: #6c757d;
            margin-top: 5px;
            font-weight: 400;
        }

        .card {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #eeeeee;
            padding: 20px 25px;
        }

        .card-body {
            padding: 25px;
        }

        .login-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .form-control {
            height: 45px;
        }

        .input-group-text {
            background: #f8f9fa;
        }

        .btn-login {
            height: 45px;
            font-weight: 600;
        }

       .simtepra-footer {
            text-align: center;
            color: #6c757d;
            font-size: 13px;
            margin-top: 20px;
        }

    </style>

</head>

<body class="hold-transition login-page">

<div class="login-box">

    {{-- Logo / Branding --}}
    <div class="login-logo">

        <a href="{{ url('/') }}">
            <b>SIMTEPRA</b></br>
        </a>

        <span class="brand-subtitle">
            Sistem Informasi Monitoring dan Evaluasi Pengadaan Pemerintah
        </span>

    </div>


    {{-- Login Card --}}
    <div class="card">

        <div class="card-header">

            <h3 class="login-title">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Login
            </h3>

        </div>


        <div class="card-body">


            {{-- Session Status --}}
            @if (session('status'))

                <div class="alert alert-success alert-dismissible fade show">

                    <i class="fas fa-check-circle mr-1"></i>

                    {{ session('status') }}

                    <button type="button"
                            class="close"
                            data-dismiss="alert">

                        <span>&times;</span>

                    </button>

                </div>

            @endif


            {{-- General Error --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <i class="fas fa-exclamation-circle mr-1"></i>

                    Email atau password yang Anda masukkan tidak sesuai.

                </div>

            @endif


            {{-- Login Form --}}
            <form method="POST"
                  action="{{ route('login') }}">

                @csrf


                {{-- Email --}}
                <div class="form-group">

                    <label for="email">
                        Alamat Email
                    </label>

                    <div class="input-group">

                        <div class="input-group-prepend">

                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>

                        </div>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email"
                            required
                            autofocus
                            autocomplete="username"
                        >

                        @error('email')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>


                {{-- Password --}}
                <div class="form-group">

                    <label for="password">
                        Kata Sandi
                    </label>

                    <div class="input-group">

                        <div class="input-group-prepend">

                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>

                        </div>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password"
                        >

                        @error('password')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>


                {{-- Remember Me + Forgot Password --}}
                <div class="row align-items-center">

                    <div class="col-7">

                        <div class="icheck-primary">

                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                            >

                            <label for="remember">
                                Ingat saya
                            </label>

                        </div>

                    </div>

                </div>


                {{-- Login Button --}}
                <div class="row mt-4">

                    <div class="col-12">

                        <button type="submit"
                                class="btn btn-primary btn-block btn-login">

                            <i class="fas fa-sign-in-alt mr-1"></i>

                            Masuk

                        </button>

                    </div>

                </div>

            </form>


        </div>

    </div>


    {{-- Footer --}}
    <div class="simtepra-footer">

        <div>
            &copy; {{ date('Y') }} SIMTEPRA
        </div>

        <div>
            Sistem Informasi Monitoring dan Evaluasi Pengadaan Pemerintah
        </div>

    </div>

</div>


{{-- jQuery --}}
<script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>

{{-- Bootstrap --}}
<script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

{{-- AdminLTE --}}
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

</body>

</html>