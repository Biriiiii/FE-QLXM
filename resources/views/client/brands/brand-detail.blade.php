@extends('layouts.client')

@section('title', 'Xe Máy ' . ($brand['name'] ?? 'Hãng') . ' - QLXM')
@section('description',
    'Xem danh sách xe máy từ hãng ' .
    ($brand['name'] ?? '') .
    ' với chất lượng cao và giá cả hợp
    lý')

@section('content')
    <!-- Page Heading -->
    <div class="page-heading products-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        @if (is_array($brand) && !empty($brand['name']))
                            <h4>{{ $brand['name'] }}</h4>
                            <h2>Xe máy chất lượng</h2>
                            @if (!empty($brand['country']))
                                <p>Xuất xứ: {{ $brand['country'] }}</p>
                            @endif
                            @if (!empty($brand['description']))
                                <p><strong>Mô tả:</strong> {{ $brand['description'] }}</p>
                            @else
                                <p><strong>Mô tả:</strong> Chưa có mô tả cho hãng này.</p>
                            @endif
                        @else
                            <h4>Hãng xe máy</h4>
                            <h2>Không tìm thấy thông tin</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Motorcycles by Brand Section -->
    <div class="products">
        <div class="container">
            <div class="row">
                @if (isset($error))
                    <div class="col-md-12">
                        <div class="alert alert-warning text-center">
                            <h4>{{ $error }}</h4>
                            <p>Vui lòng thử lại sau hoặc liên hệ quản trị viên.</p>
                        </div>
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>{{ $brand['name'] ?? 'Hãng xe máy' }} - Sản phẩm</h2>
                        <a href="{{ route('client.motorcycles') }}">Xem tất cả xe máy <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>

                @if (count($products) > 0)
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="product-item">
                                <a href="{{ route('client.motorcycles.show', $product['id']) }}">
                                    @if ($product['image_url'])
                                        <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}"
                                            style="width: 100%; height: 250px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('img/product_01.jpg') }}" alt="{{ $product['name'] }}"
                                            style="width: 100%; height: 250px; object-fit: cover;">
                                    @endif
                                </a>
                                <div class="down-content">
                                    <a href="{{ route('client.motorcycles.show', $product['id']) }}">
                                        <h4>{{ $product['name'] }}</h4>
                                    </a>
                                    <h6>{{ number_format($product['price'], 0, ',', '.') }} VNĐ</h6>

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
                                        class="status {{ $product['status'] == 'available' ? 'text-success' : 'text-danger' }}">
                                        {{ $product['status'] == 'available' ? 'Còn hàng' : 'Hết hàng' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-12">
                        <div class="text-center py-5">
                            <h4>Không có sản phẩm nào</h4>
                            <p>Hiện tại hãng này chưa có xe máy nào để hiển thị.</p>
                            <a href="{{ route('client.motorcycles') }}" class="btn btn-primary">
                                Xem Tất Cả Xe Máy
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @include('components.pagination')

@endsection
