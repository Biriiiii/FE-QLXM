@if(isset($pagination) && $pagination && $pagination['last_page'] > 1)
<div class="pagination-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        @if($pagination['current_page'] > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1]) }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">&laquo;</span>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                            $start = max(1, $pagination['current_page'] - 2);
                            $end = min($pagination['last_page'], $pagination['current_page'] + 2);
                        @endphp

                        {{-- First Page --}}
                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        {{-- Page Range --}}
                        @for($i = $start; $i <= $end; $i++)
                            @if($i == $pagination['current_page'])
                                <li class="page-item active">
                                    <span class="page-link">{{ $i }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor

                        {{-- Last Page --}}
                        @if($end < $pagination['last_page'])
                            @if($end < $pagination['last_page'] - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['last_page']]) }}">{{ $pagination['last_page'] }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if($pagination['current_page'] < $pagination['last_page'])
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1]) }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>

                {{-- Pagination Info --}}
                <div class="pagination-info text-center mt-3">
                    <p class="text-muted">
                        Hiển thị {{ $pagination['from'] ?? 0 }} đến {{ $pagination['to'] ?? 0 }} 
                        trong tổng số {{ $pagination['total'] ?? 0 }} sản phẩm
                        (Trang {{ $pagination['current_page'] }} / {{ $pagination['last_page'] }})
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pagination-wrapper {
    margin-top: 3rem;
    margin-bottom: 2rem;
}

.pagination .page-link {
    color: #ed1b24;
    border-color: #dee2e6;
    padding: 0.75rem 1rem;
    margin: 0 0.25rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    color: #fff;
    background-color: #ed1b24;
    border-color: #ed1b24;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(237, 27, 36, 0.3);
}

.pagination .page-item.active .page-link {
    background-color: #ed1b24;
    border-color: #ed1b24;
    color: #fff;
    font-weight: 600;
    box-shadow: 0 4px 8px rgba(237, 27, 36, 0.3);
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    cursor: not-allowed;
}

.pagination-info p {
    font-size: 0.9rem;
    margin: 0;
}

@media (max-width: 768px) {
    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .pagination-info p {
        font-size: 0.8rem;
    }
}
</style>
@endif