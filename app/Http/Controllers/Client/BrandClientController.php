<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\PendingRequest; // 👈 1. Import
use Illuminate\Http\Client\ConnectionException; // 👈 2. Import
use Illuminate\Http\Client\Pool; // 👈 3. Import

class BrandClientController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('app.be_api_url'), '/');
    }

    /**
     * TỐI ƯU: Helper tạo API call (Client-side)
     */
    private function clientApi(): PendingRequest
    {
        return Http::baseUrl($this->apiUrl . '/api/client')
            ->timeout(10);
    }

    /**
     * TỐI ƯU: Gửi tất cả query params (page, search...)
     */
    public function index(Request $request)
    {
        try {
            // Dùng helper và gửi tất cả $request->query()
            $response = $this->clientApi()->get('/brands', $request->query());

            $brands = [];
            $pagination = null;
            $paginationLinks = null;

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['data'])) {
                    $brands = $data['data'];
                    $pagination = $data['meta'] ?? null;
                    $paginationLinks = $data['links'] ?? null;
                } elseif (is_array($data)) {
                    $brands = $data; // Xử lý API trả về mảng trực tiếp
                }
            } else {
                Log::error('Brand API Error: ' . $response->status());
            }

            return view('client.brands.index', compact('brands', 'pagination', 'paginationLinks'));
        } catch (ConnectionException $e) { // Bắt lỗi cụ thể
            Log::error('BrandClientController Error: ' . $e->getMessage());
            return view('client.brands.index', [
                'brands' => [],
                'pagination' => null,
                'paginationLinks' => null,
                'error' => 'Không thể tải dữ liệu từ server'
            ]);
        }
    }

    /**
     * 4. TỐI ƯU TỐC ĐỘ: Dùng Http::pool() chạy song song
     */
    public function show($id, Request $request)
    {
        $viewData = [
            'brand' => null,
            'products' => [],
            'pagination' => null,
            'paginationLinks' => null,
            'error' => null
        ];

        try {
            // Chuẩn bị params cho API products
            $productParams = $request->query();
            $productParams['brand_id'] = $id;

            // Chạy 2 request CÙNG LÚC
            $responses = Http::pool(fn(Pool $pool) => [
                $pool->as('brand')->baseUrl($this->apiUrl . '/api/client')->timeout(10)->get("/brands/{$id}"),
                $pool->as('products')->baseUrl($this->apiUrl . '/api/client')->timeout(10)->get("/products", $productParams)
            ]);

            // Xử lý response của Brand
            if ($responses['brand']->successful()) {
                $data = $responses['brand']->json();
                if (isset($data['data']) && is_array($data['data'])) {
                    $viewData['brand'] = $data['data'];
                } elseif (isset($data['name'])) { // Xử lý API trả về 1 object
                    $viewData['brand'] = $data;
                }
            } elseif ($responses['brand']->status() == 404) {
                abort(404, 'Không tìm thấy thương hiệu này.');
            }

            // Xử lý response của Products
            if ($responses['products']->successful()) {
                $productsData = $responses['products']->json();
                $viewData['products'] = $productsData['data'] ?? [];
                $viewData['pagination'] = $productsData['meta'] ?? null;
                $viewData['paginationLinks'] = $productsData['links'] ?? null;
            } else {
                Log::error('Brand Products API Error: ' . $responses['products']->status());
                $viewData['error'] = 'Không thể tải danh sách sản phẩm.';
            }

            return view('client.brands.brand-detail', $viewData);
        } catch (ConnectionException $e) {
            Log::error('BrandClientController Show Error: ' . $e->getMessage());
            $viewData['error'] = 'Không thể tải dữ liệu từ server';
            return view('client.brands.brand-detail', $viewData);
        }
    }
}
