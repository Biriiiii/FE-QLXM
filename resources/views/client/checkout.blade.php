@extends('layouts.client')

@section('title', 'Thanh Toán - QLXM')

@section('content')
    <div class="page-heading products-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>Thanh Toán</h4>
                        <h2>hoàn tất đơn hàng của bạn</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="products">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="contact-form">
                        <div class="section-heading">
                            <h2>Thông tin giao hàng</h2>
                        </div>
                        <form action="{{ route('client.checkout.process') }}" method="POST" id="checkout-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                            id="name" placeholder="Họ và tên" required value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                            id="email" placeholder="Địa chỉ E-Mail" required value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                                            id="phone" placeholder="Số điện thoại" required value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="address" rows="6" class="form-control @error('address') is-invalid @enderror" 
                                            id="address" placeholder="Địa chỉ của bạn" required>{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" 
                                            id="notes" placeholder="Ghi chú (tùy chọn)">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="section-heading">
                        <h2>Tóm tắt đơn hàng</h2>
                    </div>
                    {{-- Order summary will go here --}}
                    <div class="order-summary">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(!empty($cart))
                            <div class="cart-items mb-4">
                                @foreach($cart as $item)
                                    <div class="cart-item mb-2">
                                        <p>{{ $item['name'] }} x {{ $item['quantity'] }}<br>
                                        <span class="text-muted">{{ number_format($item['price'], 0, ',', '.') }} VNĐ</span></p>
                                    </div>
                                @endforeach
                            </div>
                            <p>Tổng cộng: <strong>{{ number_format($total, 0, ',', '.') }} VNĐ</strong></p>
                        @else
                            <p>Giỏ hàng trống</p>
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <fieldset>
                            <button type="submit" form="checkout-form" id="form-submit" 
                                class="filled-button" {{ empty($cart) ? 'disabled' : '' }}>
                                Đặt Hàng
                            </button>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
