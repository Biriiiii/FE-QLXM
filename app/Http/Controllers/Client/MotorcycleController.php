<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MotorcycleController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
    }
    /**
     * Display a listing of motorcycles.
     */
    public function index(Request $request)
    {
        try {
            $params = [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 5),
            ];

            // Thêm filter nếu có
            if ($request->filled('brand_id')) {
                $params['brand_id'] = $request->get('brand_id');
            }

            if ($request->filled('category_id')) {
                $params['category_id'] = $request->get('category_id');
            }

            if ($request->filled('search')) {
                $params['search'] = $request->get('search');
            }

            // Call API lấy danh sách sản phẩm
            $response = Http::timeout(10)->get($this->apiUrl . '/api/client/products', $params);

            $products = [];
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

                Log::info('Motorcycles API Success: ' . count($products) . ' products loaded');
            } else {
                Log::error('Motorcycles API Error: ' . $response->status());
                $error = 'Không thể tải danh sách xe máy';
            }

            // Lấy danh sách brands và categories cho filter
            $brands = $this->getBrands();
            $categories = $this->getCategories();

            return view('client.motorcycles', compact('products', 'brands', 'categories', 'pagination'))
                ->with('error', $error ?? null);
        } catch (\Exception $e) {
            Log::error('Motorcycles Controller Error: ' . $e->getMessage());

            return view('client.motorcycles', [
                'products' => [],
                'brands' => [],
                'categories' => [],
                'pagination' => null,
                'error' => 'Không thể tải dữ liệu từ server'
            ]);
        }
    }

    /**
     * Display the specified motorcycle.
     */
    public function show($id)
    {
        try {
            $apiEndpoint = $this->apiUrl . '/api/client/products/' . $id;
            Log::info('Trying to fetch product from: ' . $apiEndpoint);

            // Call API lấy chi tiết sản phẩm
            $response = Http::timeout(10)->get($apiEndpoint);

            Log::info('API Response Status: ' . $response->status());
            Log::info('API Response Body: ' . $response->body());

            $product = null;
            $relatedProducts = [];

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Raw API response: ' . json_encode($data));

                // Kiểm tra xem response có structure nào
                if (isset($data['data'])) {
                    $product = $data['data'];
                } elseif (isset($data['id'])) {
                    // Nếu response trực tiếp là object sản phẩm
                    $product = $data;
                } else {
                    $product = null;
                }

                Log::info('Processed product data: ' . json_encode($product));

                if ($product) {
                    // Thêm image_url
                    $product['image_url'] = !empty($product['image'])
                        ? $this->apiUrl . '/storage/' . $product['image']
                        : null;

                    // Lấy sản phẩm liên quan (cùng brand hoặc category)
                    $relatedProducts = $this->getRelatedProducts($product);

                    Log::info('Product Detail API Success for ID: ' . $id);

                    return view('client.motorcycles.show', compact('product', 'relatedProducts'));
                } else {
                    Log::warning('Product data is null or empty');
                }
            } else {
                Log::error('Product Detail API Error for ID: ' . $id . ', Status: ' . $response->status());
                Log::error('Response body: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Product Detail Controller Error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
        }

        // Nếu có lỗi hoặc không tìm thấy sản phẩm
        return view('client.motorcycles.show', [
            'product' => null,
            'relatedProducts' => [],
            'error' => 'Không tìm thấy sản phẩm với ID: ' . $id . '. Vui lòng kiểm tra backend API: ' . $this->apiUrl
        ]);
    }

    /**
     * Display a listing of brands.
     */
    public function brands(Request $request)
    {
        try {
            $params = [
                'page' => $request->get('page', 1),
                'limit' => 5, // 5 brands mỗi trang
            ];

            // Call API lấy danh sách brands
            $response = Http::timeout(10)->get($this->apiUrl . '/api/client/brands', $params);

            $brands = [];
            $pagination = null;

            if ($response->successful()) {
                $data = $response->json();
                $brands = $data['data'] ?? [];
                $pagination = $data['meta'] ?? null;

                Log::info('Brands API Success: ' . count($brands) . ' brands loaded');
            } else {
                Log::error('Brands API Error: ' . $response->status());
                $error = 'Không thể tải danh sách hãng xe';
            }

            return view('client.brands', compact('brands', 'pagination'))
                ->with('error', $error ?? null);
        } catch (\Exception $e) {
            Log::error('Brands Controller Error: ' . $e->getMessage());

            return view('client.brands', [
                'brands' => [],
                'pagination' => null,
                'error' => 'Không thể tải dữ liệu từ server'
            ]);
        }
    }

    /**
     * Display motorcycles by brand.
     */
    public function brandDetail($id, Request $request)
    {
        try {
            // Call API lấy thông tin brand
            $brandResponse = Http::timeout(10)->get($this->apiUrl . '/api/client/brands/' . $id);

            $brand = null;
            if ($brandResponse->successful()) {
                $brandData = $brandResponse->json();
                $brand = $brandData['data'] ?? null;
            }

            // Call API lấy sản phẩm theo brand
            $params = [
                'brand_id' => $id,
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 5),
            ];

            $response = Http::timeout(10)->get($this->apiUrl . '/api/client/products', $params);

            $products = [];
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

                Log::info('Brand Detail API Success for Brand ID: ' . $id . ', Products: ' . count($products));
            } else {
                Log::error('Brand Detail API Error for Brand ID: ' . $id . ', Status: ' . $response->status());
                $error = 'Không thể tải sản phẩm của hãng';
            }

            return view('client.brand-detail', compact('brand', 'products', 'pagination'))
                ->with('error', $error ?? null);
        } catch (\Exception $e) {
            Log::error('Brand Detail Controller Error: ' . $e->getMessage());

            return view('client.brand-detail', [
                'brand' => null,
                'products' => [],
                'pagination' => null,
                'error' => 'Không thể tải dữ liệu từ server'
            ]);
        }
    }

    /**
     * Helper method to get brands
     */
    private function getBrands()
    {
        try {
            $response = Http::timeout(5)->get($this->apiUrl . '/api/client/brands');
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? [];
            }
        } catch (\Exception $e) {
            Log::warning('Get Brands Error: ' . $e->getMessage());
        }
        return [];
    }

    /**
     * Helper method to get categories
     */
    private function getCategories()
    {
        try {
            $response = Http::timeout(5)->get($this->apiUrl . '/api/client/categories');
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? [];
            }
        } catch (\Exception $e) {
            Log::warning('Get Categories Error: ' . $e->getMessage());
        }
        return [];
    }

    /**
     * Helper method to get related products
     */
    private function getRelatedProducts($product)
    {
        try {
            $params = [
                'limit' => 3, // Lấy 3 sản phẩm liên quan
            ];

            // Ưu tiên sản phẩm cùng brand
            if (isset($product['brand']['id'])) {
                $params['brand_id'] = $product['brand']['id'];
            } elseif (isset($product['category']['id'])) {
                // Nếu không có brand thì lấy cùng category
                $params['category_id'] = $product['category']['id'];
            }

            $response = Http::timeout(5)->get($this->apiUrl . '/api/client/products', $params);

            if ($response->successful()) {
                $data = $response->json();
                $relatedProducts = $data['data'] ?? [];

                // Loại bỏ sản phẩm hiện tại khỏi danh sách liên quan
                $relatedProducts = array_filter($relatedProducts, function ($relatedProduct) use ($product) {
                    return $relatedProduct['id'] != $product['id'];
                });

                // Thêm image_url cho các sản phẩm liên quan
                foreach ($relatedProducts as &$relatedProduct) {
                    $relatedProduct['image_url'] = !empty($relatedProduct['image'])
                        ? $this->apiUrl . '/storage/' . $relatedProduct['image']
                        : null;
                }

                // Chỉ lấy 3 sản phẩm đầu tiên
                return array_slice($relatedProducts, 0, 3);
            }
        } catch (\Exception $e) {
            Log::warning('Get Related Products Error: ' . $e->getMessage());
        }

        return [];
    }
}
