@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <h1 class="fw-bold text-center mb-4" style="color:#fff;">Danh sách khách hàng</h1>
        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary mb-3">+ Thêm khách hàng</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card shadow-sm border-0" style="background:#23262f; color:#eaeaea; border-radius:1rem;">
            <div class="card-body p-0">
                <table class="table mb-0" style="background:#23262f; color:#eaeaea; border-radius:1rem; overflow:hidden;">
                    <thead style="background:#181a20; color:#fff;">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Điện thoại</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $index => $customer)
                            <tr style="border-bottom:1px solid #23262f;">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $customer['name'] }}</td>
                                <td>{{ $customer['phone'] }}</td>
                                <td>{{ $customer['email'] }}</td>
                                <td>{{ $customer['address'] }}</td>
                                <td>
                                    <a href="{{ route('admin.customers.edit', $customer['id']) }}"
                                        class="btn btn-sm btn-warning" style="border-radius:0.5rem;">Sửa</a>
                                    <form action="{{ route('admin.customers.destroy', $customer['id']) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" style="border-radius:0.5rem;"
                                            onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if (empty($customers))
                            <tr>
                                <td colspan="6">Không có khách hàng nào.</td>
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
