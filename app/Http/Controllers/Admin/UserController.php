<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException; // 👈 1. Import

class UserController extends Controller
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
            $response = $api->get('/users', $request->query());

            if (!$response->successful()) {
                return view('admin.users.index', [
                    'users' => [],
                    'error' => 'API Error: ' . $response->json('message', $response->status())
                ]);
            }

            $data = $response->json();
            return view('admin.users.index', [
                'users' => $data['data'] ?? [],
                'pagination' => $data['meta'] ?? [],
                'paginationLinks' => $data['links'] ?? [],
            ]);
        } catch (ConnectionException $e) {
            return view('admin.users.index', [
                'users' => [],
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

        return view('admin.users.create');
    }

    /**
     * TỐI ƯU: Xử lý lỗi 422 tự động
     */
    public function store(Request $request)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->post('/users', $request->all());

            if ($response->successful()) {
                return redirect()->route('admin.users.index')->with('success', 'Tạo người dùng thành công.');
            }

            // 2. TỐI ƯU: Tự động ném lỗi validation
            if ($response->status() == 422) {
                throw ValidationException::withMessages($response->json('errors', []));
            }

            // Lỗi chung
            return back()->withErrors($response->json('message', 'Lỗi không xác định'))->withInput();
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->get("/users/{$id}");

            if (!$response->successful()) {
                abort(404, 'Không tìm thấy người dùng');
            }

            $user = $response->json('data', []);
            return view('admin.users.show', compact('user'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->get("/users/{$id}");

            if (!$response->successful()) {
                abort(404, 'Không tìm thấy người dùng');
            }

            $user = $response->json('data', []);
            return view('admin.users.edit', compact('user'));
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }

    /**
     * TỐI ƯU: Xử lý lỗi 422 và chỉ gửi các trường cần thiết
     */
    public function update(Request $request, $id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        // 3. TỐI ƯU: Chỉ gửi các trường được phép, không gửi $request->all()
        $data = $request->only('name', 'email', 'role');

        // Chỉ thêm password nếu nó được nhập
        if ($request->filled('password')) {
            $data['password'] = $request->input('password');
            $data['password_confirmation'] = $request->input('password_confirmation');
        }

        try {
            $response = $api->put("/users/{$id}", $data);

            if ($response->successful()) {
                return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công.');
            }

            if ($response->status() == 422) {
                throw ValidationException::withMessages($response->json('errors', []));
            }

            return back()->withErrors($response->json('message', 'Lỗi không xác định'))->withInput();
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $api = $this->api();
        if ($api instanceof RedirectResponse) return $api;

        try {
            $response = $api->delete("/users/{$id}");

            if (!$response->successful()) {
                return back()->withErrors($response->json('message', 'Lỗi khi xóa'));
            }

            return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công.');
        } catch (ConnectionException $e) {
            return back()->withErrors('Lỗi kết nối: ' . $e->getMessage());
        }
    }
}
