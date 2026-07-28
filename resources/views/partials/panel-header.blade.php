<div class="dash-panel-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
    <h3 class="mb-0">
        @if(!empty($icon))
            <i class="{{ $icon }} me-2"></i>
        @endif
        {{ $title }}
    </h3>

    @if(isset($total))
        <span class="total-data-chip">
            Total {{ $total }} {{ $totalLabel ?? 'Data' }}
        </span>
    @endif
</div>
