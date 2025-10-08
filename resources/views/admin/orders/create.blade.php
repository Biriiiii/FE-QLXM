@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Thêm đơn hàng mới</h1>
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="customer_id" class="form-label">Khách hàng</label>
                <select name="customer_id" class="form-control" required>
                    <option value="">-- Chọn khách hàng --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="total" class="form-label">Tổng tiền</label>
                <input type="number" name="total" class="form-control" value="{{ old('total') }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <input type="text" name="status" class="form-control" value="{{ old('status', 'pending') }}" required>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Ghi chú</label>
                <textarea name="note" class="form-control">{{ old('note') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Lưu</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
