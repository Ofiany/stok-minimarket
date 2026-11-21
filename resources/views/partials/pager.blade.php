@if ($paginator->hasPages())
<div class="pager">
    @if ($paginator->onFirstPage())<span>&laquo;</span>@else<a href="{{ $paginator->previousPageUrl() }}">&laquo;</a>@endif
    @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
        @if ($page == $paginator->currentPage())<span class="on">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif
    @endforeach
    @if ($paginator->hasMorePages())<a href="{{ $paginator->nextPageUrl() }}">&raquo;</a>@else<span>&raquo;</span>@endif
</div>
@endif
