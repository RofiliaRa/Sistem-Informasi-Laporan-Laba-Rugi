<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-body py-3 px-4">
        <form method="GET" action="{{ $action }}">
            <div class="d-flex align-items-center flex-wrap gap-2 gap-sm-3">
                <label for="filterBulan" class="form-label fw-semibold mb-0 text-nowrap me-1">
                    Pilih Periode
                </label>

                <div class="d-flex align-items-center gap-2">
    <input
        type="month"
        name="bulan"
        id="filterBulan"
        class="form-control"
        style="width: 190px;"
        value="{{ request('bulan', now()->format('Y-m')) }}"
        onkeydown="if(event.key === 'Enter'){ event.preventDefault(); this.form.submit(); }"
        onchange="this.form.submit()"
    >
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1 px-3">
        <i class="bi bi-search"></i>
        <span>Tampilkan</span>
    </button>

    @if(!empty($showReset))
        <a href="{{ $action }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1 px-3">
            <i class="bi bi-arrow-clockwise"></i>
            <span>Reset</span>
                   </a>
    @endif
</div>
            </div>  
        </form>
    </div>
</div>
