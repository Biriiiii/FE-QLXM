<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
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
        // 1. TỐI ƯU BẢO MẬT: Kiểm tra token ở một nơi duy nhất
        if (!$token) {
            return redirect()->route('admin.auth.login');
        }
        return Http::withToken($token)
            ->baseUrl($this->apiUrl . '/api')
            ->timeout(15);
    }

    /**
     * 2. TỐI ƯU HIỆU SUẤT: Hỗ trợ phân trang và tìm kiếm
     */
    public function index(Request $request)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            // Gửi tất cả query (page, search...) lên backend
            $response = $api->get('/customers', $request->query());

            if (!$response->successful()) {
                return view('admin.customers.index', [
                    'customers' => [],
                    'error' => 'API Error: ' . $response->json('message', $response->status())
                ]);
            }

            $data = $response->json();
            return view('admin.customers.index', [
                'customers' => $data['data'] ?? [],
                'pagination' => $data['meta'] ?? [],
                'paginationLinks' => $data['links'] ?? [],
            ]);
        } catch (ConnectionException $e) {
            return view('admin.customers.index', [
                'customers' => [],
                'error' => 'Lỗi kết nối backend: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * TỐI ƯU: Thêm kiểm tra auth
     */
    public function create()
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        return view('admin.customers.create');
    }

    /**
     * 3. TỐI ƯU XỬ LÝ LỖI (Auth + Validation)
     */
    public function store(Request $request)
    {
        $api = $this->api(); // Sửa lỗi bảo mật (thiếu auth)
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->post('/customers', $request->all());

            if ($response->successful()) {
                return redirect()->route('admin.customers.index')->with('success', 'Tạo khách hàng thành công.');
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
    public function show($id)
    {
        $api = $this->api(); // Sửa lỗi bảo mật (thiếu auth)
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->get("/customers/{$id}");

            if (!$response->successful()) {
                abort(404, 'Không tìm thấy khách hàng');
            }

            $customer = $response->json('data', $response->json() ?? []);
            return view('admin.customers.show', compact('customer'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * TỐI ƯU: Thêm auth và xử lý lỗi
     */
    public function edit($id)
    {
        $api = $this->api(); // Sửa lỗi bảo mật (thiếu auth)
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->get("/customers/{$id}");

            if (!$response->successful()) {
                abort(404, 'Không tìm thấy khách hàng');
            }

            $customer = $response->json('data', $response->json() ?? []);
            return view('admin.customers.edit', compact('customer'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * TỐI ƯU: Thêm auth và xử lý lỗi
     */
    public function update(Request $request, $id)
    {
        $api = $this->api(); // Sửa lỗi bảo mật (thiếu auth)
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->put("/customers/{$id}", $request->all());

            if ($response->successful()) {
                return redirect()->route('admin.customers.index')->with('success', 'Cập nhật khách hàng thành công.');
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
        $api = $this->api(); // Sửa lỗi bảo mật (thiếu auth)
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->delete("/customers/{$id}");

            if (!$response->successful()) {
                return back()->withErrors($response->json('message', 'Lỗi khi xóa'));
            }

            return redirect()->route('admin.customers.index')->with('success', 'Xóa khách hàng thành công.');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }
}
