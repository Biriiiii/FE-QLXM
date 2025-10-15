<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('description', 'Hệ thống quản lý xe máy chuyên nghiệp')">
    <meta name="author" content="QLXM">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">

    <title>@yield('title', 'QLXM - Quản Lý Xe Máy')</title>

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="/css/fontawesome.css">
    <link rel="stylesheet" href="/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="/css/owl.css">

    @stack('styles')
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('client.home') }}">
                    <h2>QLXM <em>System</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item {{ request()->routeIs('client.home') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('client.home') }}">Trang chủ
                                @if (request()->routeIs('client.home'))
                                    <span class="sr-only">(current)</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('client.motorcycles*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('client.motorcycles') }}">Xe Máy</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('client.brands*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('client.brands') }}">Hãng Xe</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('client.about') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('client.about') }}">Về Chúng Tôi</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('client.contact') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('client.contact') }}">Liên Hệ</a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Đăng Nhập</a>
                            </li>
                        @endauth
                        <!-- Nút giỏ hàng -->
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('client.cart.index') }}">
                                <i class="fa fa-shopping-cart"></i> Giỏ hàng
                                <span id="cart-count-badge" class="badge badge-danger position-absolute"
                                    style="top:2px;right:-18px;display:none;">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Content -->
    @yield('content')

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <p>Copyright &copy; {{ date('Y') }} QLXM - Quản Lý Xe Máy
                            - Thiết kế: <a rel="nofollow noopener" href="#" target="_blank">QLXM Team</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="/js/custom.js"></script>
    <script src="/js/owl.js"></script>
    <script src="/js/slick.js"></script>
    <script src="/js/isotope.js"></script>
    <script src="/js/accordions.js"></script>

    <script language="text/Javascript">
        cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
        function clearField(t) { //declaring the array outside of the
            if (!cleared[t.id]) { // function makes it static and global
                cleared[t.id] = 1; // you could use true and false, but that's more typing
                t.value = ''; // with more chance of typos
                t.style.color = '#fff';
            }
        }

        // Emergency fix - Hide preloader if jQuery fails
        window.addEventListener('load', function() {
            setTimeout(function() {
                var preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.opacity = '0';
                    preloader.style.visibility = 'hidden';
                    preloader.style.display = 'none';
                }
            }, 2000);
        });
        // Hiển thị số lượng sản phẩm trong giỏ hàng (FE, sessionStorage/cookie)
        function getCartCount() {
            // Ưu tiên sessionStorage, fallback cookie
            var count = 0;
            if (window.sessionStorage && sessionStorage.getItem('cart_count')) {
                count = parseInt(sessionStorage.getItem('cart_count')) || 0;
            } else {
                // Đọc cookie cart nếu có
                var match = document.cookie.match(/cart=([^;]+)/);
                if (match) {
                    try {
                        var cart = JSON.parse(decodeURIComponent(match[1]));
                        count = Array.isArray(cart) ? cart.length : 0;
                    } catch (e) {}
                }
            }
            return count;
        }

        function updateCartBadge() {
            var count = getCartCount();
            var badge = document.getElementById('cart-count-badge');
            if (badge) {
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = '';
                } else {
                    badge.style.display = 'none';
                }
            }
        }
        document.addEventListener('DOMContentLoaded', updateCartBadge);
    </script>

    @stack('scripts')

</body>

</html>
