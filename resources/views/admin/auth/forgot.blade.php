@extends('layouts.login')

@section('title', 'Quên mật khẩu - QLXM')

@section('content')
    <h2 class="page-title">Quên mật khẩu</h2>
    
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
    
    <form method="POST" action="{{ route('admin.auth.forgot') }}">
        @csrf
        <div class="form-group">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   class="form-control" 
                   placeholder="Nhập email đã đăng ký"
                   required 
                   autofocus
                   value="{{ old('email') }}">
        </div>
        
        <button type="submit" class="btn btn-primary">
            Gửi yêu cầu đặt lại mật khẩu
        </button>
        
        <div class="auth-links">
            <a href="{{ route('admin.auth.login') }}">Quay lại đăng nhập</a>
        </div>
    </form>
@endsection
