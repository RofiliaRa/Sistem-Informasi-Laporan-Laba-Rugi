@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none d-sm-flex justify-content-center">
           <div>
</div>

           <div class="d-none d-sm-flex justify-content-center">

    <ul class="pagination mb-0">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">&lsaquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                    &lsaquo;
                </a>
            </li>
        @endif

        {{-- Nomor halaman --}}
        @foreach ($elements as $element)

            @if (is_string($element))

                <li class="page-item disabled">
                    <span class="page-link">{{ $element }}</span>
                </li>

            @endif

            @if (is_array($element))

                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>

                    @else

                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">
                                {{ $page }}
                            </a>
                        </li>

                    @endif

                @endforeach

            @endif

        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())

            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                    &rsaquo;
                </a>
            </li>

        @else

            <li class="page-item disabled">
                <span class="page-link">&rsaquo;</span>
            </li>

        @endif

    </ul>

</div>
    </nav>
@endif
