<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $apiUrl;
    protected $token;

    public function __construct()
    {
        $this->apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $this->token = session('admin_token') ?? null;
    }

    /**
     * Danh sách sản phẩm
     */
    public function index(Request $request)
    {
        if (!$this->token) {
            return redirect()->route('admin.auth.login');
        }
        if ($request->filled('search')) {
            $params['search'] = $request->get('search');
        }
        try {
            $page = $request->query('page', 1);
            $http = Http::timeout(10);
            if ($this->token) {
                $http = $http->withToken($this->token);
            }
            $response = $http->get($this->apiUrl . '/api/products', [
                'page' => $page
            ]);

            if (!$response->successful()) {
                return view('admin.products.index', [
                    'products' => [],
                    'pagination' => [],
                    'error' => 'Không thể kết nối đến API backend. Status: ' . $response->status()
                ]);
            }

            $responseData = $response->json();
            $products = $responseData['data'] ?? [];
            $pagination = $responseData['meta'] ?? [];
            $paginationLinks = $responseData['links'] ?? [];

            foreach ($products as &$product) {
                if (empty($product['image_url']) && !empty($product['image'])) {
                    $product['image_url'] = $this->apiUrl . '/storage/' . $product['image'];
                }
            }

            return view('admin.products.index', compact('products', 'pagination', 'paginationLinks'));
        } catch (\Exception $e) {
            return view('admin.products.index', [
                'products' => [],
                'pagination' => [],
                'paginationLinks' => [],
                'error' => 'Lỗi kết nối backend: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Form tạo sản phẩm
     */
    public function create()
    {
        if (!$this->token) {
            return redirect()->route('admin.auth.login');
        }

        $brands = Http::withToken($this->token)->get($this->apiUrl . '/api/brands')->json('data') ?? [];
        $categories = Http::withToken($this->token)->get($this->apiUrl . '/api/categories')->json('data') ?? [];

        return view('admin.products.create', compact('brands', 'categories'));
    }

    /**
     * Lưu sản phẩm mới
     */
    public function store(Request $request)
    {
        if (!$this->token) {
            return redirect()->route('admin.auth.login');
        }

        $data = $request->except('image');
        $http = Http::withToken($this->token);

        if ($request->hasFile('image')) {
            $http = $http->attach(
                'image',
                fopen($request->file('image')->getRealPath(), 'r'),
                $request->file('image')->getClientOriginalName()
            );
        }

        $response = $http->post($this->apiUrl . '/api/products', $data);

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công.');
        }

        return back()->withErrors($response->json('message') ?? 'Lỗi khi tạo sản phẩm');
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function show($id)
    {
        // Sử dụng endpoint public client/products
        $response = Http::get($this->apiUrl . "/api/client/products/{$id}");

        if (!$response->successful()) {
            return back()->withErrors('Không lấy được dữ liệu sản phẩm từ API.');
        }

        $product = $response->json('data') ?? $response->json();

        // Thêm image_url từ backend
        if (!empty($product['image'])) {
            $product['image_url'] = $this->apiUrl . '/storage/' . $product['image'];
        }

        return view('admin.products.show', compact('product'));
    }

    /**
     * Form chỉnh sửa sản phẩm
     */
    public function edit($id)
    {
        if (!$this->token) {
            return redirect()->route('admin.auth.login');
        }

        $response = Http::withToken($this->token)->get($this->apiUrl . "/api/products/{$id}");

        if (!$response->successful()) {
            return back()->withErrors('Không lấy được dữ liệu sản phẩm từ API.');
        }

        $product = $response->json('data') ?? $response->json();

        $brands = Http::withToken($this->token)->get($this->apiUrl . '/api/brands')->json('data') ?? [];
        $categories = Http::withToken($this->token)->get($this->apiUrl . '/api/categories')->json('data') ?? [];

        return view('admin.products.edit', compact('product', 'brands', 'categories'));
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, $id)
    {
        if (!$this->token) {
            return redirect()->route('admin.auth.login');
        }

        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => (float)$request->input('price'),
            'stock' => (int)$request->input('stock'),
            'status' => $request->input('status'),
            'brand_id' => (int)$request->input('brand_id'),
            'category_id' => (int)$request->input('category_id'),
            '_method' => 'PUT',
        ];

        $http = Http::withToken($this->token);

        if ($request->hasFile('image')) {
            $http = $http->attach(
                'image',
                fopen($request->file('image')->getRealPath(), 'r'),
                $request->file('image')->getClientOriginalName()
            );
        }

        $response = $http->post($this->apiUrl . "/api/products/{$id}", $data);

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
        }

        return back()->withErrors($response->json('message') ?? 'Lỗi khi cập nhật sản phẩm');
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy($id)
    {
        if (!$this->token) {
            return redirect()->route('admin.auth.login');
        }

        $response = Http::withToken($this->token)->delete($this->apiUrl . "/api/products/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công.');
        }

        return back()->withErrors($response->json('message') ?? 'Lỗi khi xóa sản phẩm');
    }
}
