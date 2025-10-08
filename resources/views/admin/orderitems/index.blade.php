@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <h1 class="fw-bold text-center mb-4" style="color:#fff;">Danh sách sản phẩm trong đơn hàng</h1>
        <a href="{{ route('admin.orderitems.create') }}" class="btn btn-primary mb-3">+ Thêm sản phẩm vào đơn hàng</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card shadow-sm border-0" style="background:#23262f; color:#eaeaea; border-radius:1rem;">
            <div class="card-body p-0">
                <table class="table mb-0" style="background:#23262f; color:#eaeaea; border-radius:1rem; overflow:hidden;">
                    <thead style="background:#181a20; color:#fff;">
                        <tr>
                            <th>ID</th>
                            <th>Đơn hàng</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderItems['data'] as $item)
                            <tr style="border-bottom:1px solid #23262f;">
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['order']['id'] ?? '' }}</td>
                                <td>{{ $item['product']['name'] ?? '' }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                                <td>
                                    <a href="{{ route('admin.orderitems.edit', $item['id']) }}"
                                        class="btn btn-sm btn-warning" style="border-radius:0.5rem;">Sửa</a>
                                    <form action="{{ route('admin.orderitems.destroy', $item['id']) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" style="border-radius:0.5rem;"
                                            onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if (empty($orderItems['data']))
                            <tr>
                                <td colspan="6">Không có sản phẩm nào.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        .table th,
        .table td {
            vertical-align: middle !important;
        }

        .table tbody tr:hover {
            background: #181a20 !important;
        }

        .btn-warning {
            background: #f59e42 !important;
            color: #fff !important;
        }

        .btn-danger {
            background: #ef4444 !important;
            color: #fff !important;
        }

        .btn-primary {
            background: #2563eb !important;
            color: #fff !important;
        }
    </style>
@endpush
