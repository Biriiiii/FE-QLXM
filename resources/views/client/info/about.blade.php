@extends('layouts.client')

@section('title', 'Về Chúng Tôi - QLXM')
@section('description', 'Tìm hiểu về QLXM - Hệ thống quản lý xe máy hàng đầu Việt Nam với đội ngũ chuyên nghiệp và dịch vụ tận tâm')

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
                        <p>QLXM được thành lập với sứ mệnh mang đến cho khách hàng Việt Nam những chiếc xe máy chất lượng cao với giá cả hợp lý nhất. Với hơn 10 năm kinh nghiệm trong ngành, chúng tôi tự hào là đối tác tin cậy của các hãng xe máy hàng đầu thế giới.<br><br>Hệ thống QLXM không chỉ cung cấp xe máy mà còn mang đến dịch vụ bảo hành, bảo dưỡng và phụ kiện chính hãng. Chúng tôi cam kết luôn đặt lợi ích khách hàng lên hàng đầu.</p>
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
                            <img src="{{ asset('img/team_01.jpg') }}" alt="Nguyễn Văn An">
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
                            <h4>Nguyễn Văn An</h4>
                            <span>Giám Đốc Điều Hành</span>
                            <p>Với 15 năm kinh nghiệm trong ngành xe máy, anh An là người đã xây dựng nên thương hiệu QLXM.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <div class="thumb-container">
                            <img src="{{ asset('img/team_02.jpg') }}" alt="Trần Thị Bình">
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
                            <h4>Trần Thị Bình</h4>
                            <span>Chuyên Gia Sản Phẩm</span>
                            <p>Chị Bình có kiến thức sâu rộng về các dòng xe máy và luôn tư vấn tận tâm cho khách hàng.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <div class="thumb-container">
                            <img src="{{ asset('img/team_03.jpg') }}" alt="Lê Văn Cường">
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
                            <h4>Lê Văn Cường</h4>
                            <span>Trưởng Phòng Marketing</span>
                            <p>Anh Cường chịu trách nhiệm xây dựng thương hiệu và phát triển mối quan hệ khách hàng.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <div class="thumb-container">
                            <img src="{{ asset('img/team_04.jpg') }}" alt="Phạm Thị Diệu">
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
                            <h4>Phạm Thị Diệu</h4>
                            <span>Chuyên Viên Bán Hàng</span>
                            <p>Chị Diệu có nhiều năm kinh nghiệm tư vấn và hỗ trợ khách hàng chọn xe phù hợp.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <div class="thumb-container">
                            <img src="{{ asset('img/team_05.jpg') }}" alt="Hoàng Văn Em">
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
                            <h4>Hoàng Văn Em</h4>
                            <span>Kỹ Thuật Viên</span>
                            <p>Anh Em là chuyên gia về bảo dưỡng và sửa chữa xe máy với hơn 10 năm kinh nghiệm.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <div class="thumb-container">
                            <img src="{{ asset('img/team_06.jpg') }}" alt="Võ Thị Phương">
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
                            <h4>Võ Thị Phương</h4>
                            <span>Quản Lý Showroom</span>
                            <p>Chị Phương quản lý hoạt động showroom và đảm bảo dịch vụ khách hàng tốt nhất.</p>
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
                            <p>Hệ thống quản lý kho xe máy hiện đại, đảm bảo luôn có sẵn các dòng xe hot nhất thị trường.</p>
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
