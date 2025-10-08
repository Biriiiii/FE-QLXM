@extends('layouts.admin')

@section('title', 'Sửa Thương hiệu')

@section('content')
    <div class="container py-4">
        <h1 class="fw-bold text-center mb-4" style="color:#fff;">Sửa thương hiệu</h1>
        <form action="{{ route('admin.brands.update', $brand['id']) }}" method="POST" enctype="multipart/form-data"
            class="card p-4" style="background:#23262f; color:#eaeaea; border-radius:1rem;">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Tên thương hiệu</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $brand['name'] ?? '' }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Quốc gia</label>
                <input type="text" name="country" id="country" class="form-control"
                    value="{{ $brand['country'] ?? '' }}">
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                @if (!empty($brand['logo']))
                    <img src="{{ config('app.be_api_url') }}/storage/{{ $brand['logo'] }}" alt="{{ $brand['name'] }}"
                        style="width:60px; height:60px; object-fit:cover; border-radius:4px; margin-bottom:8px;">
                @endif
                <input type="file" name="logo" id="logo" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ $brand['description'] ?? '' }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary ms-2">Quay lại</a>
        </form>
    </div>
@endsection
