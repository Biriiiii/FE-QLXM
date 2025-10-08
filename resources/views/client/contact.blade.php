@extends('layouts.client')

@section('title', 'Liên Hệ - QLXM')
@section('description', 'Liên hệ với QLXM để được tư vấn và hỗ trợ về các dòng xe máy. Hotline: 1900-1234, Email:
    info@qlxm.vn')

@section('content')
    <!-- Page Heading -->
    <div class="page-heading contact-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content">
                        <h4>liên hệ với chúng tôi</h4>
                        <h2>hãy kết nối</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="find-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Thông Tin Liên Hệ</h2>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="map">
                        <div id="googleMap" style="width:100%;height:420px;">
                            <!-- Google Map would go here -->
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.954620029697!2d106.67581831533522!3d10.738014392927166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f38f9ed887b%3A0x14aded5703768989!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaG9hIGjhu41jIFThu7Egbmhpw6puIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENNIC0gQ-G7lSBzbyAz!5e0!3m2!1svi!2s!4v1651655989557!5m2!1svi!2s"
                                width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="left-content">
                        <h4>Thông Tin Cửa Hàng</h4>
                        <p>QLXM - Hệ thống quản lý xe máy hàng đầu Việt Nam. Chúng tôi luôn sẵn sàng hỗ trợ và tư vấn cho
                            khách hàng.</p>
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

    <!-- Contact Details -->
    <div class="send-message">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Gửi Tin Nhắn Cho Chúng Tôi</h2>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="contact-form">
                        <form id="contact" action="#" method="post">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Họ và tên*" required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="text" class="form-control" id="email"
                                            placeholder="Địa chỉ email*" required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <fieldset>
                                        <input name="phone" type="text" class="form-control" id="phone"
                                            placeholder="Số điện thoại*" required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" class="form-control" id="message" placeholder="Nội dung tin nhắn*"
                                            required=""></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="filled-button">Gửi Tin Nhắn</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="accordion">
                        <li>
                            <a>Địa chỉ showroom chính</a>
                            <div class="content">
                                <p>123 Đường Nguyễn Huệ<br>
                                    Quận 1, TP. Hồ Chí Minh<br>
                                    Việt Nam</p>
                            </div>
                        </li>
                        <li>
                            <a>Số điện thoại liên hệ</a>
                            <div class="content">
                                <p>Hotline: <strong>1900-1234</strong><br>
                                    Di động: <strong>0901-234-567</strong><br>
                                    Fax: <strong>(028) 1234-5678</strong></p>
                            </div>
                        </li>
                        <li>
                            <a>Email & Website</a>
                            <div class="content">
                                <p>Email: <strong>info@qlxm.vn</strong><br>
                                    Website: <strong>www.qlxm.vn</strong><br>
                                    Hỗ trợ: <strong>support@qlxm.vn</strong></p>
                            </div>
                        </li>
                        <li>
                            <a>Giờ làm việc</a>
                            <div class="content">
                                <p>Thứ 2 - Thứ 6: <strong>8:00 - 18:00</strong><br>
                                    Thứ 7: <strong>8:00 - 16:00</strong><br>
                                    Chủ nhật: <strong>9:00 - 15:00</strong></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Branch Information -->
    <div class="happy-clients">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Chi Nhánh Trên Toàn Quốc</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="service-item">
                                <div class="icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="down-content">
                                    <h4>Chi Nhánh Hà Nội</h4>
                                    <p>456 Đường Hoàng Diệu<br>
                                        Quận Ba Đình, Hà Nội<br>
                                        ĐT: (024) 1234-5678</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-item">
                                <div class="icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="down-content">
                                    <h4>Chi Nhánh Đà Nẵng</h4>
                                    <p>789 Đường Trần Phú<br>
                                        Quận Hải Châu, Đà Nẵng<br>
                                        ĐT: (0236) 1234-5678</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-item">
                                <div class="icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="down-content">
                                    <h4>Chi Nhánh Cần Thơ</h4>
                                    <p>321 Đường Mậu Thân<br>
                                        Quận Ninh Kiều, Cần Thơ<br>
                                        ĐT: (0292) 1234-5678</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
