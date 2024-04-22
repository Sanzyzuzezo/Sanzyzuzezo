<span>
    Showing
    @if ($paginator->firstItem())
        {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}
    @else
        {{ $paginator->count() }}
    @endif
    of {{ $paginator->total() }} item(s)
</span>
@if ($paginator->hasPages())
    <ul class="ec-pro-pagination-inner">
        @if ($paginator->onFirstPage())
            <li><a class="next" href="#"><i class="ecicon eci-angle-left"></i> Prev    </a></li>
        @else
            <li class="pagination"><a class="next" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i
                        class="ecicon eci-angle-left"></i> Prev    </a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="pagination"><a href="#" class="active">{{ $page }}</a></li>
                    @else
                        <li class="pagination"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="pagination"><a class="next" href="{{ $paginator->nextPageUrl() }}">Next <i
                        class="ecicon eci-angle-right"></i></a></li>
        @else
            <li class="disabled"><a class="next" href="#">Next <i
                class="ecicon eci-angle-right"></i></a></li>
        @endif
    </ul>
@endif
