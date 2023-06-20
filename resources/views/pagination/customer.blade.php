@if ($paginator->hasPages())
    <ul class="pagination pagination-sm pagination-bordered mb-0">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <a class="page-link" rel="nofollow" href="{{ $paginator->previousPageUrl() }}" tabindex="-1" aria-disabled="true">Trang sau</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" href="" rel="nofollow">{{ $page }}</a></li>
                    @elseif (($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2) || $page == $paginator->lastPage())
                        <li class="page-item"><a class="page-link" rel="nofollow" href="{{ $url }}">{{ $page }}</a></li>
                    @elseif ($page == $paginator->lastPage() - 1)
                        <li class="page-item disabled"><a class="page-link" href="" rel="nofollow">..</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" rel="nofollow" href="{{ $paginator->nextPageUrl() }}">Trang tiếp</a>
            </li>
        @endif
    </ul>
@endif
