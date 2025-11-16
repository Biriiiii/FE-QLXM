<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    protected $apiUrl;

    /**
     * Dùng Constructor để thiết lập API URL một lần duy nhất
     */
    public function __construct()
    {
        // Lấy API URL từ config và dọn dẹp (bỏ dấu / ở cuối)
        $this->apiUrl = rtrim(config('app.be_api_url'), '/');
    }

    /**
     * HÀM TỐI ƯU: Tạo API call request với token và xử lý lỗi
     *
     * @return PendingRequest|RedirectResponse
     */
    private function api()
    {
        $token = session('admin_token');

        // Tự động kiểm tra auth ở một nơi duy nhất
        if (!$token) {
            return redirect()->route('admin.auth.login');
        }

        // Trả về Http client đã đính kèm token và base URL
        return Http::withToken($token)
            ->baseUrl($this->apiUrl . '/api')
            ->timeout(15); // Đặt timeout chung
    }

    /**
     * Danh sách categories (index)
     */
    public function index(Request $request)
    {
        // Nếu api() trả về redirect, thì return luôn
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            // Lấy tất cả query params (page, search, per_page...)
            $response = $api->get('/categories', $request->query());

            if (!$response->successful()) {
                return view('admin.categories.index', [
                    'categories' => [],
                    'error' => 'API Error: ' . $response->json('message', $response->status())
                ]);
            }

            $data = $response->json();

            // Xử lý cả trường hợp trả về có phân trang (data, meta, links)
            // Lẫn trường hợp trả về mảng trực tiếp (cho API đơn giản)
            $categories = $data['data'] ?? ($data ?? []);

            return view('admin.categories.index', [
                'categories' => $categories,
                'pagination' => $data['meta'] ?? [],
                'paginationLinks' => $data['links'] ?? [],
            ]);
        } catch (ConnectionException $e) {
            return view('admin.categories.index', [
                'categories' => [],
                'error' => 'Lỗi kết nối backend: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Form thêm mới
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Lưu category mới (store)
     */
    public function store(Request $request)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->post('/categories', $request->all());

            // TỐI ƯU XỬ LÝ LỖI
            if (!$response->successful()) {
                // Lấy lỗi cụ thể từ BE (ví dụ: Tên không được để trống)
                $errorMessage = $response->json('message', 'Lỗi không xác định từ API');
                return back()->withErrors($errorMessage)->withInput();
            }

            return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Form sửa category (edit)
     */
    public function edit($id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->get("/categories/{$id}");

            // 404 Not Found
            if (!$response->successful()) {
                abort(404, 'Không tìm thấy danh mục này trên hệ thống backend.');
            }

            $category = $response->json('data', []);
            return view('admin.categories.edit', compact('category'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật category (update)
     */
    public function update(Request $request, $id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->put("/categories/{$id}", $request->all());

            if (!$response->successful()) {
                $errorMessage = $response->json('message', 'Lỗi không xác định từ API');
                return back()->withErrors($errorMessage)->withInput();
            }

            return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Xóa category (destroy)
     */
    public function destroy($id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->delete("/categories/{$id}");

            if (!$response->successful()) {
                $errorMessage = $response->json('message', 'Lỗi không xác định từ API');
                return back()->withErrors($errorMessage);
            }

            return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }
}
