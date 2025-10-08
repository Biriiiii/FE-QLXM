@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')
    <div class="container py-4">
        <h1 class="fw-bold text-center mb-4" style="color:#fff;">Danh sách Danh mục</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">+ Thêm Danh mục</a>
        @include('admin.components.alert')
        <div class="card shadow-sm border-0" style="background:#23262f; color:#eaeaea; border-radius:1rem;">
            <div class="card-body p-0">
                <table class="table mb-0" style="background:#23262f; color:#eaeaea; border-radius:1rem; overflow:hidden;">
                    <thead style="background:#181a20; color:#fff;">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Ngày tạo</th>
                            <th>Ngày sửa</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                            <tr style="border-bottom:1px solid #23262f;">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category['name'] }}</td>
                                <td>{{ $category['description'] ?? '-' }}</td>
                                <td>{{ $category['created_at'] ?? '-' }}</td>
                                <td>{{ $category['updated_at'] ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category['id']) }}"
                                        class="btn btn-warning btn-sm" style="border-radius:0.5rem;">Sửa</a>
                                    <form action="{{ route('admin.categories.destroy', $category['id']) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" style="border-radius:0.5rem;">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if (empty($categories))
                            <tr>
                                <td colspan="6">Không có danh mục nào.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Phân trang bị loại bỏ vì $categories là mảng phẳng từ API --}}
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
