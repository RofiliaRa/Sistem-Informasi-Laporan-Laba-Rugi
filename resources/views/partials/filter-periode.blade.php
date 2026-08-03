<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-body">
        <form method="GET" action="{{ $action }}">
            <div class="row align-items-end g-3">
                {{-- INPUT PERIODE (KIRI) --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <label class="form-label fw-semibold">Pilih Periode</label>
                    <input
                        type="month"
                        name="bulan"
                        class="form-control"
                        value="{{ request('bulan', now()->format('Y-m')) }}"
                    >
                </div>

                {{-- TOMBOL TAMPILKAN & RESET (KANAN DI DESKTOP) --}}
                <div class="col-12 col-md-auto ms-md-auto d-flex align-items-center gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2 flex-fill flex-md-grow-0">
                        <i class="bi bi-search me-1"></i> Tampilkan
                    </button>

                    @if(!empty($showReset))
                        <a href="{{ $action }}" class="btn btn-secondary px-4 py-2 flex-fill flex-md-grow-0">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
