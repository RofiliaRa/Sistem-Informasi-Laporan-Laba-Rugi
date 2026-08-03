<div class="dash-panel-card-pro mb-4">
    <div class="dash-panel-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
        <div>
            <h3 class="mb-1 fw-bold">
                {{ $title }}
            </h3>
            @if(!empty($subtitle))
                <small class="text-muted">
                    {{ $subtitle }}
                </small>
            @endif
        </div>

        @if(!empty($actionButton))
            <div>
                {!! $actionButton !!}
            </div>
        @endif
    </div>
</div>
