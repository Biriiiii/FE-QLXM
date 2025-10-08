<!DOCTYPE html>
<html>

<head>
    <title>Test Image Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .image-test {
            margin: 20px 0;
        }

        .image-test img {
            max-width: 300px;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <h1>Test Hiển Thị Hình Ảnh Từ Backend - Không Cần Token</h1>

    <div class="image-test">
        <h3>1. Test với URL backend storage:</h3>
        <p><strong>URL Backend:</strong> http://127.0.0.1:8000/storage/products/sample.jpg</p>
        <img src="http://127.0.0.1:8000/storage/products/sample.jpg" alt="Test Image Backend"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        <div class="error" style="display:none;">❌ Không tìm thấy hình ảnh từ backend</div>
    </div>

    <div class="image-test">
        <h3>2. Test với hình ảnh mặc định:</h3>
        <p><strong>URL:</strong> {{ asset('img/product_01.jpg') }}</p>
        <img src="{{ asset('img/product_01.jpg') }}" alt="Default Product"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        <div class="error" style="display:none;">❌ Không tìm thấy hình ảnh mặc định</div>
    </div>

    <div class="image-test">
        <h3>3. Cách sử dụng trong code (Updated):</h3>
        <pre><code>
// Trong Controller - Lấy ảnh từ BACKEND:
$apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
$product['image_url'] = !empty($product['image'])
    ? $apiUrl . '/storage/' . $product['image']
    : null;

// Trong Blade view:
&lt;img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}"&gt;
        </code></pre>
    </div>

    <div class="image-test">
        <h3>4. Lưu ý quan trọng:</h3>
        <ul>
            <li>✅ Hình ảnh lưu trong <code>storage/app/public/</code></li>
            <li>✅ Symbolic link: <code>public/storage</code> → <code>storage/app/public</code></li>
            <li>✅ URL truy cập: <code>{{ asset('storage/path/to/image.jpg') }}</code></li>
            <li>✅ Không cần token, không cần đăng nhập</li>
            <li>⚠️ Cần chạy: <code>php artisan storage:link</code></li>
        </ul>
    </div>

    <div class="image-test">
        <h3>5. Kiểm tra đường dẫn storage:</h3>
        <p><strong>Storage path exists:</strong>
            @if (file_exists(storage_path('app/public')))
                <span class="success">✅ Có</span>
            @else
                <span class="error">❌ Không có</span>
            @endif
        </p>
        <p><strong>Public storage link exists:</strong>
            @if (file_exists(public_path('storage')))
                <span class="success">✅ Có</span>
            @else
                <span class="error">❌ Không có</span>
            @endif
        </p>
    </div>

    <hr>
    <p><a href="{{ route('admin.products.index') }}">← Quay lại danh sách sản phẩm</a></p>
</body>

</html>
