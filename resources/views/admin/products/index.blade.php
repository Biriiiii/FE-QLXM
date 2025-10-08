@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <h1 class="fw-bold text-center mb-4" style="color:#fff;">Danh sách sản phẩm</h1>

        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Thêm sản phẩm</a>
            </div>
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.products.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm sản phẩm..."
                        value="{{ request('search') }}"
                        style="background:#23262f; color:#eaeaea; border:1px solid #34495e;">
                    <button type="submit" class="btn btn-outline-light">Tìm</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (isset($error))
            <div class="alert alert-danger">
                <strong>Lỗi:</strong> {{ $error }}
                <br><small>Hãy đảm bảo backend đang chạy trên: {{ config('app.be_api_url') }}</small>
            </div>
        @endif

        <div class="card shadow-sm border-0" style="background:#23262f; color:#eaeaea; border-radius:1rem;">
            <div class="card-body p-0">
                <table class="table mb-0" style="background:#23262f; color:#eaeaea; border-radius:1rem; overflow:hidden;">
                    <thead style="background:#181a20; color:#fff;">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Kho</th>
                            <th>Trạng thái</th>
                            <th>Thương hiệu</th>
                            <th>Danh mục</th>
                            <th>Mô tả</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $index => $product)
                            <tr style="border-bottom:1px solid #23262f;">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product['name'] }}</td>
                                <td>
                                    @if (!empty($product['image']))
                                        <img src="{{ config('app.be_api_url') }}/storage/{{ $product['image'] }}"
                                            alt="{{ $product['name'] }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ number_format($product['price'], 0, ',', '.') }} đ</td>
                                <td>{{ $product['stock'] ?? '-' }}</td>
                                <td>{{ $product['status'] ?? '-' }}</td>
                                <td>{{ $product['brand']['name'] ?? '-' }}</td>
                                <td>{{ $product['category']['name'] ?? '-' }}</td>
                                <td>{{ $product['description'] ?? '-' }}</td>
                                <td>
                                    @if (!empty($product['id']))
                                        <a href="{{ route('admin.products.edit', $product['id']) }}"
                                            class="btn btn-sm btn-warning me-1" style="border-radius:0.5rem;">Sửa</a>

                                        <form action="{{ route('admin.products.destroy', $product['id']) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                style="border-radius:0.5rem;">Xóa</button>
                                        </form>
                                    @else
                                        <span class="text-danger">Thiếu ID</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Không có sản phẩm nào.</td>
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
