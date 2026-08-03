@if($isMobile ?? false)
    <div class="login-brand-mobile text-center mb-4 d-lg-none">
        <img src="{{ asset('images/logo fc.jpeg') }}" alt="Logo Jayadirana" class="login-logo-mobile mb-2">
        <h4 class="fw-bold mb-1 text-dark">Fotokopi Jayadirana</h4>
        <small class="text-muted d-block fw-medium">BUM Desa Kalitinggar Makmur Kalitinggar</small>
    </div>
@else
    <div class="login-left-inner">
        <div class="login-logo-wrap">
            <img src="{{ asset('images/logo fc.jpeg') }}" alt="Logo Jayadirana" class="login-logo-jaya">
        </div>

        <p class="login-brand-desc">
            Sistem pencatatan keuangan untuk laporan laba rugi yang akurat, transparan, dan terstruktur.
        </p>

        <div class="unit-box mx-auto">
            <small class="d-block text-white-50 mb-1">Unit Usaha</small>
            <strong class="text-white fs-5">Fotokopi Jayadirana</strong>
        </div>

        <div class="login-instansi text-center">
            BUM Desa Kalitinggar Makmur Kalitinggar
        </div>
    </div>
@endif
