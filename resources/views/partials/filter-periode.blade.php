<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-body py-3 px-4">
        <form method="GET" action="{{ $action }}">
            <div class="d-flex align-items-center flex-wrap gap-2 gap-sm-3">
                <label for="filterBulan" class="form-label fw-semibold mb-0 text-nowrap me-1">
                    Pilih Periode
                </label>

                <div class="d-flex align-items-center gap-2">
    <input
    type="text"
    id="filterBulan"
    name="bulan"
    class="form-control"
    style="width:190px;"
    value="{{ request('bulan', now()->format('Y-m')) }}"
    autocomplete="off"
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

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    flatpickr.localize(flatpickr.l10ns.id);

    flatpickr("#filterBulan", {
        locale: "id",

        plugins: [
            new monthSelectPlugin({
                shorthand: false,
                dateFormat: "Y-m",
                altFormat: "F Y"
            })
        ],

        dateFormat: "Y-m",
        altInput: true,
        altFormat: "F Y",

        defaultDate: document.getElementById("filterBulan").value,

        allowInput: false
    });

});
</script>
@endpush