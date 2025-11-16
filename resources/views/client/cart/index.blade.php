@extends('layouts.client')

@section('title', 'Giỏ hàng - QLXM')

@section('content')
    <div class="page-heading products-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="text-content">
                        <h4>Giỏ hàng</h4>
                        <h2>Sản phẩm đã chọn</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(!empty($cartItems) && count($cartItems) > 0)
            <div class="row">
                <div class="col-md-8">
                    <h4 class="mb-4">Giỏ hàng của bạn</h4>
                    
                    @foreach($cartItems as $item)
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" 
                                         class="img-fluid rounded-start h-100" style="object-fit: cover;">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item['name'] }}</h5>
                                        <p class="text-danger fw-bold fs-5">
                                            {{ number_format($item['price'], 0, ',', '.') }} VNĐ
                                        </p>
                                        
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <form action="{{ route('client.cart.update', $item['id']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <div class="input-group" style="width: 150px;">
                                                        <input type="number" name="quantity" class="form-control text-center" 
                                                               value="{{ $item['quantity'] }}" min="1" max="99">
                                                        <button class="btn btn-outline-primary" type="submit">
                                                            Cập nhật
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Tổng: <span class="text-danger">
                                                    {{ number_format($item['subtotal'], 0, ',', '.') }} VNĐ
                                                </span></strong>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <form action="{{ route('client.cart.remove', $item['id']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                        <i class="fa fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($totalPrice, 0, ',', '.') }} VNĐ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển:</span>
                                <span class="text-success">Miễn phí</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Tổng cộng:</strong>
                                <strong class="text-danger fs-4">
                                    {{ number_format($totalPrice, 0, ',', '.') }} VNĐ
                                </strong>
                            </div>
                            
                            <button class="btn btn-danger w-100 btn-lg mb-2" 
                                    onclick="alert('Chức năng thanh toán sẽ được cập nhật sớm!')">
                                <i class="fa fa-credit-card me-2"></i>Thanh toán
                            </button>
                            
                            <a href="{{ route('client.motorcycles') }}" class="btn btn-outline-primary w-100">
                                <i class="fa fa-shopping-bag me-2"></i>Tiếp tục mua hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa fa-shopping-cart fa-5x text-muted mb-3"></i>
                <h3>Giỏ hàng trống</h3>
                <p class="text-muted">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                <a href="{{ route('client.motorcycles') }}" class="btn btn-primary btn-lg">
                    <i class="fa fa-shopping-bag me-2"></i>Mua sắm ngay
                </a>
            </div>
        @endif
    </div>
@endsection