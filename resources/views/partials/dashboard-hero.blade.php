<div class="card border-0 shadow-sm mb-4 dashboard-hero py-2">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <span class="dashboard-date">
                    <i class="bi bi-calendar3 me-2"></i> {{ $todayText }}
                </span>
                <h1 class="dashboard-title mt-3 mb-1 fw-bold">Selamat Datang</h1>
                <p class="dashboard-subtitle mb-0 text-muted">
                    Sistem Informasi Laporan Laba Rugi Unit Usaha Fotokopi Jayadirana
                </p>
            </div>
            <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">
                <span class="dashboard-role">
                    <i class="bi bi-person-badge-fill me-2"></i> {{ $roleTitle ?? (auth()->user()->role == 'admin' ? 'Ketua Unit' : 'Direktur') }}
                </span>
            </div>
        </div>
    </div>
</div>
