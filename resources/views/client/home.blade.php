@extends('layouts.client')

@section('title', 'Trang Chủ - QLXM')
@section('description', 'Hệ thống quản lý xe máy hiện đại, cung cấp thông tin về các dòng xe máy mới nhất')

@section('content')
    <!-- Banner Starts Here -->
    <div class="banner header-text">
        <div class="owl-banner owl-carousel">
            <div class="banner-item-01">
                <div class="text-content">
                    <h4>Khuyến Mãi Đặc Biệt</h4>
                    <h2>Xe Máy Mới Nhất</h2>
                </div>
            </div>
            <div class="banner-item-02">
                <div class="text-content">
                    <h4>Ưu Đãi Flash</h4>
                    <h2>Xe Máy Chất Lượng Cao</h2>
                </div>
            </div>
            <div class="banner-item-03">
                <div class="text-content">
                    <h4>Phút Cuối</h4>
                    <h2>Giảm Giá Sốc</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Ends Here -->

    <!-- Latest Motorcycles -->
    <div class="latest-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Xe Máy Mới Nhất</h2>
                        <a href="{{ route('client.motorcycles') }}">xem tất cả xe máy <i class="fa fa-angle-right"></i></a>
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

                @if (count($products) > 0)
                    @foreach ($products as $product)
                        <div class="col-md-4">
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
                            <p>Hiện tại chưa có xe máy nào để hiển thị.</p>
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

    <!-- Brands Section -->
    @if (count($brands) > 0)
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Các Hãng Xe Máy</h2>
                    </div>
                </div>
                @foreach ($brands as $brand)
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <h5>{{ $brand['name'] }}</h5>
                            @if (isset($brand['country']))
                                <p class="text-muted">{{ $brand['country'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- About Motorcycle Shop -->
    <div class="best-features">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Về Cửa Hàng Xe Máy QLXM</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="left-content">
                        <h4>Tìm kiếm xe máy chất lượng cao?</h4>
                        <p>QLXM là hệ thống quản lý xe máy hiện đại, cung cấp đầy đủ thông tin về các dòng xe máy từ các
                            hãng uy tín như Honda, Yamaha, Suzuki. Chúng tôi cam kết mang đến cho khách hàng những sản phẩm
                            chất lượng cao với giá cả hợp lý nhất.</p>
                        <ul class="featured-list">
                            <li><a href="#">Xe máy chính hãng 100%</a></li>
                            <li><a href="#">Bảo hành toàn quốc</a></li>
                            <li><a href="#">Hỗ trợ trả góp 0% lãi suất</a></li>
                            <li><a href="#">Dịch vụ sau bán hàng tận tâm</a></li>
                            <li><a href="#">Giao xe tận nhà miễn phí</a></li>
                        </ul>
                        <a href="{{ route('client.about') }}" class="filled-button">Tìm Hiểu Thêm</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-image">
                        <img src="{{ asset('img/feature-image.jpg') }}" alt="Cửa hàng xe máy">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Xe Máy Chất Lượng Cao &amp; <em>Giá Cả Hợp Lý</em></h4>
                                <p>Hệ thống QLXM cung cấp đa dạng các dòng xe máy từ phổ thông đến cao cấp, phù hợp với mọi
                                    nhu cầu.</p>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('client.motorcycles') }}" class="filled-button">Xem Xe Máy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
