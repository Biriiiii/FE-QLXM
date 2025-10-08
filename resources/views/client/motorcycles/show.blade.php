@extends('layouts.client')

@section('title', isset($product) ? $product['name'] . ' - Chi tiết xe máy - QLXM' : 'Chi tiết xe máy - QLXM')
@section('description', isset($product) ? 'Chi tiết xe máy ' . $product['name'] . ' giá ' . number_format($product['price'], 0, ',', '.') . ' VNĐ' : 'Xem chi tiết thông tin xe máy')

@section('content')
    <!-- Page Heading -->
    <div class="page-heading product-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>chi tiết sản phẩm</h4>
                        <h2>Thông tin xe máy</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="single-product">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(isset($error))
                        <div class="alert alert-danger text-center">
                            <h4>{{ $error }}</h4>
                            <p>Vui lòng thử lại sau hoặc quay về <a href="{{ route('client.motorcycles') }}">danh sách xe máy</a>.</p>
                        </div>
                    @elseif($product)
                        <div class="section-heading">
                            <div class="line-dec"></div>
                            <h1>{{ $product['name'] }}</h1>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <h4>Không tìm thấy sản phẩm</h4>
                            <p>Sản phẩm bạn tìm không tồn tại. <a href="{{ route('client.motorcycles') }}">Xem tất cả xe máy</a></p>
                        </div>
                    @endif
                </div>

                @if($product)
                <!-- Product Image -->
                <div class="col-md-6">
                    <div class="product-image">
                        @if($product['image_url'])
                            <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="img-fluid">
                        @else
                            <img src="{{ asset('img/product_01.jpg') }}" alt="{{ $product['name'] }}" class="img-fluid">
                        @endif
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="col-md-6">
                    <div class="product-content">
                        <div class="product-meta">
                            @if(isset($product['brand']['name']))
                                <span class="brand-badge">{{ $product['brand']['name'] }}</span>
                            @endif
                            @if(isset($product['category']['name']))
                                <span class="category-badge">{{ $product['category']['name'] }}</span>
                            @endif
                        </div>
                        
                        <div class="price-section">
                            <h3 class="current-price">{{ number_format($product['price'], 0, ',', '.') }} VNĐ</h3>
                        </div>
                        
                        <div class="stock-info">
                            <span class="stock-label">Tình trạng:</span>
                            @if($product['status'] == 'available')
                                <span class="in-stock">Còn hàng</span>
                            @else
                                <span class="out-of-stock">Hết hàng</span>
                            @endif
                            @if(isset($product['stock']) && $product['stock'])
                                <span class="stock-quantity">(Còn {{ $product['stock'] }} sản phẩm)</span>
                            @endif
                        </div>
                        
                        @if($product['description'])
                        <div class="product-description">
                            <h4>Mô tả sản phẩm</h4>
                            <p>{{ $product['description'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($product['specifications']) && is_array($product['specifications']))
                        <div class="specifications">
                            <h4>Thông số kỹ thuật</h4>
                            <table class="table table-striped">
                                @foreach($product['specifications'] as $key => $value)
                                <tr>
                                    <td><strong>{{ ucfirst($key) }}:</strong></td>
                                    <td>{{ $value }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        @else
                        <div class="specifications">
                            <h4>Thông số kỹ thuật</h4>
                            <p class="text-muted">Thông tin kỹ thuật sẽ được cập nhật sớm.</p>
                        </div>
                        @endif
                        
                        <div class="product-actions">
                            <div class="quantity-section">
                                <label for="quantity">Số lượng:</label>
                                <input type="number" id="quantity" value="1" min="1" 
                                       max="{{ $product['stock'] ?? 10 }}" class="form-control quantity-input">
                            </div>
                            
                            @if($product['status'] == 'available')
                            <div class="action-buttons">
                                <button class="btn btn-primary btn-add-cart" data-product-id="{{ $product['id'] }}">
                                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                </button>
                                <button class="btn btn-success btn-buy-now" data-product-id="{{ $product['id'] }}">
                                    <i class="fa fa-credit-card"></i> Mua ngay
                                </button>
                            </div>
                            @else
                            <div class="action-buttons">
                                <button class="btn btn-secondary" disabled>
                                    <i class="fa fa-ban"></i> Hết hàng
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fa fa-bell"></i> Thông báo khi có hàng
                                </button>
                            </div>
                            @endif
                        </div>
                        
                        <div class="product-features">
                            <h4>Chính sách bán hàng</h4>
                            <ul class="feature-list">
                                <li><i class="fa fa-shield"></i> Bảo hành chính hãng 3 năm</li>
                                <li><i class="fa fa-truck"></i> Giao hàng miễn phí trong thành phố</li>
                                <li><i class="fa fa-credit-card"></i> Hỗ trợ trả góp 0% lãi suất</li>
                                <li><i class="fa fa-wrench"></i> Bảo dưỡng định kỳ miễn phí</li>
                                <li><i class="fa fa-exchange"></i> Đổi trả trong 7 ngày</li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($product && count($relatedProducts) > 0)
    <div class="related-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <div class="line-dec"></div>
                        <h2>Sản phẩm liên quan</h2>
                    </div>
                </div>
                
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-4">
                    <div class="product-item">
                        <a href="{{ route('client.motorcycles.show', $relatedProduct['id']) }}">
                            @if($relatedProduct['image_url'])
                                <img src="{{ $relatedProduct['image_url'] }}" alt="{{ $relatedProduct['name'] }}">
                            @else
                                <img src="{{ asset('img/product_0' . (($loop->index % 5) + 1) . '.jpg') }}" alt="{{ $relatedProduct['name'] }}">
                            @endif
                        </a>
                        <div class="down-content">
                            <a href="{{ route('client.motorcycles.show', $relatedProduct['id']) }}">
                                <h4>{{ $relatedProduct['name'] }}</h4>
                            </a>
                            <h6>{{ number_format($relatedProduct['price'], 0, ',', '.') }} VNĐ</h6>
                            @if(isset($relatedProduct['brand']['name']))
                                <p><small>{{ $relatedProduct['brand']['name'] }}</small></p>
                            @endif
                            <ul class="stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Additional Styling -->
    <style>
    .single-product {
        padding: 60px 0;
    }

    .product-image img {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .product-meta {
        margin-bottom: 20px;
    }

    .brand-badge {
        background: #f33;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        margin-right: 10px;
    }

    .category-badge {
        background: #333;
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .price-section {
        margin-bottom: 25px;
    }

    .current-price {
        color: #f33;
        font-weight: bold;
        font-size: 2.2em;
        margin: 0;
    }

    .stock-info {
        margin-bottom: 25px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .stock-label {
        font-weight: bold;
        margin-right: 10px;
    }

    .in-stock {
        color: #28a745;
        font-weight: bold;
    }

    .out-of-stock {
        color: #dc3545;
        font-weight: bold;
    }

    .stock-quantity {
        color: #6c757d;
        font-size: 0.9em;
        margin-left: 5px;
    }

    .product-description {
        margin-bottom: 30px;
    }

    .product-description h4,
    .specifications h4,
    .product-features h4 {
        color: #333;
        margin-bottom: 15px;
        font-size: 1.2em;
    }

    .specifications {
        margin-bottom: 30px;
    }

    .specifications table {
        margin-top: 15px;
    }

    .specifications td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    .product-actions {
        margin-bottom: 30px;
        padding: 25px;
        background: #f8f9fa;
        border-radius: 10px;
    }

    .quantity-section {
        margin-bottom: 20px;
    }

    .quantity-section label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .quantity-input {
        width: 100px;
        display: inline-block;
        text-align: center;
    }

    .action-buttons {
        text-align: center;
    }

    .action-buttons .btn {
        margin: 0 10px 10px 0;
        padding: 12px 30px;
        font-weight: bold;
        border-radius: 25px;
    }

    .btn-add-cart {
        background: #f33;
        border-color: #f33;
    }

    .btn-add-cart:hover {
        background: #d42c2c;
        border-color: #d42c2c;
    }

    .btn-buy-now {
        background: #28a745;
        border-color: #28a745;
    }

    .btn-buy-now:hover {
        background: #218838;
        border-color: #218838;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin-top: 15px;
    }

    .feature-list li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .feature-list li:last-child {
        border-bottom: none;
    }

    .feature-list i {
        color: #f33;
        margin-right: 10px;
        width: 20px;
    }

    .related-products {
        margin-top: 60px;
        padding: 60px 0;
        background: #f8f9fa;
    }

    .related-products .section-heading {
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .product-image {
            margin-bottom: 30px;
        }
        
        .current-price {
            font-size: 1.8em;
        }
        
        .action-buttons .btn {
            display: block;
            width: 100%;
            margin: 10px 0;
        }
    }
    </style>

    <!-- JavaScript -->
    @if($product)
    <script>
    $(document).ready(function() {
        var productId = {{ $product['id'] }};
        var productName = "{{ $product['name'] }}";
        var maxStock = {{ $product['stock'] ?? 10 }};

        // Quantity input validation
        $('#quantity').on('change', function() {
            var value = parseInt($(this).val());
            var max = parseInt($(this).attr('max'));
            var min = parseInt($(this).attr('min'));
            
            if (value > max) {
                $(this).val(max);
                alert('Số lượng tối đa là ' + max);
            }
            
            if (value < min) {
                $(this).val(min);
            }
        });

        // Add to cart button
        $('.btn-add-cart').on('click', function() {
            var quantity = $('#quantity').val();
            alert('Đã thêm ' + quantity + ' sản phẩm "' + productName + '" vào giỏ hàng!');
            
            // Here you would typically send an AJAX request to add the product to cart
            // Example:
            // $.ajax({
            //     url: '/cart/add',
            //     method: 'POST',
            //     data: {
            //         product_id: productId,
            //         quantity: quantity,
            //         _token: '{{ csrf_token() }}'
            //     },
            //     success: function(response) {
            //         // Handle success - update cart count, show message, etc.
            //         console.log('Product added to cart successfully');
            //     },
            //     error: function(xhr) {
            //         alert('Có lỗi xảy ra. Vui lòng thử lại!');
            //     }
            // });
        });

        // Buy now button
        $('.btn-buy-now').on('click', function() {
            var quantity = $('#quantity').val();
            alert('Chuyển đến trang thanh toán với ' + quantity + ' sản phẩm "' + productName + '"!');
            
            // Here you would redirect to checkout page
            // window.location.href = '/checkout?product_id=' + productId + '&quantity=' + quantity;
        });

        // Product image zoom effect (optional)
        $('.product-image img').on('mouseenter', function() {
            $(this).css({
                'transform': 'scale(1.05)',
                'transition': 'transform 0.3s ease'
            });
        }).on('mouseleave', function() {
            $(this).css({
                'transform': 'scale(1)',
                'transition': 'transform 0.3s ease'
            });
        });
    });
    </script>
    @endif
@endsection