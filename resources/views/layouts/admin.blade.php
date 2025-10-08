<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />
    <title>@yield('title', 'QLXM - Quản Lý Xe Máy')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style id="theme-style">
        :root {
            --bg-main: #f8f9fa;
            --bg-sidebar: #2c3e50;
            --text-main: #2c3e50;
            --text-light: #ecf0f1;
            --sidebar-active: #ed1b24;
            --sidebar-hover: #34495e;
            --sidebar-header: #bdc3c7;
            --card-bg: #ffffff;
            --table-bg: #ffffff;
            --table-border: #dee2e6;
            --btn-primary: #ed1b24;
            --btn-success: #27ae60;
            --btn-warning: #f39c12;
            --btn-danger: #e74c3c;
            --footer-bg: #2c3e50;
            --brand: #ed1b24;
            --border-color: #dee2e6;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--bg-main) !important;
            color: var(--text-main) !important;
        }

        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background: var(--bg-sidebar);
            color: var(--text-light);
            transition: all 0.3s;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            background: rgba(0,0,0,0.1);
            display: block;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand span {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-light);
        }

        .sidebar-brand:hover {
            text-decoration: none;
        }

        .sidebar-nav {
            padding: 0;
            list-style: none;
        }

        .sidebar-header {
            padding: 1rem 1rem 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--sidebar-header);
            letter-spacing: 1px;
        }

        .sidebar-item {
            position: relative;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            background: rgba(108, 117, 125, 0.3);
            color: #fff;
            text-decoration: none;
            border-left-color: rgba(237, 27, 36, 0.5);
        }

        .sidebar-link i {
            margin-right: 0.75rem;
            width: 16px;
            text-align: center;
        }

        .sidebar-item.active .sidebar-link {
            background: var(--sidebar-active);
            border-left-color: #fff;
            color: #fff;
        }

        .sidebar-item.active .sidebar-link:hover {
            background: #c41e3a;
        }

        /* Main Content */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: #fff !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .content {
            flex: 1;
            padding: 2rem;
        }

        /* Button Styling */
        .btn-primary {
            background: var(--btn-primary) !important;
            border-color: var(--btn-primary) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #c41e3a !important;
            border-color: #c41e3a !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(196, 30, 58, 0.3);
        }

        .btn-success {
            background: var(--btn-success) !important;
            border-color: var(--btn-success) !important;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #229954 !important;
            border-color: #229954 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(34, 153, 84, 0.3);
        }

        .btn-warning {
            background: var(--btn-warning) !important;
            border-color: var(--btn-warning) !important;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background: #e67e22 !important;
            border-color: #e67e22 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(230, 126, 34, 0.3);
        }

        .btn-danger {
            background: var(--btn-danger) !important;
            border-color: var(--btn-danger) !important;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #c0392b !important;
            border-color: #c0392b !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(192, 57, 43, 0.3);
        }

        .btn:active {
            transform: translateY(0) !important;
        }

        /* Small button styling */
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 6px;
        }

        .btn-sm:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 3px 6px rgba(0,0,0,0.15) !important;
        }

        /* Card Styling */
        .card {
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .card-header {  
            background: #f8f9fa !important;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
        }

        /* Table Styling */
        .table {
            background: var(--table-bg) !important;
            color: var(--text-main) !important;
        }

        .table th {
            background: #f8f9fa !important;
            color: var(--text-main) !important;
            font-weight: 600;
            border-color: var(--table-border) !important;
        }

        .table td {
            border-color: var(--table-border) !important;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .table tbody tr:hover {
            background: rgba(233, 236, 239, 0.6) !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0,0,0,0.08);
            border-left: 3px solid rgba(237, 27, 36, 0.4);
        }

        .table tbody tr:hover td {
            color: #2c3e50 !important;
        }

        /* Footer */
        .footer {
            background: var(--footer-bg) !important;
            color: var(--text-light) !important;
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--border-color);
        }

        /* Dashboard Stats Cards */
        .stat-card {
            background: linear-gradient(135deg, var(--btn-primary), #c41e3a);
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 8px rgba(237, 27, 36, 0.2);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(237, 27, 36, 0.3);
        }

        .stat-card.green {
            background: linear-gradient(135deg, var(--btn-success), #229954);
            box-shadow: 0 4px 8px rgba(39, 174, 96, 0.2);
        }

        .stat-card.green:hover {
            box-shadow: 0 8px 16px rgba(39, 174, 96, 0.3);
        }

        .stat-card.orange {
            background: linear-gradient(135deg, var(--btn-warning), #e67e22);
            box-shadow: 0 4px 8px rgba(243, 156, 18, 0.2);
        }

        .stat-card.orange:hover {
            box-shadow: 0 8px 16px rgba(243, 156, 18, 0.3);
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #3498db, #2980b9);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.2);
        }

        .stat-card.blue:hover {
            box-shadow: 0 8px 16px rgba(52, 152, 219, 0.3);
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-main) !important;
            font-weight: 600;
        }

        .fw-bold {
            color: var(--text-main) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                min-width: 200px;
                max-width: 200px;
            }
            
            .content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-content">
                <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
                    <span class="align-middle">QLXM <span style="color: var(--brand);">SYSTEM</span></span>
                </a>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">Menu</li>
                    <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i>
                            <span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.brands.index') }}">
                            <i class="bi bi-tag"></i>
                            <span class="align-middle">Thương hiệu</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.categories.index') }}">
                            <i class="bi bi-grid-3x3-gap"></i>
                            <span class="align-middle">Danh mục</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box"></i>
                            <span class="align-middle">Sản phẩm</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.customers.index') }}">
                            <i class="bi bi-people"></i>
                            <span class="align-middle">Khách hàng</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-cart"></i>
                            <span class="align-middle">Đơn hàng</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                            <i class="bi bi-person-gear"></i>
                            <span class="align-middle">Nhân viên</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Main -->
        <div class="main">
            <!-- Navbar -->
            <nav class="navbar navbar-expand">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h4>
                </div>
                <div class="ms-auto">
                    <form action="{{ route('admin.auth.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </nav>
            <!-- Content -->
            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </main>
            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-12 text-center">
                            <p class="mb-0">
                                <strong>QLXM System © {{ date('Y') }}</strong> - Hệ thống quản lý xe máy
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced hover effects for sidebar items
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                link.style.transition = 'all 0.3s ease';
                
                link.addEventListener('mouseenter', function() {
                    if (!this.closest('.sidebar-item').classList.contains('active')) {
                        this.style.transform = 'translateX(5px)';
                        this.style.background = 'rgba(108, 117, 125, 0.3)';
                    }
                });
                
                link.addEventListener('mouseleave', function() {
                    if (!this.closest('.sidebar-item').classList.contains('active')) {
                        this.style.transform = 'translateX(0)';
                        this.style.background = '';
                    }
                });
            });

            // Enhanced button hover effects
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.3s ease';
                });
            });

            // Enhanced table row hover effects
            const tableRows = document.querySelectorAll('.table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.3s ease';
                });
            });

            // Add loading state to forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.classList.contains('no-loading')) {
                        submitBtn.disabled = true;
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Đang xử lý...';
                        submitBtn.classList.add('btn-secondary');
                        submitBtn.classList.remove('btn-primary', 'btn-success', 'btn-warning', 'btn-danger');
                        
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                            submitBtn.classList.remove('btn-secondary');
                        }, 3000);
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>

</html>
