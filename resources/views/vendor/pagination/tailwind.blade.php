@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="page-link disabled rounded-l-md">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link rounded-l-md">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link rounded-r-md">
                    {!! __('pagination.next') !!} →
                </a>
            @else
                <span class="page-link disabled rounded-r-md">
                    {!! __('pagination.next') !!} →
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div class="flex items-center space-x-1">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="page-link disabled rounded-l-md">
                        ←
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link rounded-l-md" rel="prev" aria-label="{{ __('pagination.previous') }}">
                        ←
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="page-link active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-link" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link rounded-r-md" rel="next" aria-label="{{ __('pagination.next') }}">
                        →
                    </a>
                @else
                    <span class="page-link disabled rounded-r-md">
                        →
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
