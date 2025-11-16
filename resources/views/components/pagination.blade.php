@if(isset($pagination) && $pagination && $pagination['last_page'] > 1)
<div class="pagination-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{-- Pagination Info - Hiển thị trước --}}
                <div class="pagination-info text-center mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="pagination-summary">
                            <span class="badge badge-info px-3 py-2">
                                <i class="fa fa-info-circle"></i>
                                Trang {{ $pagination['current_page'] }} / {{ $pagination['last_page'] }}
                            </span>
                        </div>
                        <div class="pagination-count">
                            <p class="mb-0 text-muted">
                                <strong>{{ number_format($pagination['from'] ?? 0) }}</strong> - 
                                <strong>{{ number_format($pagination['to'] ?? 0) }}</strong> 
                                trong tổng số <strong>{{ number_format($pagination['total'] ?? 0) }}</strong> sản phẩm
                            </p>
                        </div>
                        @if($pagination['total'] > 0)
                            <div class="items-per-page">
                                <select class="form-select form-select-sm" id="itemsPerPage" onchange="changeItemsPerPage(this.value)">
                                    <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5 sản phẩm</option>
                                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10 sản phẩm</option>
                                    <option value="15" {{ request('limit') == 15 ? 'selected' : '' }}>15 sản phẩm</option>
                                    <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20 sản phẩm</option>
                                </select>
                            </div>
                        @endif
                    </div>
                </div>

                <nav aria-label="Điều hướng trang sản phẩm">
                    <ul class="pagination justify-content-center">
                        {{-- First Page --}}
                        @if($pagination['current_page'] > 3)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1, 'limit' => request('limit', 5)]) }}" 
                                   title="Trang đầu tiên">
                                    <i class="fa fa-angle-double-left"></i> Đầu
                                </a>
                            </li>
                        @endif

                        {{-- Previous Page Link --}}
                        @if($pagination['current_page'] > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1, 'limit' => request('limit', 5)]) }}" 
                                   aria-label="Trang trước" title="Trang {{ $pagination['current_page'] - 1 }}">
                                    <i class="fa fa-angle-left"></i> Trước
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers with Smart Logic --}}
                        @php
                            $current = $pagination['current_page'];
                            $last = $pagination['last_page'];
                            
                            // Logic thông minh cho hiển thị trang
                            if ($last <= 7) {
                                // Nếu tổng ≤ 7 trang, hiển thị tất cả
                                $start = 1;
                                $end = $last;
                            } elseif ($current <= 4) {
                                // Nếu ở đầu, hiển thị 1-5 ... last
                                $start = 1;
                                $end = 5;
                            } elseif ($current >= $last - 3) {
                                // Nếu ở cuối, hiển thị 1 ... (last-4)-last
                                $start = $last - 4;
                                $end = $last;
                            } else {
                                // Ở giữa, hiển thị 1 ... (current-2)-(current+2) ... last
                                $start = $current - 2;
                                $end = $current + 2;
                            }
                        @endphp

                        {{-- First page with dots --}}
                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => 1, 'limit' => request('limit', 5)]) }}">1</a>
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
                                    <span class="page-link current-page">
                                        {{ $i }}
                                        <small class="d-block" style="font-size: 0.7em;">hiện tại</small>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i, 'limit' => request('limit', 5)]) }}" 
                                       title="Trang {{ $i }}">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor

                        {{-- Last page with dots --}}
                        @if($end < $last)
                            @if($end < $last - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $last, 'limit' => request('limit', 5)]) }}">{{ $last }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if($pagination['current_page'] < $pagination['last_page'])
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1, 'limit' => request('limit', 5)]) }}" 
                                   aria-label="Trang sau" title="Trang {{ $pagination['current_page'] + 1 }}">
                                    Sau <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Last Page --}}
                        @if($pagination['current_page'] < $pagination['last_page'] - 2)
                            <li class="page-item">
                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['last_page'], 'limit' => request('limit', 5)]) }}" 
                                   title="Trang cuối cùng">
                                    Cuối <i class="fa fa-angle-double-right"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>

                {{-- Quick Jump to Page --}}
                @if($pagination['last_page'] > 10)
                    <div class="quick-jump text-center mt-3">
                        <form method="GET" action="{{ request()->url() }}" class="d-inline-flex align-items-center">
                            @foreach(request()->query() as $key => $value)
                                @if($key !== 'page')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <label class="me-2 mb-0">Đi đến trang:</label>
                            <input type="number" name="page" class="form-control form-control-sm mx-2" 
                                   style="width: 70px;" min="1" max="{{ $pagination['last_page'] }}" 
                                   placeholder="{{ $pagination['current_page'] }}">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.pagination-wrapper {
    margin-top: 3rem;
    margin-bottom: 2rem;
}

.pagination-info {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 20px;
    border-radius: 15px;
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.pagination-info .badge-info {
    background: linear-gradient(135deg, #ed1b24 0%, #c41e3a 100%);
    font-size: 0.9rem;
    border-radius: 10px;
}

.pagination-count strong {
    color: #ed1b24;
    font-weight: 600;
}

.items-per-page select {
    border-radius: 10px;
    border: 2px solid #ed1b24;
    color: #ed1b24;
    font-weight: 500;
    cursor: pointer;
}

.items-per-page select:focus {
    box-shadow: 0 0 0 0.2rem rgba(237, 27, 36, 0.25);
    border-color: #ed1b24;
}

.pagination {
    gap: 5px;
}

.pagination .page-link {
    color: #ed1b24;
    border: 2px solid #dee2e6;
    padding: 12px 16px;
    border-radius: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    min-width: 50px;
    text-align: center;
}

.pagination .page-link:hover {
    color: #fff;
    background: linear-gradient(135deg, #ed1b24 0%, #c41e3a 100%);
    border-color: #ed1b24;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(237, 27, 36, 0.4);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #ed1b24 0%, #c41e3a 100%);
    border-color: #ed1b24;
    color: #fff;
    font-weight: 600;
    box-shadow: 0 6px 20px rgba(237, 27, 36, 0.4);
    transform: translateY(-1px);
}

.pagination .page-item.active .current-page {
    text-align: center;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #f8f9fa;
    border-color: #dee2e6;
    cursor: not-allowed;
    opacity: 0.6;
}

.quick-jump {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #dee2e6;
}

.quick-jump input {
    border-radius: 8px;
    border: 2px solid #ed1b24;
    text-align: center;
}

.quick-jump input:focus {
    box-shadow: 0 0 0 0.2rem rgba(237, 27, 36, 0.25);
    border-color: #ed1b24;
}

.quick-jump .btn {
    border-radius: 8px;
    border: 2px solid #ed1b24;
    color: #ed1b24;
}

.quick-jump .btn:hover {
    background-color: #ed1b24;
    color: white;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .pagination-info {
        padding: 15px 10px;
    }
    
    .pagination-info .d-flex {
        flex-direction: column;
        gap: 15px;
    }
    
    .pagination .page-link {
        padding: 8px 12px;
        font-size: 0.875rem;
        min-width: 40px;
    }
    
    .pagination .page-link i {
        font-size: 0.8rem;
    }
    
    .quick-jump {
        padding: 10px;
    }
    
    .quick-jump .d-inline-flex {
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }
}

@media (max-width: 576px) {
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
        gap: 3px;
    }
    
    .pagination .page-link {
        padding: 6px 10px;
        font-size: 0.8rem;
        min-width: 35px;
    }
    
    /* Ẩn text chỉ hiển thị icon trên mobile */
    .pagination .page-link span:not(.current-page) {
        display: none;
    }
    
    .pagination-count p {
        font-size: 0.8rem;
    }
}

/* Animation cho page loading */
.pagination .page-link {
    position: relative;
    overflow: hidden;
}

.pagination .page-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.pagination .page-link:hover::before {
    left: 100%;
}
</style>

<script>
function changeItemsPerPage(limit) {
    const url = new URL(window.location);
    url.searchParams.set('limit', limit);
    url.searchParams.set('page', 1); // Reset về trang 1 khi thay đổi số items
    window.location.href = url.toString();
}

// Smooth scroll to top khi chuyển trang
document.addEventListener('DOMContentLoaded', function() {
    const pageLinks = document.querySelectorAll('.pagination .page-link');
    
    pageLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Chỉ scroll nếu không phải current page
            if (!this.closest('.page-item').classList.contains('active') && 
                !this.closest('.page-item').classList.contains('disabled')) {
                
                // Thêm loading effect
                this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                
                // Scroll to top sau 100ms
                setTimeout(() => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }, 100);
            }
        });
    });
    
    // Validation cho quick jump
    const quickJumpForm = document.querySelector('.quick-jump form');
    if (quickJumpForm) {
        quickJumpForm.addEventListener('submit', function(e) {
            const input = this.querySelector('input[name="page"]');
            const page = parseInt(input.value);
            const maxPage = parseInt(input.getAttribute('max'));
            
            if (!page || page < 1 || page > maxPage) {
                e.preventDefault();
                alert(`Vui lòng nhập số trang từ 1 đến ${maxPage}`);
                input.focus();
                return false;
            }
        });
    }
});
</script>
@endif