@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Thêm sản phẩm mới</h1>
        
        <!-- Display Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Ảnh sản phẩm</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <small class="form-text text-muted">Chấp nhận file: JPG, JPEG, PNG, GIF. Kích thước tối đa: 2MB</small>
                
                <!-- Image Preview -->
                <div id="imagePreview" class="mt-3" style="display: none;">
                    <p class="mb-2"><strong>Xem trước:</strong></p>
                    <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Kho</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Còn hàng</option>
                    <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Hết hàng</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="brand_id" class="form-label">Thương hiệu <span class="text-danger">*</span></label>
                <select name="brand_id" class="form-control" required>
                    <option value="">-- Chọn thương hiệu --</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand['id'] ?? '' }}"
                            {{ old('brand_id') == ($brand['id'] ?? '') ? 'selected' : '' }}>
                            {{ $brand['name'] ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] ?? '' }}"
                            {{ old('category_id') == ($category['id'] ?? '') ? 'selected' : '' }}>
                            {{ $category['name'] ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Lưu</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            if (file) {
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File quá lớn! Vui lòng chọn file nhỏ hơn 2MB.');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Định dạng file không hỗ trợ! Vui lòng chọn file JPG, PNG hoặc GIF.');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
@endsection
