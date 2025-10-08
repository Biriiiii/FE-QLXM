@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Sửa đơn hàng</h1>
        <form action="{{ route('admin.orders.update', $order['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="customer_id" class="form-label">Khách hàng</label>
                <select name="customer_id" class="form-control" required>
                    <option value="">-- Chọn khách hàng --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer['id'] }}"
                            {{ old('customer_id', $order['customer_id']) == $customer['id'] ? 'selected' : '' }}>
                            {{ $customer['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="total" class="form-label">Tổng tiền</label>
                <input type="number" name="total" class="form-control" value="{{ old('total', $order['total']) }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <input type="text" name="status" class="form-control" value="{{ old('status', $order['status']) }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Ghi chú</label>
                <textarea name="note" class="form-control">{{ old('note', $order['note']) }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
