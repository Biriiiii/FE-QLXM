@extends('layouts.client')

@section('title', isset($product['name']) ? $product['name'] . ' - Chi tiết xe máy - QLXM' : 'Chi tiết xe máy - QLXM')
@section('description', isset($product['name']) ? 'Chi tiết xe máy ' . $product['name'] . ' giá ' .
    (isset($product['price']) ? number_format($product['price'], 0, ',', '.') : '0') . ' VNĐ' : 'Xem chi tiết thông tin xe
    máy')

@section('content')
    <div class="page-heading product-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="text-content">
                        <h4>chi tiết sản phẩm</h4>
                        <h2>Thông tin xe máy</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="single-product py-5">
        <div class="container">
            @if (isset($error))
                <div class="alert alert-danger text-center">{{ $error }}</div>
            @elseif(!empty($product) && isset($product['id']))
                <div class="row align-items-start">
                    {{-- Ảnh sản phẩm --}}
                    <div class="col-md-6 mb-4">
                        <img src="{{ $product['image_url'] ?? asset('img/product_01.jpg') }}"
                            alt="{{ $product['name'] ?? 'Xe máy' }}" class="img-fluid rounded shadow">
                    </div>

                    {{-- Thông tin sản phẩm --}}
                    <div class="col-md-6">
                        <h2 class="fw-bold mb-3">{{ $product['name'] }}</h2>
                        <div class="mb-3">
                            @if (isset($product['brand']['name']))
                                <span class="badge bg-danger me-2">{{ $product['brand']['name'] }}</span>
                            @endif
                            @if (isset($product['category']['name']))
                                <span class="badge bg-dark">{{ $product['category']['name'] }}</span>
                            @endif
                        </div>

                        <h4 class="text-danger fw-bold mb-3">
                            {{ number_format($product['price'] ?? 0, 0, ',', '.') }} VNĐ
                        </h4>

                        <p class="mb-4">{{ $product['description'] ?? 'Chưa có mô tả sản phẩm.' }}</p>

                        {{-- Form Thêm vào giỏ hàng --}}
                        <form action="{{ route('client.cart.add', $product['id'] ?? 0) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="d-flex align-items-center mb-3">
                                <label for="quantity" class="me-2 fw-semibold">Số lượng:</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1"
                                    max="{{ $product['stock'] ?? 10 }}" class="form-control" style="width: 100px;">
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fa fa-cart-plus me-2"></i>Thêm vào giỏ hàng
                            </button>
                            <button type="button" class="btn btn-success btn-lg ms-2" data-bs-toggle="modal"
                                data-bs-target="#orderNowModal">
                                <i class="fa fa-credit-card me-2"></i>Mua ngay
                            </button>
                        </form>

                        <div class="text-muted small mb-4">
                            <strong>Tình trạng:</strong>
                            @if ($product['status'] == 'available')
                                <span class="text-success fw-semibold">Còn hàng</span>
                            @else
                                <span class="text-danger fw-semibold">Hết hàng</span>
                            @endif
                            @if (!empty($product['stock']))
                                (Còn {{ $product['stock'] }} chiếc)
                            @endif
                        </div>

                        <h5 class="fw-semibold mb-3">Chính sách bán hàng</h5>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-shield text-danger me-2"></i>Bảo hành 3 năm</li>
                            <li><i class="fa fa-truck text-danger me-2"></i>Giao hàng miễn phí</li>
                            <li><i class="fa fa-credit-card text-danger me-2"></i>Trả góp 0%</li>
                            <li><i class="fa fa-exchange text-danger me-2"></i>Đổi trả trong 7 ngày</li>
                        </ul>
                    </div>
                </div>

                {{-- Modal Đặt hàng ngay --}}
                <div class="modal fade" id="orderNowModal" tabindex="-1" aria-labelledby="orderNowModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="orderNowForm">
                                <div class="modal-header">
                                    <h5 class="modal-title">Đặt hàng ngay</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="orderName" class="form-label">Họ tên</label>
                                        <input type="text" id="orderName" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="orderPhone" class="form-label">Số điện thoại</label>
                                        <input type="text" id="orderPhone" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="orderAddress" class="form-label">Địa chỉ</label>
                                        <input type="text" id="orderAddress" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="orderQuantity" class="form-label">Số lượng</label>
                                        <input type="number" id="orderQuantity" class="form-control" value="1"
                                            min="1" max="{{ $product['stock'] ?? 10 }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-success">Xác nhận đặt hàng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Sản phẩm liên quan --}}
                @if (!empty($relatedProducts))
                    <hr class="my-5">
                    <h4 class="text-center mb-4 fw-bold">Sản phẩm liên quan</h4>
                    <div class="row">
                        @foreach ($relatedProducts as $item)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <a href="{{ route('client.motorcycles.show', $item['id']) }}">
                                        <img src="{{ $item['image_url'] ?? asset('img/product_01.jpg') }}"
                                            class="card-img-top" style="height:200px;object-fit:contain;">
                                    </a>
                                    <div class="card-body text-center">
                                        <h6 class="fw-semibold">{{ $item['name'] }}</h6>
                                        <p class="text-danger mb-2 fw-bold">
                                            {{ number_format($item['price'], 0, ',', '.') }} VNĐ</p>
                                        <a href="{{ route('client.motorcycles.show', $item['id']) }}"
                                            class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
