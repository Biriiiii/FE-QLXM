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
        // URL backend từ .env hoặc fallback mặc định
        $this->apiUrl = rtrim(config('app.be_api_url', 'https://be-qlxm-9b1bc6070adf.herokuapp.com/'), '/');
    }

    /**
     * Trang chủ - hiển thị danh sách sản phẩm nổi bật hoặc mới nhất.
     */
    public function index(Request $request)
    {
        try {
            // ======================== GỌI API SẢN PHẨM ========================
            $response = Http::timeout(10)->get("{$this->apiUrl}/api/client/products", [
                'page' => $request->get('page', 1),
                'limit' => 8, // hiển thị 8 sản phẩm / trang
                'sort' => 'newest', // sắp xếp sản phẩm mới nhất
            ]);

            $products = [];
            $pagination = null;

            if ($response->successful()) {
                $data = $response->json();

                $products = $data['data'] ?? [];
                $pagination = $data['meta'] ?? null;

                // Chuẩn hóa image_url nếu null
                foreach ($products as &$product) {
                    $product['image'] = $product['image_url'] ?? asset('images/no-image.png');
                }

                Log::info('[Home] Loaded ' . count($products) . ' products.');
            } else {
                Log::error('[Home] API products error: ' . $response->status());
            }

            // ======================== GỌI API HÃNG XE ========================
            $brands = [];
            try {
                $brandResponse = Http::timeout(5)->get("{$this->apiUrl}/api/client/brands");
                if ($brandResponse->successful()) {
                    $brands = $brandResponse->json('data') ?? [];
                }
            } catch (\Exception $e) {
                Log::warning('[Home] Brands API failed: ' . $e->getMessage());
            }

            // ======================== GỌI API LOẠI XE ========================
            $categories = [];
            try {
                $cateResponse = Http::timeout(5)->get("{$this->apiUrl}/api/client/categories");
                if ($cateResponse->successful()) {
                    $categories = $cateResponse->json('data') ?? [];
                }
            } catch (\Exception $e) {
                Log::warning('[Home] Categories API failed: ' . $e->getMessage());
            }

            // ======================== TRẢ VỀ VIEW ========================
            return view('client.home', compact('products', 'brands', 'categories', 'pagination'));
        } catch (\Exception $e) {
            Log::error('[Home] Controller Error: ' . $e->getMessage());

            // Nếu lỗi thì trả về view trống
            return view('client.home', [
                'products' => [],
                'brands' => [],
                'categories' => [],
                'pagination' => null,
                'error' => 'Không thể tải dữ liệu từ server!'
            ]);
        }
    }
}
