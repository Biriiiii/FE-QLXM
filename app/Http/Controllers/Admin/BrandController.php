<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse; // 👈 Đã thêm

class BrandController extends Controller
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
     * Hàm này tự động kiểm tra session, thêm token, và xử lý lỗi kết nối.
     *
     * @return PendingRequest|RedirectResponse
     */
    private function api()
    {
        $token = session('admin_token');

        // Tự động kiểm tra auth ở một nơi duy nhất
        if (!$token) {
            // Dùng abort(401) nếu là API request, ở đây ta redirect
            return redirect()->route('admin.auth.login');
        }

        // Trả về Http client đã đính kèm token và base URL
        return Http::withToken($token)
            ->baseUrl($this->apiUrl . '/api')
            ->timeout(15); // Đặt timeout chung
    }

    /**
     * Danh sách brands (index)
     */
    public function index(Request $request)
    {
        // Nếu api() trả về redirect, thì return luôn
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            // Lấy tất cả query params (page, search, per_page...)
            $response = $api->get('/brands', $request->query());

            if (!$response->successful()) {
                return view('admin.brands.index', [
                    'brands' => [],
                    'error' => 'API Error: ' . $response->json('message', $response->status())
                ]);
            }

            $data = $response->json();
            return view('admin.brands.index', [
                'brands' => $data['data'] ?? [],
                'pagination' => $data['meta'] ?? [],
                'paginationLinks' => $data['links'] ?? [],
            ]);
        } catch (ConnectionException $e) {
            return view('admin.brands.index', [
                'brands' => [],
                'error' => 'Lỗi kết nối backend: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Form thêm mới
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Lưu brand mới (store)
     */
    public function store(Request $request)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        $http = $api; // $api đã có token

        // Xử lý file upload
        if ($request->hasFile('logo')) {
            $http = $http->attach(
                'logo',
                fopen($request->file('logo')->getRealPath(), 'r'),
                $request->file('logo')->getClientOriginalName()
            );
        }

        try {
            // Gửi dữ liệu (dùng POST vì có file)
            $response = $http->post('/brands', $request->except('logo'));

            // TỐI ƯU XỬ LÝ LỖI
            if (!$response->successful()) {
                // Lấy lỗi cụ thể từ BE (ví dụ: Tên không được để trống)
                $errorMessage = $response->json('message', 'Lỗi không xác định từ API');
                return back()->withErrors($errorMessage)->withInput();
            }

            return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Form sửa brand (edit)
     */
    public function edit($id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->get("/brands/{$id}");

            // 404 Not Found
            if (!$response->successful()) {
                abort(404, 'Không tìm thấy thương hiệu này trên hệ thống backend.');
            }

            $brand = $response->json('data', []);
            return view('admin.brands.edit', compact('brand'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật brand (update)
     */
    public function update(Request $request, $id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        $http = $api; // $api đã có token

        // Xử lý file upload
        if ($request->hasFile('logo')) {
            $http = $http->attach(
                'logo',
                fopen($request->file('logo')->getRealPath(), 'r'),
                $request->file('logo')->getClientOriginalName()
            );
        }

        try {
            // Quan trọng: Update có file phải dùng POST (do hạn chế của PUT/PATCH với multipart)
            // Backend API phải hỗ trợ POST /brands/{id} để update
            $response = $http->post("/brands/{$id}", $request->except(['logo', '_method']));

            if (!$response->successful()) {
                $errorMessage = $response->json('message', 'Lỗi không xác định từ API');
                return back()->withErrors($errorMessage)->withInput();
            }

            return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Xóa brand (destroy)
     */
    public function destroy($id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->delete("/brands/{$id}");

            if (!$response->successful()) {
                $errorMessage = $response->json('message', 'Lỗi không xác định từ API');
                return back()->withErrors($errorMessage);
            }

            return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công!');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }
}
