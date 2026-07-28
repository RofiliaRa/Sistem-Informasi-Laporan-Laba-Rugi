<div class="dash-panel-card-pro stat-card">
    <div class="dash-panel-body text-center p-3">
        <div class="stat-icon {{ $iconBg ?? 'stat-primary' }} mb-2">
            <i class="{{ $icon }}"></i>
        </div>
        <div class="stat-title">{{ $title }}</div>
        <div class="stat-value {{ $valueClass ?? '' }}">{{ $value }}</div>
    </div>
</div>
