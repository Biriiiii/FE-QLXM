@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Chi tiết sản phẩm</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">Giá: {{ number_format($product->price, 0, ',', '.') }} đ</p>
                <p class="card-text">Kho: {{ $product->stock }}</p>
                <p class="card-text">Trạng thái: {{ $product->status }}</p>
                <p class="card-text">Mô tả: {{ $product->description }}</p>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Sửa</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
@endsection
