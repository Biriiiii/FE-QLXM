@extends('layouts.login')@extends('layouts.login')



@section('title', 'Đăng nhập quản trị - QLXM')@section('title', 'Đăng nhập quản trị - QLXM')



@section('content')@section('content')

<h2 class="page-title">Đăng nhập quản trị</h2>
<h2 class="page-title">Đăng nhập quản trị</h2>



@if ($errors->any())
    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="alert alert-danger">

                {{ $errors->first() }} {{ $errors->first() }}

            </div>
        </div>
    @endif
@endif



@if (session('status'))
    @if (session('status'))
        <div class="alert alert-success">
            <div class="alert alert-success">

                {{ session('status') }} {{ session('status') }}

            </div>
        </div>
    @endif
@endif



<!-- Laravel Form --> <!-- Laravel Form -->

<form method="POST" action="{{ route('admin.auth.login') }}">
    <form method="POST" action="{{ route('admin.auth.login') }}">

        @csrf @csrf

        <div class="form-group">
            <div class="form-group">

                <label for="email" class="form-label">Địa chỉ Email</label> <label for="email"
                    class="form-label">Địa chỉ Email</label>

                <input type="email" id="email" name="email" class="form-control"
                    placeholder="Nhập email của bạn" required autofocus <input type="email" id="email"
                    name="email" class="form-control" placeholder="Nhập email của bạn" required
                    value="{{ old('email', 'admin@qlxm.vn') }}"> autofocus value="{{ old('email', 'admin@qlxm.vn') }}">

            </div>
        </div>



        <div class="form-group">
            <div class="form-group">

                <label for="password" class="form-label">Mật khẩu</label> <label for="password" class="form-label">Mật
                    khẩu</label>

                <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu"
                    required <input type="password" id="password" name="password" class="form-control"
                    placeholder="Nhập mật khẩu" required autocomplete="current-password">
                autocomplete="current-password">

            </div>
        </div>



        <div class="form-check">
            <div class="form-check">

                <input type="checkbox" id="remember" name="remember" class="form-check-input"> <input type="checkbox"
                    id="remember" name="remember" class="form-check-input">

                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label> <label class="form-check-label"
                    for="remember">Ghi nhớ đăng nhập</label>

            </div>
        </div>



        <button type="submit" class="btn btn-primary"> <button type="submit" class="btn btn-primary">

                Đăng nhập hệ thống Đăng nhập hệ thống

            </button> </button>

    </form>
</form>

</button>

<div class="additional-links">

    <a href="{{ route('admin.auth.forgot') }}" class="forgot-password">Quên mật khẩu?</a>
    <div style="margin-top: 10px;">

        <br><br> <a href="/admin/dashboard" class="btn btn-secondary btn-sm">

            <a href="/" class="back-to-website">← Quay lại trang chủ</a> Vào Dashboard (Direct)

    </div> </a>

@endsection
</div>

<div class="auth-links">
<a href="#">Quên mật khẩu?</a>
</div>
</div>

<script>
    function doLogin() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const loginBtn = document.getElementById('login-btn');
        const messageDiv = document.getElementById('login-message');

        console.log('Starting login process...');

        // Show loading
        loginBtn.disabled = true;
        loginBtn.textContent = 'Đang đăng nhập...';
        messageDiv.style.display = 'none';

        // Call BE API directly
        fetch('https://be-qlxm-e11819409fff.herokuapp.com/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('API Response:', data);

                if (data.token) {
                    // Success! Store token and redirect
                    localStorage.setItem('admin_token', data.token);
                    localStorage.setItem('admin_user', JSON.stringify(data.user));

                    messageDiv.className = 'alert alert-success';
                    messageDiv.innerHTML =
                        'Đăng nhập thành công! <a href="/admin/dashboard" style="color: white; text-decoration: underline;">Click here if not redirected</a>';
                    messageDiv.style.display = 'block';

                    console.log('Login successful, redirecting...');

                    // Try multiple redirect methods
                    console.log('Attempting redirect...');

                    // Method 1: Redirect to static HTML page first
                    try {
                        window.location.href = '/redirect-dashboard.html';
                    } catch (e) {
                        console.error('HTML redirect failed:', e);

                        // Method 2: Direct dashboard
                        try {
                            window.open('/admin/dashboard', '_self');
                        } catch (e2) {
                            console.error('Window.open failed:', e2);

                            // Method 3: Force location change
                            document.location.href = '/admin/dashboard';
                        }
                    }
                } else {
                    // Login failed
                    messageDiv.className = 'alert alert-danger';
                    messageDiv.textContent = data.message || 'Đăng nhập thất bại!';
                    messageDiv.style.display = 'block';

                    loginBtn.disabled = false;
                    loginBtn.textContent = 'Đăng nhập hệ thống';
                }
            })
            .catch(error => {
                console.error('Login error:', error);
                messageDiv.className = 'alert alert-danger';
                messageDiv.textContent = 'Lỗi kết nối! Vui lòng thử lại.';
                messageDiv.style.display = 'block';

                loginBtn.disabled = false;
                loginBtn.textContent = 'Đăng nhập hệ thống';
            });
    }

    // Handle Enter key
    document.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            doLogin();
        }
    });
</script>
@endsection
