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
        $apiUrl = env('BE_API_URL', 'http://localhost:8000');
        $response = Http::post($apiUrl . '/api/auth/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if ($response->ok() && isset($response['token'])) {
            Session::put('admin_token', $response['token']);
            return redirect()->route('admin.dashboard');
        } else {
            return back()->withErrors(['email' => 'Đăng nhập thất bại!'])->withInput();
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
        $apiUrl = env('BE_API_URL', 'http://localhost:8000');
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
        $apiUrl = env('BE_API_URL', 'http://localhost:8000');
        $token = Session::get('admin_token');
        if ($token) {
            Http::withToken($token)->post($apiUrl . '/api/auth/logout');
        }
        Session::forget('admin_token');
        return redirect()->route('admin.auth.login');
    }
}
