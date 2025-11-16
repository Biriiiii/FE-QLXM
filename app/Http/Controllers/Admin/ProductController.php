<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Client\Pool; // 👈 1. Import Pool
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('app.be_api_url'), '/');
    }

    /**
     * HÀM TỐI ƯU: Tạo API call request
     * @return PendingRequest|RedirectResponse
     */
    private function api()
    {
        $token = session('admin_token');
        if (!$token) {
            return redirect()->route('admin.auth.login');
        }
        return Http::withToken($token)
            ->baseUrl($this->apiUrl . '/api')
            ->timeout(15);
    }

    /**
     * Danh sách sản phẩm (ĐÃ SỬA LỖI SEARCH)
     */
    public function index(Request $request)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            // 2. TỐI ƯU: Gửi tất cả query params (page, search, filter...)
            $response = $api->get('/products', $request->query());

            if (!$response->successful()) {
                return view('admin.products.index', [
                    'products' => [],
                    'error' => 'API Error: ' . $response->json('message', $response->status())
                ]);
            }

            $data = $response->json();
            return view('admin.products.index', [
                'products' => $data['data'] ?? [],
                'pagination' => $data['meta'] ?? [],
                'paginationLinks' => $data['links'] ?? [],
            ]);
        } catch (ConnectionException $e) {
            return view('admin.products.index', [
                'products' => [],
                'error' => 'Lỗi kết nối backend: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Form tạo sản phẩm (TỐI ƯU TỐC ĐỘ)
     */
    public function create()
    {
        $apiCheck = $this->api(); // Chỉ để kiểm tra auth
        if ($apiCheck instanceof RedirectResponse) return $apiCheck;

        $token = session('admin_token');
        $apiUrl = $this->apiUrl . '/api';
        $data = ['brands' => [], 'categories' => [], 'error' => null];

        try {
            // 3. TỐI ƯU: Chạy song song 2 request
            $responses = Http::pool(fn(Pool $pool) => [
                $pool->as('brands')->withToken($token)->get($apiUrl . '/brands'),
                $pool->as('categories')->withToken($token)->get($apiUrl . '/categories'),
            ]);

            // Xử lý brands
            if ($responses['brands']->successful()) {
                $data['brands'] = $responses['brands']->json('data', $responses['brands']->json() ?? []);
            } else {
                $data['error'] = 'Lỗi tải Brands: ' . $responses['brands']->status();
            }

            // Xử lý categories
            if ($responses['categories']->successful()) {
                $data['categories'] = $responses['categories']->json('data', $responses['categories']->json() ?? []);
            } else {
                $data['error'] = ($data['error'] ? $data['error'] . ' | ' : '') . 'Lỗi tải Categories: ' . $responses['categories']->status();
            }
        } catch (ConnectionException $e) {
            $data['error'] = 'Lỗi kết nối khi tải dữ liệu: ' . $e->getMessage();
        }

        if ($data['error']) {
            return back()->withErrors($data['error']);
        }

        return view('admin.products.create', [
            'brands' => $data['brands'],
            'categories' => $data['categories']
        ]);
    }

    /**
     * Lưu sản phẩm mới
     */
    public function store(Request $request)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        $http = $api; // $api là Http client đã có token

        if ($request->hasFile('image')) {
            $http = $http->attach(
                'image',
                fopen($request->file('image')->getRealPath(), 'r'),
                $request->file('image')->getClientOriginalName()
            );
        }

        try {
            $response = $http->post('/products', $request->except('image'));

            if ($response->successful()) {
                return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công.');
            }

            // Xử lý validation errors (code cũ của bạn đã tốt)
            if ($response->status() == 422) {
                throw ValidationException::withMessages($response->json('errors', []));
            }

            return back()->withErrors($response->json('message', 'Lỗi không xác định'))->withInput();
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function show($id)
    {
        // Endpoint public, không cần auth
        try {
            $response = Http::baseUrl($this->apiUrl . '/api/client')->get("/products/{$id}");

            if (!$response->successful()) {
                return back()->withErrors('Không lấy được dữ liệu sản phẩm.');
            }
            $product = $response->json('data', $response->json() ?? []);
            return view('admin.products.show', compact('product'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * Form chỉnh sửa sản phẩm (TỐI ƯU TỐC ĐỘ)
     */
    public function edit($id)
    {
        $apiCheck = $this->api(); // Chỉ để kiểm tra auth
        if ($apiCheck instanceof RedirectResponse) return $apiCheck;

        $token = session('admin_token');
        $apiUrl = $this->apiUrl . '/api';

        try {
            // 3. TỐI ƯU: Chạy song song 3 request
            $responses = Http::pool(fn(Pool $pool) => [
                $pool->as('product')->withToken($token)->get($apiUrl . "/products/{$id}"),
                $pool->as('brands')->withToken($token)->get($apiUrl . '/brands'),
                $pool->as('categories')->withToken($token)->get($apiUrl . '/categories'),
            ]);

            // Kiểm tra product
            if (!$responses['product']->successful()) {
                abort(404, 'Không tìm thấy sản phẩm.');
            }
            $product = $responses['product']->json('data', $responses['product']->json() ?? []);

            // Kiểm tra dropdowns (vẫn hiển thị form dù dropdown lỗi)
            $brands = $responses['brands']->successful() ? $responses['brands']->json('data', $responses['brands']->json() ?? []) : [];
            $categories = $responses['categories']->successful() ? $responses['categories']->json('data', $responses['categories']->json() ?? []) : [];

            return view('admin.products.edit', compact('product', 'brands', 'categories'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, $id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        $http = $api;
        $data = $request->except(['image', '_token', '_method']);

        // Luôn thêm _method cho API biết đây là PUT/PATCH
        $data['_method'] = 'PUT';

        if ($request->hasFile('image')) {
            $http = $http->attach(
                'image',
                fopen($request->file('image')->getRealPath(), 'r'),
                $request->file('image')->getClientOriginalName()
            );
        }

        try {
            // Dùng POST để gửi file và _method
            $response = $http->post($this->apiUrl . "/api/products/{$id}", $data);

            if ($response->successful()) {
                return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
            }

            if ($response->status() == 422) {
                throw ValidationException::withMessages($response->json('errors', []));
            }

            return back()->withErrors($response->json('message', 'Lỗi không xác định'))->withInput();
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy($id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->delete("/products/{$id}");

            if (!$response->successful()) {
                return back()->withErrors($response->json('message', 'Lỗi khi xóa'));
            }

            return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công.');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }
}
