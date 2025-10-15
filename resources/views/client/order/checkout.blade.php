@extends('layouts.client')

@section('title', 'Đặt hàng & Nhập thông tin khách hàng')
@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Thông tin đặt hàng</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('client.cart.processCheckout') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Họ tên *</label>
                <input type="text" name="name" id="name" class="form-control" required
                    value="{{ old('name', $customerInfo['name'] ?? '') }}">
            </div>
            <div class="form-group mb-3">
                <label for="phone">Số điện thoại *</label>
                <input type="text" name="phone" id="phone" class="form-control" required
                    value="{{ old('phone', $customerInfo['phone'] ?? '') }}">
            </div>
            <div class="form-group mb-3">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" class="form-control" required
                    value="{{ old('email', $customerInfo['email'] ?? '') }}">
            </div>
            <div class="form-group mb-3">
                <label for="address">Địa chỉ nhận hàng *</label>
                <input type="text" name="address" id="address" class="form-control" required
                    value="{{ old('address', $customerInfo['address'] ?? '') }}">
            </div>
            <div class="mb-3">
                <strong>Bạn cần đặt cọc 30% tổng giá trị đơn hàng để xác nhận đặt hàng.</strong>
            </div>
            <button type="submit" class="btn btn-success">Xác nhận đặt hàng & Đặt cọc 30%</button>
            <a href="{{ route('client.cart.index') }}" class="btn btn-secondary">Quay lại giỏ hàng</a>
        </form>
    </div>
@endsection
