<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="paginate row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="{{-- dataTables_paginate --}} paging_simple_numbers" id="datatable_paginate">
                <ul class="pagination">
                    <li class="{{ ($paginator->currentPage() == 1) ? 'disabled' : '' }}">
                        <a href="{{ $paginator->url(1) }}">First</a>
                    </li>
                    <!-- Previous Page Link -->
                    @if ($paginator->onFirstPage())
                    <li class="disabled"><span>&laquo;</span></li>
                    @else
                    <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif

                    <!-- Pagination Elements -->
                    @foreach ($elements as $element)
                    <!-- "Three Dots" Separator -->
                    @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                    @endif
                    @if (is_array($element))
                    @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                    @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    @endforeach
                    @endif
                    @endforeach                @if ($paginator->hasMorePages())
                    <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
                    @else
                    <li class="disabled"><span>&raquo;</span></li>
                    @endif
                    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                        <a href="{{ $paginator->url($paginator->lastPage()) }}">Last</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>