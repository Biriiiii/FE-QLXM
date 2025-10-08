@extends('layouts.client')

@section('title', 'Hãng Xe Máy - QLXM')
@section('description', 'Xem danh sách các hãng xe máy uy tín như Honda, Yamaha, Suzuki tại QLXM')

@push('styles')
    <style>
        /* Custom styles for brand logos */
        .brand-grid .team-member {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            height: 100%;
        }

        .brand-grid .team-member:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .brand-grid .thumb-container {
            position: relative;
            height: 200px !important;
            background: #ffffff;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 20px;
            overflow: hidden;
        }

        .brand-grid .thumb-container img {
            max-width: 180px !important;
            max-height: 160px !important;
            width: auto !important;
            height: auto !important;
            object-fit: contain !important;
            object-position: center !important;
            transition: transform 0.3s ease;
        }

        .brand-grid .thumb-container:hover img {
            transform: scale(1.1);
        }

        .brand-grid .hover-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(243, 63, 63, 0.9);
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-grid .thumb-container:hover .hover-effect {
            opacity: 1;
        }

        .brand-grid .down-content {
            padding: 25px 20px;
            text-align: center;
            background: #fff;
        }

        .brand-grid .down-content h4 {
            color: #333;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .brand-grid .down-content span {
            color: #f33f3f;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .brand-grid .down-content p {
            color: #666;
            font-size: 14px;
            line-height: 1.7;
            margin-top: 15px;
            margin-bottom: 0;
        }

        /* Ensure equal height columns */
        .brand-grid .row {
            display: flex;
            flex-wrap: wrap;
        }

        .brand-grid .col-md-4 {
            display: flex;
            margin-bottom: 30px;
        }

        .filled-button {
            background: #fff !important;
            color: #f33f3f !important;
            border: 2px solid #fff !important;
            padding: 12px 25px !important;
            border-radius: 25px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            font-size: 12px !important;
            letter-spacing: 1px !important;
            transition: all 0.3s ease !important;
        }

        .filled-button:hover {
            background: transparent !important;
            color: #fff !important;
            border-color: #fff !important;
            text-decoration: none !important;
        }
    </style>
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="page-heading products-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>thương hiệu uy tín</h4>
                        <h2>hãng xe máy</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Brands Section -->
    <div class="best-features">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Các Hãng Xe Máy Hàng Đầu</h2>
                    </div>
                </div>
            </div>

            @if (!empty($error))
                <div class="alert alert-danger text-center my-4">
                    <strong>Lỗi:</strong> {{ $error }}
                </div>
            @endif

            <div class="brand-grid">
                <div class="row">
                    @forelse ($brands as $brand)
                        <div class="col-md-4">
                            <div class="team-member">
                                <div class="thumb-container">
                                    @if (!empty($brand['logo']))
                                        <img src="{{ config('app.be_api_url') }}/storage/{{ $brand['logo'] }}"
                                            alt="{{ $brand['name'] }}">
                                    @else
                                        <img src="{{ asset('img/brands/default.png') }}" alt="{{ $brand['name'] }}">
                                    @endif
                                    <div class="hover-effect">
                                        <div class="hover-content">
                                            <a href="{{ route('client.brands.show', $brand['id']) }}"
                                                class="filled-button">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="down-content">
                                    <h4>{{ $brand['name'] }}</h4>
                                    <span>{{ $brand['country'] ?? 'Chưa rõ' }}</span>
                                    <p>{{ $brand['description'] ?? 'Không có mô tả.' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="text-center py-5">
                                <h4>Không có thương hiệu nào</h4>
                                <p>Hiện tại chưa có dữ liệu về hãng xe máy.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Brand Comparison -->

@endsection
