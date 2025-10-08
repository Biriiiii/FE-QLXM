<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('description', 'Đăng nhập hệ thống quản lý xe máy')">
    <meta name="author" content="QLXM">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>@yield('title', 'Đăng nhập - QLXM')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo-sixteen.css') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #232323 0%, #2c2c2c 50%, #1a1a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .brand-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .brand-logo .system-text {
            color: #ed1b24;
        }

        .brand-subtitle {
            color: #666;
            font-size: 0.9rem;
            font-weight: 300;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            outline: none;
            border-color: #ed1b24;
            box-shadow: 0 0 0 3px rgba(237, 27, 36, 0.1);
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .form-check-input {
            margin-right: 10px;
            accent-color: #ed1b24;
        }

        .form-check-label {
            color: #666;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ed1b24 0%, #c41e3a 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(237, 27, 36, 0.4);
            background: linear-gradient(135deg, #c41e3a 0%, #a01627 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .auth-links {
            text-align: center;
            margin-top: 20px;
        }

        .auth-links a {
            color: #ed1b24;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .auth-links a:hover {
            color: #c41e3a;
            text-decoration: underline;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: none;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #ed1b24;
        }

        .alert-success {
            background: #e8f5e8;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            background: rgba(0, 0, 0, 0.3);
            padding: 10px 15px;
            border-radius: 25px;
            backdrop-filter: blur(10px);
        }

        .back-to-home:hover {
            color: white;
            text-decoration: none;
            background: rgba(237, 27, 36, 0.8);
        }

        .back-to-home i {
            margin-right: 5px;
        }

        /* Loading Animation */
        .btn-loading {
            position: relative;
            color: transparent;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
                margin: 10px;
            }

            .brand-logo {
                font-size: 2rem;
            }
        }

        /* Page Title */
        .page-title {
            text-align: center;
            color: #333;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 30px;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Back to Home Link -->
    <a href="{{ route('client.home') }}" class="back-to-home">
        <i class="fa fa-arrow-left"></i>
        Về trang chủ
    </a>

    <div class="login-container">
        <div class="login-card">
            <!-- Brand Section -->
            <div class="brand-section">
                <div class="brand-logo">
                    QLXM <span class="system-text">SYSTEM</span>
                </div>
                <div class="brand-subtitle">Hệ thống quản lý xe máy</div>
            </div>

            <!-- Content -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Form Enhancement
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading state to form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('btn-loading');
                        submitBtn.disabled = true;
                        
                        // Reset after 10 seconds (fallback)
                        setTimeout(() => {
                            submitBtn.classList.remove('btn-loading');
                            submitBtn.disabled = false;
                        }, 10000);
                    }
                });
            }

            // Enhanced input focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
        });
    </script>

    @stack('scripts')

</body>

</html>