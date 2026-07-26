@extends('layouts.app')

@section('content')
<div class="login-wrapper">
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card login-card shadow-lg border-0">
                    <div class="row g-0 h-100">

                        <div class="col-lg-6 login-left">
                            <div class="login-left-inner">
                                <div class="login-logo-wrap">
                                    <img src="{{ asset('images/logo fc.jpeg') }}" alt="Logo Jayadirana" class="login-logo-jaya">
                                </div>

                                <p class="login-brand-desc">
                                    Sistem pencatatan keuangan untuk laporan laba rugi yang akurat, transparan, dan terstruktur.
                                </p>

                                <div class="unit-box mx-auto">
                                    <small class="d-block text-white-50 mb-1">Unit Usaha</small>
                                    <strong class="text-white">Fotokopi Jayadirana</strong>
                                </div>

                                <div class="login-instansi text-center">
                                    BUM Desa Kalitinggar Makmur Kalitinggar
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 login-right">
                            <div class="login-form-box">
                                <h2 class="login-title">Masuk Ke Sistem</h2>

                                <p class="login-subtitle">
                                    Silakan masuk menggunakan email dan password yang telah terdaftar.
                                </p>

                                @if(session('error'))
                                    <div class="alert alert-danger rounded-3">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form action="{{ route('login.post') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control login-input"
                                            placeholder="Masukkan email"
                                            value="{{ old('email') }}"
                                            required
                                        >
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Password</label>

                                        <div class="password-wrapper">
                                            <input
                                                type="password"
                                                name="password"
                                                id="passwordInput"
                                                class="form-control login-input password-input"
                                                placeholder="Masukkan password"
                                                required
                                            >

                                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Tampilkan password">
                                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                
                                    <button type="submit" class="btn btn-login-custom w-100">
                                        Login
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
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';

        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

        eyeIcon.innerHTML = isPassword
            ? `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.73 5.08A10.94 10.94 0 0112 5.25c6 0 9.75 6.75 9.75 6.75a18.66 18.66 0 01-3.04 3.75M6.53 6.53C3.76 8.36 2.25 12 2.25 12s3.75 6.75 9.75 6.75a10.7 10.7 0 004.3-.9" />
            `
            : `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            `;
    });
</script>
@endpush

