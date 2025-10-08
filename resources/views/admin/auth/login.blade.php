@extends('layouts.login')

@section('title', 'Đăng nhập quản trị - QLXM')

@section('content')
    <h2 class="page-title text-center mb-4">Đăng nhập quản trị</h2>

    {{-- Thông báo lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Thông báo trạng thái --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Form đăng nhập --}}
    <form id="login-form" onsubmit="event.preventDefault(); doLogin();">
        @csrf

        <div class="form-group mb-3">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email của bạn" required
                autofocus value="{{ old('email', 'admin@qlxm.vn') }}">
        </div>

        <div class="form-group mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required
                autocomplete="current-password">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" id="remember" name="remember" class="form-check-input">
            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
        </div>

        <div id="login-message" style="display:none;"></div>

        <button id="login-btn" type="submit" class="btn btn-primary w-100">
            Đăng nhập hệ thống
        </button>
    </form>

    <div class="additional-links text-center mt-3">
        <a href="{{ route('admin.auth.forgot') }}" class="forgot-password">Quên mật khẩu?</a>
        <br>
        <a href="/" class="back-to-website mt-2 d-block">← Quay lại trang chủ</a>
    </div>

    <script>
        function doLogin() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const loginBtn = document.getElementById('login-btn');
            const messageDiv = document.getElementById('login-message');

            console.log('Bắt đầu đăng nhập...');

            loginBtn.disabled = true;
            loginBtn.textContent = 'Đang đăng nhập...';
            messageDiv.style.display = 'none';

            fetch('https://be-qlxm-e11819409fff.herokuapp.com/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email,
                        password
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Kết quả API:', data);
                    if (data.token) {
                        localStorage.setItem('admin_token', data.token);
                        localStorage.setItem('admin_user', JSON.stringify(data.user));

                        messageDiv.className = 'alert alert-success';
                        messageDiv.innerHTML =
                            'Đăng nhập thành công! <a href="/admin/dashboard" style="color:white;text-decoration:underline;">Click nếu không tự chuyển</a>';
                        messageDiv.style.display = 'block';

                        setTimeout(() => window.location.href = '/admin/dashboard', 1000);
                    } else {
                        messageDiv.className = 'alert alert-danger';
                        messageDiv.textContent = data.message || 'Đăng nhập thất bại!';
                        messageDiv.style.display = 'block';
                        loginBtn.disabled = false;
                        loginBtn.textContent = 'Đăng nhập hệ thống';
                    }
                })
                .catch(error => {
                    console.error('Lỗi đăng nhập:', error);
                    messageDiv.className = 'alert alert-danger';
                    messageDiv.textContent = 'Lỗi kết nối! Vui lòng thử lại.';
                    messageDiv.style.display = 'block';
                    loginBtn.disabled = false;
                    loginBtn.textContent = 'Đăng nhập hệ thống';
                });
        }

        // Bấm Enter để đăng nhập
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') doLogin();
        });
    </script>
@endsection
