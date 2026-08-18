<section>

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="mb-4">

        <h4 class="mb-1">
            <i class="fas fa-user-circle mr-1"></i>
            Informasi Profil
        </h4>

        <p class="text-muted mb-0">
            Perbarui informasi akun dan identitas Anda.
        </p>

    </div>


    {{-- =========================================================
         FORM VERIFIKASI EMAIL
    ========================================================== --}}

    <form
        id="send-verification"
        method="post"
        action="{{ route('verification.send') }}"
    >
        @csrf
    </form>


    {{-- =========================================================
         FORM UTAMA
    ========================================================== --}}

    <form
        method="post"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
    >

        @csrf
        @method('patch')


        {{-- =====================================================
             DATA AKUN
        ====================================================== --}}

        <h5 class="mb-3">
            <i class="fas fa-user mr-1"></i>
            Data Akun
        </h5>


        {{-- Nama Akun --}}

        <div class="form-group">

            <label for="name">

                Nama Akun

                <span class="text-danger">*</span>

            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}"
                placeholder="Masukkan nama akun"
                required
                autofocus
                autocomplete="name"
            >

            @error('name')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Email --}}

        <div class="form-group">

            <label for="email">

                Email

                <span class="text-danger">*</span>

            </label>

            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}"
                placeholder="Masukkan email"
                required
                autocomplete="username"
            >

            @error('email')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror


            {{-- Status Verifikasi Email --}}

            @if (
                $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
                && ! $user->hasVerifiedEmail()
            )

                <div class="alert alert-warning mt-3">

                    <i class="fas fa-exclamation-triangle mr-1"></i>

                    <strong>Email belum diverifikasi.</strong>

                    <p class="mb-2 mt-1">
                        Silakan verifikasi alamat email Anda untuk
                        memastikan akun tetap aman.
                    </p>

                    <button
                        form="send-verification"
                        type="submit"
                        class="btn btn-sm btn-warning"
                    >

                        <i class="fas fa-envelope mr-1"></i>

                        Kirim Ulang Email Verifikasi

                    </button>

                </div>

                @if (session('status') === 'verification-link-sent')

                    <div class="alert alert-success">

                        <i class="fas fa-check-circle mr-1"></i>

                        Email verifikasi baru berhasil dikirim.

                    </div>

                @endif

            @endif

        </div>


        <hr>


        {{-- =====================================================
             DATA IDENTITAS
        ====================================================== --}}

        <h5 class="mb-3">

            <i class="fas fa-id-card mr-1"></i>

            Data Identitas

        </h5>


        {{-- Nama Lengkap --}}

        <div class="form-group">

            <label for="nama_lengkap">

                Nama Lengkap

                <span class="text-danger">*</span>

            </label>

            <input
                type="text"
                id="nama_lengkap"
                name="nama_lengkap"
                class="form-control @error('nama_lengkap') is-invalid @enderror"
                value="{{ old('nama_lengkap', $profile->nama_lengkap ?? $user->name) }}"
                placeholder="Masukkan nama lengkap"
                required
            >

            @error('nama_lengkap')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- NIP --}}

        <div class="form-group">

            <label for="nip">
                NIP
            </label>

            <input
                type="text"
                id="nip"
                name="nip"
                class="form-control @error('nip') is-invalid @enderror"
                value="{{ old('nip', $profile->nip) }}"
                placeholder="Masukkan NIP jika ada"
            >

            @error('nip')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Nomor HP --}}

        <div class="form-group">

            <label for="no_hp">
                Nomor HP
            </label>

            <input
                type="text"
                id="no_hp"
                name="no_hp"
                class="form-control @error('no_hp') is-invalid @enderror"
                value="{{ old('no_hp', $profile->no_hp) }}"
                placeholder="Contoh: 081234567890"
                autocomplete="tel"
            >

            @error('no_hp')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Jabatan --}}

        <div class="form-group">

            <label for="jabatan">
                Jabatan
            </label>

            <input
                type="text"
                id="jabatan"
                name="jabatan"
                class="form-control @error('jabatan') is-invalid @enderror"
                value="{{ old('jabatan', $profile->jabatan) }}"
                placeholder="Masukkan jabatan"
            >

            @error('jabatan')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Instansi --}}

        <div class="form-group">

            <label for="instansi">
                Instansi
            </label>

            <input
                type="text"
                id="instansi"
                name="instansi"
                class="form-control @error('instansi') is-invalid @enderror"
                value="{{ old('instansi', $profile->instansi) }}"
                placeholder="Masukkan instansi"
            >

            @error('instansi')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- Alamat --}}

        <div class="form-group">

            <label for="alamat">
                Alamat
            </label>

            <textarea
                id="alamat"
                name="alamat"
                rows="4"
                class="form-control @error('alamat') is-invalid @enderror"
                placeholder="Masukkan alamat lengkap"
            >{{ old('alamat', $profile->alamat) }}</textarea>

            @error('alamat')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- =====================================================
             FOTO PROFIL
        ====================================================== --}}

        <div class="form-group">

            <label for="foto">
                Foto Profil
            </label>

            <div class="row">

                {{-- Foto Saat Ini --}}

                @if($profile->foto)

                    <div class="col-md-3 mb-3">

                        <img
                            src="{{ asset('storage/' . $profile->foto) }}"
                            alt="Foto Profil"
                            class="img-thumbnail"
                            style="
                                width: 150px;
                                height: 150px;
                                object-fit: cover;
                            "
                        >

                    </div>

                @endif


                {{-- Upload --}}

                <div class="{{ $profile->foto ? 'col-md-9' : 'col-md-12' }}">

                    <div class="custom-file">

                        <input
                            type="file"
                            id="foto"
                            name="foto"
                            class="custom-file-input @error('foto') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <label
                            class="custom-file-label"
                            for="foto"
                        >
                            Pilih foto
                        </label>

                    </div>

                    <small class="form-text text-muted">
                        Format JPG, JPEG, PNG, atau WEBP.
                        Maksimal 2 MB.
                    </small>

                    @error('foto')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             BUTTON
        ====================================================== --}}

        <div class="mt-4">

            <button
                type="submit"
                class="btn btn-primary"
            >

                <i class="fas fa-save mr-1"></i>

                Simpan Perubahan

            </button>


            @if (session('status') === 'profile-updated')

                <span class="text-success ml-2">

                    <i class="fas fa-check-circle mr-1"></i>

                    Profil berhasil diperbarui.

                </span>

            @endif

        </div>

    </form>

</section>


@push('js')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const fotoInput = document.getElementById('foto');

    if (!fotoInput) {
        return;
    }

    fotoInput.addEventListener('change', function () {

        const label = this.nextElementSibling;

        if (!label) {
            return;
        }

        label.textContent = this.files.length
            ? this.files[0].name
            : 'Pilih foto';

    });

});

</script>

@endpush