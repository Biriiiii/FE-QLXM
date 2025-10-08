@extends('layouts.login')

@section('title', 'Đăng nhập quản trị - QLXM')

@section('content')
    <h2 class="page-title">Đăng nhập quản trị</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.auth.login') }}">
        @csrf

        {{-- Debug info --}}
        <div style="display:none;">
            CSRF Token: {{ csrf_token() }}<br>
            Session ID: {{ session()->getId() }}<br>
            APP_URL: {{ env('APP_URL') }}<br>
            Current URL: {{ url()->current() }}
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email của bạn"
                required autofocus value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>

        <div class="form-check">
            <input type="checkbox" name="remember" id="remember" class="form-check-input">
            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
        </div>

        <button type="submit" class="btn btn-primary">

            Đăng nhập hệ thống
        </button>

        <div class="auth-links">
            <a href="{{ route('admin.auth.forgot') }}">Quên mật khẩu?</a>
        </div>
    </form>

    {{-- Test form without CSRF --}}
    <hr style="margin: 2rem 0;">
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 0.5rem;">
        <h4>🧪 Test Login (No CSRF)</h4>
        <form method="POST" action="{{ route('admin.auth.login.test') }}">
            <div class="form-group">
                <input type="email" name="email" class="form-control" value="admin@qlxm.vn" placeholder="Email"
                    required>
            </div>
            <div class="form-group" style="margin-top: 1rem;">
                <input type="password" name="password" class="form-control" value="admin123" placeholder="Password"
                    required>
            </div>
            <button type="submit" class="btn btn-success" style="margin-top: 1rem;">Test Login (No CSRF)</button>
        </form>
    </div>

    <script>
        // Debug CSRF token
        console.log('CSRF Token:', document.querySelector('input[name="_token"]')?.value);
        console.log('Current URL:', window.location.href);
        console.log('Form Action:', document.querySelector('form')?.action);
    </script>
@endsection
