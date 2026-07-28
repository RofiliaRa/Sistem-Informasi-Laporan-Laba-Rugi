<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-body">
        <form method="GET" action="{{ $action }}">
            <div class="row align-items-end g-3">
                <div class="col-12 col-md-5 col-lg-4">
                    <label class="form-label fw-semibold">Pilih Periode</label>
                    <input
                        type="month"
                        name="bulan"
                        class="form-control"
                        value="{{ request('bulan', now()->format('Y-m')) }}"
                    >
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Tampilkan
                    </button>
                </div>

                @if(!empty($showReset))
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="{{ $action }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </a>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
