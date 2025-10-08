<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $users = Http::withToken($token)->get($apiUrl . '/api/users')->json('data') ?? [];
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
            'role' => $request->input('role'),
        ];
        $response = Http::withToken($token)->post($apiUrl . '/api/users', $data);
        if ($response->successful()) {
            return redirect()->route('admin.users.index')->with('success', 'Tạo người dùng thành công.');
        }
        // Hiển thị lỗi chi tiết nếu có
        $errors = $response->json('errors') ?? [];
        $errorMsg = 'Lỗi khi tạo người dùng';
        if (!empty($errors)) {
            $errorMsg .= ':<br>';
            foreach ($errors as $field => $msgs) {
                foreach ($msgs as $msg) {
                    $errorMsg .= "<b>$field</b>: $msg<br>";
                }
            }
        }
        return back()->withErrors($errorMsg);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $response = Http::withToken($token)->get($apiUrl . "/api/users/{$id}");
        $user = $response->json('data') ?? [];
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $response = Http::withToken($token)->get($apiUrl . "/api/users/{$id}");
        $user = $response->json('data') ?? [];
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $data = $request->all();
        $response = Http::withToken($token)->put($apiUrl . "/api/users/{$id}", $data);
        if ($response->successful()) {
            return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công.');
        }
        return back()->withErrors('Lỗi khi cập nhật người dùng');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $response = Http::withToken($token)->delete($apiUrl . "/api/users/{$id}");
        if ($response->successful()) {
            return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công.');
        }
        return back()->withErrors('Lỗi khi xóa người dùng');
    }
}
