@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Thêm sản phẩm vào đơn hàng</h1>
        <form action="{{ route('admin.orderitems.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="order_id" class="form-label">Đơn hàng</label>
                <select name="order_id" class="form-control" required>
                    <option value="">-- Chọn đơn hàng --</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                            {{ $order->id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Sản phẩm</label>
                <select name="product_id" class="form-control" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1"
                    required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>
            <button type="submit" class="btn btn-success">Lưu</button>
            <a href="{{ route('admin.orderitems.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
