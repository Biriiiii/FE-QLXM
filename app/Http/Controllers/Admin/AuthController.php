<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\ConnectionException; // TỐI ƯU 1: Import để bắt lỗi kết nối

class AuthController extends Controller
{
    protected $apiUrl;

    // TỐI ƯU 2: Dùng Constructor để không lặp lại API URL (DRY)
    public function __construct()
    {
        // Lấy API URL từ config, đảm bảo có dấu / ở cuối
        $this->apiUrl = rtrim(config('app.be_api_url'), '/') . '/api/auth';
    }

    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    // Xử lý đăng nhập qua API BE
    public function login(Request $request)
    {
        try {
            $response = Http::post($this->apiUrl . '/login', [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            // TỐI ƯU 3: Xử lý lỗi cụ thể theo HTTP Status
            if ($response->successful()) { // Chỉ chạy khi status là 2xx
                $responseData = $response->json();

                if (isset($responseData['token']) && isset($responseData['user'])) {
                    Session::put('admin_token', $responseData['token']);
                    Session::put('admin_user', $responseData['user']);

                    if ($request->expectsJson()) {
                        return response()->json(['success' => true, 'message' => 'Đăng nhập thành công!']);
                    }
                    return redirect()->route('admin.dashboard');
                }

                // Nếu response 200 OK nhưng không có token/user
                $errorMessage = 'Phản hồi từ máy chủ không hợp lệ.';
            } else {
                // Xử lý các lỗi HTTP khác
                if ($response->status() == 401) {
                    $errorMessage = 'Sai thông tin email hoặc mật khẩu.';
                } elseif ($response->status() == 422) {
                    // Lấy lỗi validation từ BE nếu có
                    $errorMessage = $response->json('message', 'Dữ liệu nhập không hợp lệ.');
                } else {
                    $errorMessage = 'Máy chủ backend gặp lỗi. Status: ' . $response->status();
                }
            }
        } catch (ConnectionException $e) {
            // TỐI ƯU 1: Bắt lỗi nếu không thể kết nối đến BE (BE bị sập, DNS lỗi...)
            $errorMessage = 'Không thể kết nối đến máy chủ xác thực. Vui lòng thử lại sau.';
        }

        // Trả về lỗi (nếu có)
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $errorMessage], 422);
        }
        return back()->withErrors(['email' => $errorMessage])->withInput();
    }

    // Hiển thị form quên mật khẩu
    public function showForgot()
    {
        return view('admin.auth.forgot');
    }

    // Xử lý quên mật khẩu qua API BE
    public function forgot(Request $request)
    {
        try {
            $response = Http::post($this->apiUrl . '/forgot', [
                'email' => $request->input('email'),
            ]);

            if ($response->successful()) {
                return back()->with('status', 'Vui lòng kiểm tra email để lấy lại mật khẩu!');
            } else {
                // TỐI ƯU 4: Cung cấp thông báo lỗi tốt hơn
                $errorMessage = $response->json('message', 'Không thể gửi yêu cầu. Email không tồn tại?');
                return back()->withErrors(['email' => $errorMessage])->withInput();
            }
        } catch (ConnectionException $e) {
            return back()->withErrors(['email' => 'Không thể kết nối đến máy chủ.'])->withInput();
        }
    }

    // Đăng xuất
    public function logout()
    {
        $token = Session::get('admin_token');

        if ($token) {
            try {
                // Vẫn gọi logout ở BE nhưng không chặn nếu nó lỗi
                Http::withToken($token)->post($this->apiUrl . '/logout');
            } catch (\Exception $e) {
                // Bỏ qua lỗi nếu API logout bị hỏng
            }
        }

        Session::forget('admin_token');
        Session::forget('admin_user');

        return redirect()->route('admin.auth.login');
    }
}
