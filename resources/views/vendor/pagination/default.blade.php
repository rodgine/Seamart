<style>
    .pagination {
        margin-top: 20px;
    }

    .pagination .page-item {
        margin: 0 5px;
    }

    .pagination .page-item.active .page-link {
        background-color: #28a745;
        border-color: #28a745;
    }

    .pagination .page-link {
        border-radius: 50%;
        color: #007bff;
        padding: 10px 15px;
    }

    .pagination .page-link:hover {
        background-color: #0056b3;
        color: #fff;
    }
</style>
@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true"><span class="page-link">&laquo; Previous</span></li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span>
                </li>
            @elseif (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span
                                class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &raquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true"><span class="page-link">Next &raquo;</span></li>
        @endif
    </ul>
@endif
