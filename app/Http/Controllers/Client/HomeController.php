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
            // Call API lấy sản phẩm với phân trang
            $response = Http::timeout(10)->get($this->apiUrl . '/api/client/products', [
                'page' => $request->get('page', 1),
                'limit' => 5, // 5 sản phẩm mỗi trang
                'featured' => true // Nếu backend có support featured products
            ]);

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
