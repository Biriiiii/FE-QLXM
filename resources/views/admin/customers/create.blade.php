@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Thêm khách hàng mới</h1>
    <form action="{{ route('admin.customers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên khách hàng</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
