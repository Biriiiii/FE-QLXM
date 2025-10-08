@extends('layouts.client')

@section('title', 'Danh Sách Xe Máy - QLXM')
@section('description', 'Xem danh sách đầy đủ các dòng xe máy từ các hãng uy tín như Honda, Yamaha, Suzuki với giá cả
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

                <div class="col-md-12">
                    <div class="filters-content">
                        <div class="row grid">
                            @if (count($products) > 0)
                                @foreach ($products as $product)
                                    <div
                                        class="col-lg-4 col-md-4 all 
                                        @if (isset($product['brand']['id'])) brand-{{ $product['brand']['id'] }} @endif
                                        @if (isset($product['category']['id'])) category-{{ $product['category']['id'] }} @endif">
                                        <div class="product-item">
                                            <a href="{{ route('client.motorcycles.show', $product['id']) }}">
                                                @if ($product['image_url'])
                                                    <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}"
                                                        style="width: 100%; height: 250px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('img/product_01.jpg') }}"
                                                        alt="{{ $product['name'] }}"
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
