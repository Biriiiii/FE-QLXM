@extends('layouts.admin')

@section('title', 'Sửa Danh mục')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Sửa Danh mục</h1>

        {{-- Thông báo --}}
        @include('admin.components.alert')

        <form action="{{ route('admin.categories.update', $category['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category['name'] ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                    rows="3">{{ old('description', $category['description'] ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
