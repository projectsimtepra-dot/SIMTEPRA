<section>

    <form
        method="post"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
    >

        @csrf
        @method('patch')


        {{-- =====================================================
             FOTO PROFIL
        ====================================================== --}}

        <div class="form-group mb-4">

            <label class="font-weight-bold">
                Foto Profil
            </label>

            <div class="d-flex align-items-center">

                {{-- Preview Foto --}}
                <div class="mr-4">

                    @if($user->profile_photo)

                        <img
                            id="profile-photo-preview"
                            src="{{ asset('storage/' . $user->profile_photo) }}"
                            alt="Foto Profil"
                            class="rounded-circle shadow-sm"
                            style="
                                width: 100px;
                                height: 100px;
                                object-fit: cover;
                                border: 3px solid #e9ecef;
                            "
                        >

                    @else

                        <div
                            id="profile-photo-placeholder"
                            class="rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="
                                width: 100px;
                                height: 100px;
                                background: #e9ecef;
                                border: 3px solid #dee2e6;
                            "
                        >

                            <i
                                class="fas fa-user fa-3x text-secondary"
                            ></i>

                        </div>

                        <img
                            id="profile-photo-preview"
                            src=""
                            alt="Preview Foto"
                            class="rounded-circle shadow-sm d-none"
                            style="
                                width: 100px;
                                height: 100px;
                                object-fit: cover;
                                border: 3px solid #e9ecef;
                            "
                        >

                    @endif

                </div>


                {{-- Upload Foto --}}
                <div>

                    <div class="custom-file">

                        <input
                            type="file"
                            id="profile_photo"
                            name="profile_photo"
                            class="custom-file-input @error('profile_photo') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <label
                            class="custom-file-label"
                            for="profile_photo"
                        >
                            Pilih foto
                        </label>

                    </div>

                    <small class="form-text text-muted">
                        JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    </small>

                    @error('profile_photo')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        </div>


        <hr class="mb-4">


        {{-- =====================================================
             NAMA & EMAIL
        ====================================================== --}}

        <div class="row">

            {{-- Nama --}}
            <div class="col-md-6">

                <div class="form-group">

                    <label
                        for="name"
                        class="font-weight-bold"
                    >

                        Nama Lengkap

                        <span class="text-danger">*</span>

                    </label>

                    <div class="input-group">

                        <div class="input-group-prepend">

                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>

                        </div>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            autocomplete="name"
                        >

                    </div>

                    @error('name')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>


            {{-- Email --}}
            <div class="col-md-6">

                <div class="form-group">

                    <label
                        for="email"
                        class="font-weight-bold"
                    >

                        Email

                        <span class="text-danger">*</span>

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
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}"
                            placeholder="Masukkan email"
                            required
                            autocomplete="username"
                        >

                    </div>

                    @error('email')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        </div>


        {{-- =====================================================
             VERIFIKASI EMAIL
        ====================================================== --}}

        @if (
            $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
            && ! $user->hasVerifiedEmail()
        )

            <div class="alert alert-warning mt-2">

                <div class="d-flex align-items-start">

                    <i class="fas fa-exclamation-triangle mr-2 mt-1"></i>

                    <div>

                        <strong>
                            Email belum diverifikasi.
                        </strong>

                        <div class="small mt-1">
                            Silakan verifikasi alamat email Anda.
                        </div>

                        <form
                            id="send-verification"
                            method="post"
                            action="{{ route('verification.send') }}"
                            class="mt-2"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-sm btn-warning"
                            >

                                <i class="fas fa-envelope mr-1"></i>

                                Kirim Ulang Email Verifikasi

                            </button>

                        </form>

                    </div>

                </div>

            </div>

            @if (session('status') === 'verification-link-sent')

                <div class="alert alert-success">

                    <i class="fas fa-check-circle mr-1"></i>

                    Email verifikasi baru berhasil dikirim.

                </div>

            @endif

        @endif


        {{-- =====================================================
             BUTTON
        ====================================================== --}}

        <div class="d-flex justify-content-end align-items-center mt-4">

            @if (session('status') === 'Profil berhasil diperbarui.')

                <span class="text-success mr-3">

                    <i class="fas fa-check-circle mr-1"></i>

                    Profil berhasil diperbarui.

                </span>

            @endif


            <button
                type="submit"
                class="btn btn-primary"
            >

                <i class="fas fa-save mr-1"></i>

                Simpan Perubahan

            </button>

        </div>

    </form>

</section>


@push('js')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const photoInput = document.getElementById('profile_photo');
    const preview = document.getElementById('profile-photo-preview');
    const placeholder = document.getElementById('profile-photo-placeholder');

    if (!photoInput) {
        return;
    }

    photoInput.addEventListener('change', function () {

        const file = this.files[0];

        const label = this.nextElementSibling;

        if (label) {

            label.textContent = file
                ? file.name
                : 'Pilih foto';

        }

        if (!file) {
            return;
        }

        if (!file.type.startsWith('image/')) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {

            if (preview) {

                preview.src = event.target.result;

                preview.classList.remove('d-none');

            }

            if (placeholder) {

                placeholder.classList.add('d-none');

            }

        };

        reader.readAsDataURL(file);

    });

});

</script>

@endpush