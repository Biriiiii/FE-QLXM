@extends('layouts.client')

@section('title', 'Danh Sách Xe Máy - QLXM')
@section('description',
    'Xem danh sách đầy đủ các dòng xe máy từ các hãng uy tín như Honda, Yamaha, Suzuki với giá cả
    hợp lý')

@section('content')
    <!-- Page Heading -->
    <div class="page-heading products-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>danh mục sản phẩm</h4>
                        <h2>xe máy chất lượng</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Motorcycles Section -->
    <div class="products">
        <div class="container">
            <div class="row">
                <!-- Search Bar -->
                <div class="col-md-12 mb-4">
                    <div class="search-section">
                        <form method="GET" action="{{ route('client.motorcycles') }}" class="search-form">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" 
                                               name="search" 
                                               class="form-control" 
                                               placeholder="Tìm kiếm xe máy theo tên, hãng, loại..." 
                                               value="{{ request('search') }}"
                                               style="height: 45px; border-radius: 25px; padding-left: 20px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-search" style="height: 45px; border-radius: 25px; width: 100%;">
                                            <i class="fa fa-search"></i> Tìm kiếm
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ route('client.motorcycles') }}" class="btn btn-outline-secondary mt-2" style="width: 100%;">
                                                <i class="fa fa-times"></i> Xóa bộ lọc
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="filters">
                        <ul>
                            <li class="active" data-filter="*">Tất Cả Xe Máy</li>
                            @if (count($brands) > 0)
                                @foreach ($brands as $brand)
                                    <li data-filter=".brand-{{ $brand['id'] }}">{{ $brand['name'] }}</li>
                                @endforeach
                            @endif
                            @if (count($categories) > 0)
                                @foreach ($categories as $category)
                                    <li data-filter=".category-{{ $category['id'] }}">{{ $category['name'] }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                @if (isset($error))
                    <div class="col-md-12">
                        <div class="alert alert-warning text-center">
                            <h4>{{ $error }}</h4>
                            <p>Vui lòng thử lại sau hoặc liên hệ quản trị viên.</p>
                        </div>
                    </div>
                @endif

                {{-- Hiển thị kết quả tìm kiếm --}}
                @if(request('search'))
                    <div class="col-md-12">
                        <div class="search-results-info mb-3">
                            <div class="alert alert-info">
                                <i class="fa fa-search"></i> 
                                Kết quả tìm kiếm cho: <strong>"{{ request('search') }}"</strong>
                                @if(!empty($products))
                                    - Tìm thấy {{ count($products) }} sản phẩm
                                @else
                                    - Không tìm thấy sản phẩm nào
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="filters-content">
                        <div class="row grid">
                            @if (!empty($products) && is_array($products))
                                @foreach ($products as $product)
                                    <div
                                        class="col-lg-4 col-md-4 all 
                                        @if (isset($product['brand']['id'])) brand-{{ $product['brand']['id'] }} @endif
                                        @if (isset($product['category']['id'])) category-{{ $product['category']['id'] }} @endif">
                                        <div class="product-item">
                                            <a href="{{ route('client.motorcycles.show', $product['id'] ?? 0) }}">
                                                @if (!empty($product['image_url']))
                                                    <img src="{{ $product['image_url'] }}"
                                                        alt="{{ $product['name'] ?? 'Xe máy' }}"
                                                        style="width: 100%; height: 250px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('img/product_01.jpg') }}"
                                                        alt="{{ $product['name'] ?? 'Xe máy' }}"
                                                        style="width: 100%; height: 250px; object-fit: cover;">
                                                @endif
                                            </a>
                                            <div class="down-content">
                                                <a href="{{ route('client.motorcycles.show', $product['id'] ?? 0) }}">
                                                    <h4>{{ $product['name'] ?? 'Không rõ tên' }}</h4>
                                                </a>
                                                <h6 class="price">{{ isset($product['price']) ? number_format($product['price'], 0, ',', '.') : '0' }}
                                                    VNĐ</h6>

                                                @if (isset($product['brand']['name']))
                                                    <p><strong>Hãng:</strong> {{ $product['brand']['name'] }}</p>
                                                @endif

                                                @if (isset($product['category']['name']))
                                                    <p><strong>Loại:</strong> {{ $product['category']['name'] }}</p>
                                                @endif

                                                <ul class="stars">
                                                    <li><i class="fa fa-star"></i></li>
                                                    <li><i class="fa fa-star"></i></li>
                                                    <li><i class="fa fa-star"></i></li>
                                                    <li><i class="fa fa-star"></i></li>
                                                    <li><i class="fa fa-star"></i></li>
                                                </ul>

                                                <span
                                                    class="status {{ isset($product['status']) && $product['status'] == 'available' ? 'text-success' : 'text-danger' }}">
                                                    {{ isset($product['status']) && $product['status'] == 'available' ? 'Còn hàng' : 'Hết hàng' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12">
                                    <div class="text-center py-5">
                                        <h4>Không có sản phẩm nào</h4>
                                        <p>Hiện tại chưa có xe máy nào để hiển thị.</p>
                                        <a href="{{ route('client.home') }}" class="btn btn-primary">
                                            Về Trang Chủ
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagination -->
    @include('components.pagination')

@endsection

@push('styles')
<style>
.search-section {
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Style cho giá sản phẩm */
.down-content .price {
    color: #ff4444;
    font-weight: bold;
    font-size: 16px;
    margin-top: 10px;
    margin-bottom: 10px;
}

.btn-search {
    background: linear-gradient(45deg, #ff4444, #ff6666);
    border: none;
    font-weight: bold;
    transition: all 0.3s ease;
}

.btn-search:hover {
    background: linear-gradient(45deg, #ff3333, #ff5555);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 68, 68, 0.3);
}

.search-form .form-control:focus {
    border-color: #ff4444;
    box-shadow: 0 0 0 0.2rem rgba(255, 68, 68, 0.25);
}

.search-results-info .alert {
    border-left: 4px solid #17a2b8;
    background-color: #d1ecf1;
    border-color: #bee5eb;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto focus vào ô tìm kiếm nếu có search query
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput && searchInput.value) {
        searchInput.focus();
        searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
    }
    
    // Tìm kiếm khi nhấn Enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            this.form.submit();
        }
    });
    
    // Clear search khi click vào clear button
    const clearBtn = document.querySelector('.btn-outline-secondary');
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            searchInput.value = '';
            window.location.href = '{{ route("client.motorcycles") }}';
        });
    }
});
</script>
@endpush
