<section>

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="mb-4">

        <h4 class="mb-1">
            <i class="fas fa-shield-alt mr-2"></i>
            Keamanan Akun
        </h4>

        <p class="text-muted mb-0">
            Perbarui password secara berkala untuk menjaga keamanan akun Anda.
        </p>

    </div>


    {{-- =========================================================
         FORM PASSWORD
    ========================================================== --}}

    <form
        method="post"
        action="{{ route('password.update') }}"
    >

        @csrf
        @method('put')


        {{-- =====================================================
             PASSWORD SAAT INI
        ====================================================== --}}

        <div class="form-group">

            <label for="update_password_current_password">
                Password Saat Ini
                <span class="text-danger">*</span>
            </label>

            <div class="input-group">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>

                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="form-control @if($errors->updatePassword->get('current_password')) is-invalid @endif"
                    autocomplete="current-password"
                    placeholder="Masukkan password saat ini"
                >

                <div class="input-group-append">

                    <button
                        type="button"
                        class="btn btn-outline-secondary toggle-password"
                        data-target="update_password_current_password"
                        title="Tampilkan password"
                        aria-label="Tampilkan password"
                    >
                        <i class="fas fa-eye"></i>
                    </button>

                </div>

            </div>


            @if ($errors->updatePassword->get('current_password'))

                <div class="text-danger small mt-1">

                    <i class="fas fa-exclamation-circle mr-1"></i>

                    {{ $errors->updatePassword->first('current_password') }}

                </div>

            @endif

        </div>


        {{-- =====================================================
             PASSWORD BARU
        ====================================================== --}}

        <div class="form-group">

            <label for="update_password_password">
                Password Baru
                <span class="text-danger">*</span>
            </label>

            <div class="input-group">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-key"></i>
                    </span>
                </div>

                <input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="form-control @if($errors->updatePassword->get('password')) is-invalid @endif"
                    autocomplete="new-password"
                    placeholder="Masukkan password baru"
                >

                <div class="input-group-append">

                    <button
                        type="button"
                        class="btn btn-outline-secondary toggle-password"
                        data-target="update_password_password"
                        title="Tampilkan password"
                        aria-label="Tampilkan password"
                    >
                        <i class="fas fa-eye"></i>
                    </button>

                </div>

            </div>


            @if ($errors->updatePassword->get('password'))

                <div class="text-danger small mt-1">

                    <i class="fas fa-exclamation-circle mr-1"></i>

                    {{ $errors->updatePassword->first('password') }}

                </div>

            @endif


            <small class="form-text text-muted">
                Gunakan password yang kuat dan sulit ditebak.
            </small>

        </div>


        {{-- =====================================================
             KONFIRMASI PASSWORD BARU
        ====================================================== --}}

        <div class="form-group">

            <label for="update_password_password_confirmation">
                Konfirmasi Password Baru
                <span class="text-danger">*</span>
            </label>

            <div class="input-group">

                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fas fa-check-circle"></i>
                    </span>
                </div>

                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="form-control @if($errors->updatePassword->get('password_confirmation')) is-invalid @endif"
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                >

                <div class="input-group-append">

                    <button
                        type="button"
                        class="btn btn-outline-secondary toggle-password"
                        data-target="update_password_password_confirmation"
                        title="Tampilkan password"
                        aria-label="Tampilkan password"
                    >
                        <i class="fas fa-eye"></i>
                    </button>

                </div>

            </div>


            @if ($errors->updatePassword->get('password_confirmation'))

                <div class="text-danger small mt-1">

                    <i class="fas fa-exclamation-circle mr-1"></i>

                    {{ $errors->updatePassword->first('password_confirmation') }}

                </div>

            @endif

        </div>


        {{-- =====================================================
             BUTTON
        ====================================================== --}}

        <div class="d-flex justify-content-end align-items-center mt-4">

            @if (session('status') === 'password-updated')

                <span class="text-success mr-3">

                    <i class="fas fa-check-circle mr-1"></i>

                    Password berhasil diperbarui.

                </span>

            @endif


            <button
                type="submit"
                class="btn btn-primary"
            >

                <i class="fas fa-save mr-1"></i>

                Ubah Password

            </button>

        </div>

    </form>

</section>


{{-- =============================================================
     SCRIPT SHOW / HIDE PASSWORD
     Sengaja diletakkan langsung di partial.
============================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.toggle-password').forEach(function (button) {

        button.addEventListener('click', function () {

            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (!input || !icon) {
                return;
            }

            if (input.type === 'password') {

                input.type = 'text';

                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

                this.setAttribute(
                    'title',
                    'Sembunyikan password'
                );

                this.setAttribute(
                    'aria-label',
                    'Sembunyikan password'
                );

            } else {

                input.type = 'password';

                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

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