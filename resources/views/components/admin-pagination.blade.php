@if (isset($pagination) && $pagination && $pagination['last_page'] > 1)
    <div class="pagination-wrapper mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($pagination['current_page'] > 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1]) }}"
                                        aria-label="Previous">
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
                            @if ($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1]) }}">1</a>
                                </li>
                                @if ($start > 2)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            {{-- Page Range --}}
                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $pagination['current_page'])
                                    <li class="page-item active">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            {{-- Last Page --}}
                            @if ($end < $pagination['last_page'])
                                @if ($end < $pagination['last_page'] - 1)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(['page' => $pagination['last_page']]) }}">{{ $pagination['last_page'] }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($pagination['current_page'] < $pagination['last_page'])
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1]) }}"
                                        aria-label="Next">
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
                        <p class="text-muted mb-0">
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
        /* Admin Pagination Styling */
        .pagination-wrapper {
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .pagination .page-link {
            color: var(--btn-primary, #ed1b24);
            border-color: #dee2e6;
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.3s ease;
            background: #fff;
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: var(--btn-primary, #ed1b24);
            border-color: var(--btn-primary, #ed1b24);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(237, 27, 36, 0.3);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--btn-primary, #ed1b24);
            border-color: var(--btn-primary, #ed1b24);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(237, 27, 36, 0.3);
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
            cursor: not-allowed;
        }

        .pagination-info p {
            font-size: 0.875rem;
            margin: 0;
            color: var(--text-main, #2c3e50);
        }

        /* Admin theme specific adjustments */
        @media (prefers-color-scheme: dark) {
            .pagination .page-link {
                background: #2c3e50;
                color: #ecf0f1;
                border-color: #34495e;
            }

            .pagination .page-link:hover {
                background-color: var(--btn-primary, #ed1b24);
                border-color: var(--btn-primary, #ed1b24);
            }

            .pagination .page-item.disabled .page-link {
                background-color: #34495e;
                color: #7f8c8d;
                border-color: #34495e;
            }

            .pagination-info p {
                color: #ecf0f1;
            }
        }

        @media (max-width: 768px) {
            .pagination .page-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.875rem;
                margin: 0 0.05rem;
            }

            .pagination-info p {
                font-size: 0.8rem;
            }
        }
    </style>

@endif
