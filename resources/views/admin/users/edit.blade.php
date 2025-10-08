@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Sửa người dùng</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                {!! implode('<br>', $errors->all()) !!}
            </div>
        @endif
        <form action="{{ route('admin.users.update', $user['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Tên người dùng</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user['name']) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user['email']) }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu mới (nếu đổi)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
