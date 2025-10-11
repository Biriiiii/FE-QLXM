@extends('layouts.client')

@section('title', 'Về Chúng Tôi - QLXM')
@section('description',
    'Tìm hiểu về QLXM - Hệ thống quản lý xe máy hàng đầu Việt Nam với đội ngũ chuyên nghiệp và dịch
    vụ tận tâm')

@section('content')
    <!-- Page Heading -->
    <div class="page-heading about-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>về chúng tôi</h4>
                        <h2>hệ thống QLXM</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Background -->
    <div class="best-features about-features">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Lịch Sử Hình Thành</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-image">
                        <img src="{{ asset('img/feature-image.jpg') }}" alt="Cửa hàng QLXM">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="left-content">
                        <h4>Chúng tôi là ai &amp; Chúng tôi làm gì?</h4>
                        <p>QLXM được thành lập với sứ mệnh mang đến cho khách hàng Việt Nam những chiếc xe máy chất lượng
                            cao với giá cả hợp lý nhất. Với hơn 10 năm kinh nghiệm trong ngành, chúng tôi tự hào là đối tác
                            tin cậy của các hãng xe máy hàng đầu thế giới.<br><br>Hệ thống QLXM không chỉ cung cấp xe máy mà
                            còn mang đến dịch vụ bảo hành, bảo dưỡng và phụ kiện chính hãng. Chúng tôi cam kết luôn đặt lợi
                            ích khách hàng lên hàng đầu.</p>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Founders Section -->
    <div class="founders-section" style="background-color: #f8f9fa; padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Người Sáng Lập</h2>
                        <p>Những con người đã tạo nên thành công của QLXM ngày hôm nay</p>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-2">
                    <div class="founder-item text-center">
                        <div class="founder-image" style="margin-bottom: 20px;">
                            <img src="{{ asset('img/founder_01.jpg') }}" alt="Biriii"
                                style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; margin: 0 auto; display: block;">
                        </div>
                        <div class="founder-content">
                            <h3 style="color: #333; margin-bottom: 10px;">Biriii</h3>
                            <h5 style="color: #007bff; margin-bottom: 15px;">Đồng Sáng Lập & Chủ Tịch HĐQT</h5>
                            <p style="color: #666; line-height: 1.6;">Với tầm nhìn xa và kinh nghiệm sâu rộng trong ngành xe
                                máy, anh Biriii đã dẫn dắt QLXM từ những ngày đầu thành lập đến thành một trong những hệ
                                thống
                                phân phối xe máy hàng đầu Việt Nam.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="founder-item text-center">
                        <div class="founder-image" style="margin-bottom: 20px;">
                            <img src="{{ asset('img/founder_02.jpg') }}" alt="Phước Otaku"
                                style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; margin: 0 auto; display: block;">
                        </div>
                        <div class="founder-content">
                            <h3 style="color: #333; margin-bottom: 10px;">Phước Otaku</h3>
                            <h5 style="color: #007bff; margin-bottom: 15px;">Đồng Sáng Lập & Tổng Giám Đốc</h5>
                            <p style="color: #666; line-height: 1.6;">Anh Phước là chuyên gia về quản lý vận hành và phát
                                triển kinh doanh. Nhờ sự tận tâm và chiến lược kinh doanh hiệu quả, QLXM đã mở rộng mạng
                                lưới trên toàn quốc và giành được lòng tin của hàng triệu khách hàng.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Members -->
    <div class="team-members">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Đội Ngũ Của Chúng Tôi</h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <div class="thumb-container">
                            <img src="{{ asset('img/founder_01.jpg') }}" alt="Biriii">
                            <div class="hover-effect">
                                <div class="hover-content">
                                    <ul class="social-icons">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fa fa-behance"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="down-content">
                            <h4>Biriii</h4>
                            <span>Đồng Sáng Lập & Chủ Tịch HĐQT</span>
                            <p>Người sáng lập với tầm nhìn chiến lược, đã xây dựng QLXM thành thương hiệu uy tín trong ngành
                                xe máy Việt Nam.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <div class="thumb-container">
                            <img src="{{ asset('img/founder_02.jpg') }}" alt="Phước Otaku">
                            <div class="hover-effect">
                                <div class="hover-content">
                                    <ul class="social-icons">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fa fa-behance"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="down-content">
                            <h4>Lang</h4>
                            <span>Đồng Sáng Lập & Tổng Giám Đốc</span>
                            <p>Chuyên gia quản lý vận hành, dẫn dắt QLXM phát triển mạng lưới showroom trên toàn quốc.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services -->
    <div class="services">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa fa-gear"></i>
                        </div>
                        <div class="down-content">
                            <h4>Quản Lý Sản Phẩm</h4>
                            <p>Hệ thống quản lý kho xe máy hiện đại, đảm bảo luôn có sẵn các dòng xe hot nhất thị trường.
                            </p>
                            <a href="#" class="filled-button">Tìm Hiểu Thêm</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa fa-gear"></i>
                        </div>
                        <div class="down-content">
                            <h4>Chăm Sóc Khách Hàng</h4>
                            <p>Đội ngũ tư vấn chuyên nghiệp, hỗ trợ khách hàng 24/7 từ việc chọn xe đến bảo hành.</p>
                            <a href="#" class="filled-button">Chi Tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-item">
                        <div class="icon">
                            <i class="fa fa-gear"></i>
                        </div>
                        <div class="down-content">
                            <h4>Mạng Lưới Toàn Quốc</h4>
                            <p>Hệ thống showroom và trung tâm bảo hành rộng khắp cả nước, phục vụ tận nơi.</p>
                            <a href="#" class="filled-button">Xem Thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Happy Partners -->
    <div class="happy-clients">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Đối Tác Tin Cậy</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="owl-clients owl-carousel">
                        <div class="client-item">
                            <img src="{{ asset('img/client-01.png') }}" alt="Honda">
                        </div>
                        <div class="client-item">
                            <img src="{{ asset('img/client-01.png') }}" alt="Yamaha">
                        </div>
                        <div class="client-item">
                            <img src="{{ asset('img/client-01.png') }}" alt="Suzuki">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
