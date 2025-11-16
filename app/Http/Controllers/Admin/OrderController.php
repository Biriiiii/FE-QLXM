<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Client\Pool; // 👈 1. Import Pool

class OrderController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('app.be_api_url'), '/');
    }

    /**
     * HÀM TỐI ƯU: Tạo API call request (Fix lỗi bảo mật)
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
     * TỐI ƯU: Hỗ trợ phân trang và tìm kiếm
     */
    public function index(Request $request)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            // Gửi tất cả query (page, search...) lên backend
            $response = $api->get('/orders', $request->query());

            if (!$response->successful()) {
                return view('admin.orders.index', [
                    'orders' => [],
                    'error' => 'API Error: ' . $response->json('message', $response->status())
                ]);
            }

            $data = $response->json();
            return view('admin.orders.index', [
                'orders' => $data['data'] ?? [],
                'pagination' => $data['meta'] ?? [],
                'paginationLinks' => $data['links'] ?? [],
            ]);
        } catch (ConnectionException $e) {
            return view('admin.orders.index', [
                'orders' => [],
                'error' => 'Lỗi kết nối backend: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * TỐI ƯU: Thêm auth và xử lý lỗi
     */
    public function create()
    {
        $api = $this->api(); // Sửa lỗi bảo mật
        if ($api instanceof RedirectResponse) return $api;

        try {
            // Giả sử API /customers trả về danh sách đầy đủ (không phân trang)
            $response = $api->get('/customers');
            $customers = $response->successful() ? $response->json('data', $response->json() ?? []) : [];

            return view('admin.orders.create', compact('customers'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối khi tải danh sách khách hàng.');
        }
    }

    /**
     * TỐI ƯU: Thêm auth và xử lý lỗi 422
     */
    public function store(Request $request)
    {
        $api = $this->api(); // Sửa lỗi bảo mật
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->post('/orders', $request->all());

            if ($response->successful()) {
                return redirect()->route('admin.orders.index')->with('success', 'Tạo đơn hàng thành công.');
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
     * TỐI ƯU: Thêm auth và xử lý lỗi 404
     */
    public function show($id)
    {
        $api = $this->api(); // Sửa lỗi bảo mật
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->get("/orders/{$id}");

            if (!$response->successful()) {
                abort(404, 'Không tìm thấy đơn hàng');
            }

            $order = $response->json('data', $response->json() ?? []);
            return view('admin.orders.show', compact('order'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * 3. TỐI ƯU HIỆU SUẤT: Tải song song
     */
    public function edit($id)
    {
        $apiCheck = $this->api(); // Sửa lỗi bảo mật
        if ($apiCheck instanceof RedirectResponse) return $apiCheck;

        $token = session('admin_token');
        $apiUrl = $this->apiUrl . '/api';

        try {
            // Chạy song song 2 request
            $responses = Http::pool(fn(Pool $pool) => [
                $pool->as('order')->withToken($token)->get($apiUrl . "/orders/{$id}"),
                $pool->as('customers')->withToken($token)->get($apiUrl . '/customers'),
            ]);

            // Kiểm tra order
            if (!$responses['order']->successful()) {
                abort(404, 'Không tìm thấy đơn hàng.');
            }
            $order = $responses['order']->json('data', $responses['order']->json() ?? []);

            // Kiểm tra customers (vẫn hiển thị form dù lỗi)
            $customers = $responses['customers']->successful() ? $responses['customers']->json('data', $responses['customers']->json() ?? []) : [];

            return view('admin.orders.edit', compact('order', 'customers'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * TỐI ƯU: Thêm auth và xử lý lỗi 422
     */
    public function update(Request $request, $id)
    {
        $api = $this->api(); // Sửa lỗi bảo mật
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->put("/orders/{$id}", $request->all());

            if ($response->successful()) {
                return redirect()->route('admin.orders.index')->with('success', 'Cập nhật đơn hàng thành công.');
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
     * TỐI ƯU: Thêm auth và xử lý lỗi
     */
    public function destroy($id)
    {
        $api = $this->api(); // Sửa lỗi bảo mật
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->delete("/orders/{$id}");

            if (!$response->successful()) {
                return back()->withErrors($response->json('message', 'Lỗi khi xóa'));
            }

            return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công.');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }
}
