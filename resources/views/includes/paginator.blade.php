{{--
@if ($paginator->lastPage() > 1)
    <ul class="pagination pagination-sm m-0 float-left">
        <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url(1) }}">«</a>
        </li>

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            @if($i > $paginator->currentPage())
                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{$i}}</a>
                </li>
            @endif
        @endfor

        <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url($paginator->currentPage()+1) }}">»</a>
        </li>
    </ul>

@endif











--}}

@if ($paginator->hasPages())
    <ul class="pagination pagination-sm m-0 float-left">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">«</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">«</a></li>
        @endif

        @if($paginator->currentPage() > 3)
            <li class="page-item hidden-xs"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="page-item"><a href="javascript:void(0)" class="page-link">...</a></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="active page-item"><span class="page-link">{{ $i }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item"><a href="javascript:void(0)" class="page-link">...</a></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item hidden-xs"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">»</a></li>
        @else
            <li class="disabled page-item"><span class="page-link">»</span></li>
        @endif
    </ul>
@endif
