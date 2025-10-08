@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Sửa sản phẩm trong đơn hàng</h1>
        <form action="{{ route('admin.orderitems.update', $orderItem['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="order_id" class="form-label">Đơn hàng</label>
                <select name="order_id" class="form-control" required>
                    <option value="">-- Chọn đơn hàng --</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order['id'] }}"
                            {{ old('order_id', $orderItem['order_id']) == $order['id'] ? 'selected' : '' }}>
                            {{ $order['id'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Sản phẩm</label>
                <select name="product_id" class="form-control" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product['id'] }}"
                            {{ old('product_id', $orderItem['product_id']) == $product['id'] ? 'selected' : '' }}>
                            {{ $product['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" name="quantity" class="form-control"
                    value="{{ old('quantity', $orderItem['quantity']) }}" min="1" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $orderItem['price']) }}"
                    required>
            </div>
            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('admin.orderitems.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
