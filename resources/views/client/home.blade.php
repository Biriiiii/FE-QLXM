@extends('client.layout')

@section('title', 'Trang chủ')

@section('content')
    <div class="container mt-5">
        {{-- ====================== PHẦN TIÊU ĐỀ & THANH TÌM KIẾM ====================== --}}
        <div class="section-heading d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Xe Máy Mới Nhất</h2>

            <form action="{{ route('client.motorcycles.search') }}" method="GET" class="d-flex" style="gap: 5px;">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm xe..."
                    value="{{ request('keyword') }}" style="width: 250px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>

        {{-- ====================== KẾT QUẢ TÌM KIẾM ====================== --}}
        @if (!empty(request('keyword')))
            <h5 class="text-center mb-4 text-secondary">
                Kết quả tìm kiếm cho: <strong>"{{ request('keyword') }}"</strong>
            </h5>
        @endif

        {{-- ====================== DANH SÁCH XE MÁY ====================== --}}
        <div class="row">
            @forelse ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        {{-- Ảnh sản phẩm --}}
                        <a href="{{ route('client.motorcycles.show', $product['id']) }}">
                            <img src="{{ $product['image'] ?? asset('images/no-image.png') }}" class="card-img-top"
                                alt="{{ $product['name'] }}" style="height: 200px; object-fit: cover;">
                        </a>

                        <div class="card-body d-flex flex-column justify-content-between">
                            {{-- Tên sản phẩm --}}
                            <h4 class="card-title product-title mb-2">
                                <a href="{{ route('client.motorcycles.show', $product['id']) }}"
                                    class="text-dark text-decoration-none">
                                    {{ $product['name'] }}
                                </a>
                            </h4>

                            {{-- Giá sản phẩm --}}
                            <p class="card-text text-danger fw-bold mb-2">
                                {{ number_format($product['price'], 0, ',', '.') }} ₫
                            </p>

                            {{-- Nút thêm vào giỏ hàng --}}
                            <form action="{{ route('client.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    <i class="fa fa-cart-plus me-1"></i> Thêm vào giỏ hàng
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

{{-- ====================== CSS PHỤ TRỢ ====================== --}}
@push('styles')
    <style>
        /* Giới hạn tiêu đề sản phẩm 2 dòng và thêm "..." nếu dài */
        .product-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            height: 48px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-title a:hover {
            color: #007bff;
        }
    </style>
@endpush
