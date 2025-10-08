<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    // Xử lý đăng nhập qua API BE
    public function login(Request $request)
    {
        $apiUrl = config('app.be_api_url', 'https://be-qlxm-e11819409fff.herokuapp.com/');
        $response = Http::post($apiUrl . '/api/auth/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if ($response->ok()) {
            $responseData = $response->json();
            if (isset($responseData['token']) && isset($responseData['user'])) {
                // Lưu token thật và thông tin user vào session
                Session::put('admin_token', $responseData['token']);
                Session::put('admin_user', $responseData['user']);

                // Nếu là AJAX request, trả về JSON
                if ($request->expectsJson()) {
                    return response()->json(['success' => true, 'message' => 'Đăng nhập thành công!']);
                }

                return redirect()->route('admin.dashboard');
            } else {
                $errorMessage = 'Token hoặc user không tồn tại trong response!';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $errorMessage], 422);
                }
                return back()->withErrors(['email' => $errorMessage])->withInput();
            }
        } else {
            $errorMessage = 'Đăng nhập thất bại! Status: ' . $response->status();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $errorMessage], 422);
            }
            return back()->withErrors(['email' => $errorMessage])->withInput();
        }
    }

    // Hiển thị form quên mật khẩu
    public function showForgot()
    {
        return view('admin.auth.forgot');
    }

    // Xử lý quên mật khẩu qua API BE
    public function forgot(Request $request)
    {
        $apiUrl = config('app.be_api_url', 'https://be-qlxm-e11819409fff.herokuapp.com/');
        $response = Http::post($apiUrl . '/api/auth/forgot', [
            'email' => $request->input('email'),
        ]);

        if ($response->ok()) {
            return back()->with('status', 'Vui lòng kiểm tra email để lấy lại mật khẩu!');
        } else {
            return back()->withErrors(['email' => 'Không thể gửi yêu cầu!'])->withInput();
        }
    }

    // Đăng xuất
    public function logout()
    {
        $apiUrl = config('app.be_api_url', 'https://be-qlxm-e11819409fff.herokuapp.com/');
        $token = Session::get('admin_token');
        if ($token) {
            Http::withToken($token)->post($apiUrl . '/api/auth/logout');
        }
        Session::forget('admin_token');
        Session::forget('admin_user');
        return redirect()->route('admin.auth.login');
    }
}
