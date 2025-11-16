<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool; // 👈 1. Import Pool
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    protected $apiUrl;

    /**
     * Dùng Constructor để thiết lập API URL một lần duy nhất
     */
    public function __construct()
    {
        $this->apiUrl = rtrim(config('app.be_api_url'), '/');
    }

    /**
     * HÀM TỐI ƯU: Chỉ dùng để kiểm tra auth
     *
     * @return \Illuminate\Http\Client\PendingRequest|RedirectResponse
     */
    private function api()
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        // Chỉ trả về true (hoặc 1) để xác nhận đã auth
        return true;
    }


    public function index()
    {
        // 1. Dùng hàm api() để kiểm tra auth
        $authCheck = $this->api();
        if ($authCheck instanceof RedirectResponse) return $authCheck;

        $token = session('admin_token');
        $apiUrl = $this->apiUrl . '/api';
        $data = []; // Chuẩn bị mảng data cho view

        try {
            // 2. TỐI ƯU: Chạy 4 request CÙNG LÚC (song song)
            $responses = Http::pool(fn(Pool $pool) => [
                $pool->as('products')->withToken($token)->get($apiUrl . '/products'),
                $pool->as('customers')->withToken($token)->get($apiUrl . '/customers'),
                $pool->as('orders')->withToken($token)->get($apiUrl . '/orders'),
                $pool->as('users')->withToken($token)->get($apiUrl . '/users'),
            ]);

            // 3. Xử lý kết quả của từng request
            // Kiểm tra ->successful() trước khi lấy json
            $products = $responses['products']->successful() ? $responses['products']->json('data', []) : [];
            $customers = $responses['customers']->successful() ? $responses['customers']->json('data', []) : [];
            $orders = $responses['orders']->successful() ? $responses['orders']->json('data', []) : [];
            $users = $responses['users']->successful() ? $responses['users']->json('data', []) : [];

            // Ghi nhận lỗi nếu có
            if (!$responses['products']->successful()) {
                $data['error'] = 'Lỗi khi tải Products: ' . $responses['products']->status();
            }
        } catch (ConnectionException $e) {
            $data['error'] = 'Không thể kết nối đến máy chủ backend: ' . $e->getMessage();
            // Khởi tạo mảng rỗng để view không bị lỗi
            $products = $customers = $orders = $users = [];
        }

        // 4. Tính toán và gán dữ liệu
        $data['productCount'] = count($products);
        $data['customerCount'] = count($customers);
        $data['orderCount'] = count($orders);
        $data['userCount'] = count($users);

        // Sắp xếp (nếu cần) và lấy 5
        // Giả sử API trả về đã sắp xếp mới nhất
        $data['latestOrders'] = array_slice($orders, 0, 5);
        $data['latestProducts'] = array_slice($products, 0, 5);

        return view('admin.dashboard', $data);
    }
}
