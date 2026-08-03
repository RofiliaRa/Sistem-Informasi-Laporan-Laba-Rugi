@extends('layouts.app')

@section('content')
<div class="login-wrapper">
    <div class="container login-container px-3 px-sm-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-10 col-xl-9">
                <div class="card login-card shadow-lg border-0">
                    <div class="row g-0 align-items-stretch">

                        {{-- DESKTOP BRANDING SIDE (HIDDEN ON MOBILE) --}}
                        <div class="col-lg-6 login-left d-none d-lg-flex">
                            @include('partials.auth-brand')
                        </div>

                        {{-- LOGIN FORM SIDE --}}
                        <div class="col-lg-6 login-right">
                            <div class="login-form-box">

                                {{-- MOBILE BRANDING HEADER (SHOWN ONLY ON MOBILE/TABLET) --}}
                                @include('partials.auth-brand', ['isMobile' => true])

                                <h2 class="login-title">Masuk Ke Sistem</h2>

                                <p class="login-subtitle">
                                    Silakan masuk menggunakan email dan password yang telah terdaftar.
                                </p>

                                {{-- REUSABLE ALERTS PARTIAL --}}
                                @include('partials.alerts')

                                <form action="{{ route('login.post') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label fw-semibold">Email</label>
                                        <div class="input-group">
                                            <input
                                                type="email"
                                                name="email"
                                                id="emailInput"
                                                class="form-control login-input"
                                                placeholder="Masukkan email"
                                                value="{{ old('email') }}"
                                                required
                                                autocomplete="email"
                                                autofocus
                                            >
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="passwordInput" class="form-label fw-semibold">Password</label>

                                        <div class="password-wrapper">
                                            <input
                                                type="password"
                                                name="password"
                                                id="passwordInput"
                                                class="form-control login-input password-input"
                                                placeholder="Masukkan password"
                                                required
                                                autocomplete="current-password"
                                            >

                                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Tampilkan password">
                                                <i class="bi bi-eye fs-5" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-login-custom w-100">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                    </button>
                                </form>

                                <div class="text-center mt-4 login-footer">
                                    © {{ date('Y') }} Jayadirana - BUM Desa Kalitinggar Makmur Kalitinggar
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');

        if (togglePassword && passwordInput && eyeIcon) {
            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                togglePassword.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
                
                if (isPassword) {
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                } else {
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
            });
        }
    });
</script>
@endpush


