<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
    }

    /**
     * Display the home page.
     */
    public function index(Request $request)
    {
        try {
            // Lấy các tham số tìm kiếm từ request
            $searchParams = [
                'page' => $request->get('page', 1),
                'limit' => 12, // Tăng số lượng sản phẩm khi có tìm kiếm
            ];

            // Thêm các tham số tìm kiếm nếu có
            if ($request->filled('search')) {
                $searchParams['search'] = $request->get('search');
            }

            if ($request->filled('brand')) {
                $searchParams['brand_id'] = $request->get('brand');
            }

            if ($request->filled('category')) {
                $searchParams['category_id'] = $request->get('category');
            }

            if ($request->filled('price_range')) {
                $priceRange = explode('-', $request->get('price_range'));
                if (count($priceRange) == 2) {
                    $searchParams['min_price'] = $priceRange[0];
                    $searchParams['max_price'] = $priceRange[1];
                }
            }

            // Nếu không có tìm kiếm, chỉ lấy featured products
            if (!$request->hasAny(['search', 'brand', 'category', 'price_range'])) {
                $searchParams['featured'] = true;
                $searchParams['limit'] = 6; // Giảm số lượng cho trang chủ
            }

            // Call API lấy sản phẩm
            $response = Http::timeout(10)->get($this->apiUrl . '/api/client/products', $searchParams);

            $products = [];
            $brands = [];
            $categories = [];
            $pagination = null;

            if ($response->successful()) {
                $data = $response->json();
                $products = $data['data'] ?? [];
                $pagination = $data['meta'] ?? null;

                // Thêm image_url cho mỗi sản phẩm
                foreach ($products as &$product) {
                    $product['image_url'] = !empty($product['image'])
                        ? $this->apiUrl . '/storage/' . $product['image']
                        : null;
                }

                Log::info('Home API Success: ' . count($products) . ' products loaded');
            } else {
                Log::error('Home API Error: ' . $response->status());
            }

            // Call API lấy brands (optional)
            try {
                $brandResponse = Http::timeout(5)->get($this->apiUrl . '/api/client/brands');
                if ($brandResponse->successful()) {
                    $brandData = $brandResponse->json();
                    $brands = $brandData['data'] ?? [];
                }
            } catch (\Exception $e) {
                Log::warning('Brands API Error: ' . $e->getMessage());
            }

            // Call API lấy categories (optional)
            try {
                $categoryResponse = Http::timeout(5)->get($this->apiUrl . '/api/client/categories');
                if ($categoryResponse->successful()) {
                    $categoryData = $categoryResponse->json();
                    $categories = $categoryData['data'] ?? [];
                }
            } catch (\Exception $e) {
                Log::warning('Categories API Error: ' . $e->getMessage());
            }

            return view('client.home', compact('products', 'brands', 'categories', 'pagination'));
        } catch (\Exception $e) {
            Log::error('Home Controller Error: ' . $e->getMessage());

            // Fallback - trả về view với dữ liệu rỗng
            return view('client.home', [
                'products' => [],
                'brands' => [],
                'categories' => [],
                'pagination' => null,
                'error' => 'Không thể tải dữ liệu từ server'
            ]);
        }
    }
}
