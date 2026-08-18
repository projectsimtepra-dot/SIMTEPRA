@extends('adminlte::page')

@section('title', $title ?? 'SIMTEPRA')


{{-- =========================================================
     CSS
========================================================= --}}
@section('css')

    {{-- CSS Loader SIMTEPRA --}}
    <link rel="stylesheet"
          href="{{ asset('css/simtepraloader.css') }}">

    {{-- CSS tambahan dari halaman --}}
    @stack('css')

@stop


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}
@section('js')

    {{-- JS tambahan dari halaman --}}
    @stack('js')


    {{-- =====================================================
         PASSWORD TOGGLE GLOBAL SIMTEPRA
    ====================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('[data-password-toggle]').forEach(function (button) {

                button.addEventListener('click', function (event) {

                    event.preventDefault();

                    const targetId = this.getAttribute('data-password-toggle');
                    const input = document.getElementById(targetId);

                    if (!input) {
                        console.warn(
                            'Input password tidak ditemukan:',
                            targetId
                        );

                        return;
                    }

                    const icon = this.querySelector('i');


                    /*
                    |--------------------------------------------------------------------------
                    | TAMPILKAN PASSWORD
                    |--------------------------------------------------------------------------
                    */

                    if (input.type === 'password') {

                        input.type = 'text';

                        if (icon) {
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        }

                        this.setAttribute(
                            'title',
                            'Sembunyikan password'
                        );

                        this.setAttribute(
                            'aria-label',
                            'Sembunyikan password'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SEMBUNYIKAN PASSWORD
                    |--------------------------------------------------------------------------
                    */

                    else {

                        input.type = 'password';

                        if (icon) {
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }

                        this.setAttribute(
                            'title',
                            'Tampilkan password'
                        );

                        this.setAttribute(
                            'aria-label',
                            'Tampilkan password'
                        );

                    }

                });

            });

        });
    </script>

@stop