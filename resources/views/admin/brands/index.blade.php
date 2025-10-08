@extends('layouts.admin')

@section('title', 'Quản lý Thương hiệu')

@section('content')
    <div class="container py-4">
        <h1 class="fw-bold text-center mb-4" style="color:#fff;">Danh sách thương hiệu</h1>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary mb-3">+ Thêm thương hiệu</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
        @endif
        <div class="card shadow-sm border-0" style="background:#23262f; color:#eaeaea; border-radius:1rem;">
            <div class="card-body p-0">
                <table class="table mb-0" style="background:#23262f; color:#eaeaea; border-radius:1rem; overflow:hidden;">
                    <thead style="background:#181a20; color:#fff;">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Quốc gia</th>
                            <th>Logo</th>
                            <th>Ngày tạo</th>
                            <th>Ngày sửa</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $index => $brand)
                            <tr style="border-bottom:1px solid #23262f;">
                                <td>{{ $brand['id'] }}</td>
                                <td>{{ $brand['name'] }}</td>
                                <td>{{ $brand['country'] ?? '-' }}</td>
                                <td>
                                    @if (!empty($brand['logo']))
                                        <img src="{{ config('app.be_api_url') }}/storage/{{ $brand['logo'] }}"
                                            alt="{{ $brand['name'] }}"
                                            style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $brand['created_at'] ?? '-' }}</td>
                                <td>{{ $brand['updated_at'] ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.brands.edit', $brand['id']) }}" class="btn btn-warning btn-sm"
                                        style="border-radius:0.5rem;">Sửa</a>
                                    <form action="{{ route('admin.brands.destroy', $brand['id']) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" style="border-radius:0.5rem;">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có thương hiệu nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Admin Pagination Component --}}
        @include('components.admin-pagination')
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
