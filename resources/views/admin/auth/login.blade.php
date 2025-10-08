@extends('layouts.login')

@section('title', 'Đăng nhập quản trị - QLXM')

@section('content')
    <h2 class="page-title">Đăng nhập quản trị</h2>

    <div id="login-message" class="alert" style="display: none;"></div>

    <!-- NO FORM SUBMISSION - Only JavaScript -->
    <div>
        <div class="form-group">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input type="email" id="email" class="form-control" placeholder="Nhập email của bạn" required autofocus
                value="admin@qlxm.vn">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" id="password" class="form-control" placeholder="Nhập mật khẩu" value="admin123" required
                autocomplete="current-password">
        </div>

        <div class="form-check">
            <input type="checkbox" id="remember" class="form-check-input">
            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
        </div>

        <button type="button" id="login-btn" class="btn btn-primary" onclick="doLogin()">
            Đăng nhập hệ thống
        </button>

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

                        // Method 1: Immediate redirect
                        try {
                            window.location.href = '/admin/dashboard';
                        } catch (e) {
                            console.error('Method 1 failed:', e);

                            // Method 2: Replace
                            try {
                                window.location.replace('/admin/dashboard');
                            } catch (e2) {
                                console.error('Method 2 failed:', e2);

                                // Method 3: Assign
                                window.location = '/admin/dashboard';
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
