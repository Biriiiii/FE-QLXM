<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\PendingRequest; // 👈 1. Import
use Illuminate\Http\Client\ConnectionException; // 👈 2. Import
use Illuminate\Http\Client\Pool; // 👈 3. Import

class HomeController extends Controller
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
            ->timeout(10); // Đặt timeout chung
    }

    /**
     * TỐI ƯU: Chuẩn hóa logic lấy URL ảnh
     */
    private function formatProductImageUrl(array &$product)
    {
        if (!empty($product['image_url'])) {
            $product['image_url'] = $product['image_url'];
        } elseif (!empty($product['image'])) {
            $product['image_url'] = $this->apiUrl . '/storage/' . $product['image'];
        } else {
            $product['image_url'] = null;
        }
    }

    /**
     * 4. TỐI ƯU TỐC ĐỘ: Dùng Http::pool() chạy song song
     */
    public function index(Request $request)
    {
        $viewData = [
            'products' => [],
            'brands' => [],
            'categories' => [],
            'pagination' => null,
            'paginationLinks' => null, // Thêm paginationLinks
            'error' => null
        ];

        try {
            // Chuẩn bị params cho products
            $productParams = $request->query();
            $productParams['limit'] = 5; // Giữ 5 sản phẩm
            $productParams['featured'] = true;

            // Chạy 3 request CÙNG LÚC
            $responses = Http::pool(fn(Pool $pool) => [
                $pool->as('products')->baseUrl($this->apiUrl . '/api/client')->get('/products', $productParams),
                $pool->as('brands')->baseUrl($this->apiUrl . '/api/client')->get('/brands'),
                $pool->as('categories')->baseUrl($this->apiUrl . '/api/client')->get('/categories'),
            ]);

            // Xử lý Products
            if ($responses['products']->successful()) {
                $data = $responses['products']->json();
                $viewData['products'] = $data['data'] ?? [];
                $viewData['pagination'] = $data['meta'] ?? null;
                $viewData['paginationLinks'] = $data['links'] ?? null;

                foreach ($viewData['products'] as &$product) {
                    $this->formatProductImageUrl($product);
                }
            } else {
                Log::error('Home API Error (Products): ' . $responses['products']->status());
                $viewData['error'] = 'Không thể tải sản phẩm.';
            }

            // Xử lý Brands (vẫn tải dù product lỗi)
            if ($responses['brands']->successful()) {
                $viewData['brands'] = $responses['brands']->json('data', []);
            } else {
                Log::warning('Home API Error (Brands): ' . $responses['brands']->status());
            }

            // Xử lý Categories (vẫn tải dù product lỗi)
            if ($responses['categories']->successful()) {
                $viewData['categories'] = $responses['categories']->json('data', []);
            } else {
                Log::warning('Home API Error (Categories): ' . $responses['categories']->status());
            }

            return view('client.home', $viewData);
        } catch (ConnectionException $e) {
            Log::error('Home Controller Error: ' . $e->getMessage());
            $viewData['error'] = 'Không thể tải dữ liệu từ server';
            return view('client.home', $viewData);
        }
    }

    /**
     * Display the contact page. (Không đổi)
     */
    public function contact()
    {
        return view('client.contact');
    }

    /**
     * Display the checkout page. (Không đổi)
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('client.checkout', compact('cart', 'total'));
    }

    /**
     * TỐI ƯU: Thêm try...catch và dùng clientApi()
     */
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống');
            }

            $orderData = [
                'customer_info' => $validated,
                'items' => array_values($cart),
                'total_amount' => array_sum(array_map(function ($item) {
                    return $item['price'] * $item['quantity'];
                }, $cart)),
                'status' => 'pending'
            ];

            // 5. TỐI ƯU: Dùng clientApi()
            $response = $this->clientApi()->timeout(30)->post('/orders', $orderData);

            if ($response->successful()) {
                session()->forget('cart');

                // Mail::to($validated['email'])->send(new OrderConfirmation($orderData));

                return redirect()->route('client.home')->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm.');
            } else {
                Log::error('Order API Error: ' . $response->body());
                return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý đơn hàng. Vui lòng thử lại.');
            }
        } catch (ConnectionException $e) { // 6. TỐI ƯU: Bắt lỗi kết nối
            Log::error('Checkout Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi kết nối máy chủ. Vui lòng thử lại sau.');
        }
    }
}
