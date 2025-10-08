@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-4">
        <h1 class="mb-4 fw-bold">Dashboard</h1>
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 dashboard-card h-100"
                        style="transition:transform .2s; cursor:pointer; border-radius:1rem; background:linear-gradient(135deg,#3b82f6 60%,#60a5fa 100%); color:#fff;">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1">Sản phẩm</h5>
                                <p class="card-text fs-3 fw-bold mb-0">{{ $productCount }}</p>
                            </div>
                            <i class="bi bi-box-seam" style="font-size:2.5rem;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.customers.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 dashboard-card h-100"
                        style="transition:transform .2s; cursor:pointer; border-radius:1rem; background:linear-gradient(135deg,#22c55e 60%,#4ade80 100%); color:#fff;">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1">Khách hàng</h5>
                                <p class="card-text fs-3 fw-bold mb-0">{{ $customerCount }}</p>
                            </div>
                            <i class="bi bi-people" style="font-size:2.5rem;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 dashboard-card h-100"
                        style="transition:transform .2s; cursor:pointer; border-radius:1rem; background:linear-gradient(135deg,#f59e42 60%,#fbbf24 100%); color:#fff;">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1">Đơn hàng</h5>
                                <p class="card-text fs-3 fw-bold mb-0">{{ $orderCount }}</p>
                            </div>
                            <i class="bi bi-cart-check" style="font-size:2.5rem;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 dashboard-card h-100"
                        style="transition:transform .2s; cursor:pointer; border-radius:1rem; background:linear-gradient(135deg,#0ea5e9 60%,#38bdf8 100%); color:#fff;">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-1">Người dùng</h5>
                                <p class="card-text fs-3 fw-bold mb-0">{{ $userCount }}</p>
                            </div>
                            <i class="bi bi-person-circle" style="font-size:2.5rem;"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @push('scripts')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
            <style>
                .dashboard-card:hover {
                    transform: scale(1.04);
                    box-shadow: 0 0 0.5rem #0002;
                    opacity: 0.95;
                }

                .dashboard-card i {
                    opacity: 0.8;
                }
            </style>
        @endpush
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Đơn hàng mới nhất</div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestOrders as $order)
                                    <tr>
                                        <td>{{ $order['id'] }}</td>
                                        <td>{{ $order['customer']['name'] ?? '-' }}</td>
                                        <td>{{ number_format($order['total_amount'] ?? 0, 0, ',', '.') }}₫</td>
                                        <td>{{ $order['status'] ?? '-' }}</td>
                                        <td>{{ !empty($order['created_at']) ? \Carbon\Carbon::parse($order['created_at'])->format('d/m/Y') : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Sản phẩm mới nhất</div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latestProducts as $product)
                                    <tr>
                                        <td>{{ $product['id'] }}</td>
                                        <td>{{ $product['name'] }}</td>
                                        <td>{{ number_format($product['price'] ?? 0, 0, ',', '.') }}₫</td>
                                        <td>{{ !empty($product['created_at']) ? \Carbon\Carbon::parse($product['created_at'])->format('d/m/Y') : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
