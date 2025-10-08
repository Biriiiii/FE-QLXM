<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hiển thị danh sách category
    public function index()
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $categories = Http::withToken($token)->get($apiUrl . '/api/categories')->json('data') ?? [];
        return view('admin.categories.index', compact('categories'));
    }

    // Form thêm mới category
    public function create()
    {
        return view('admin.categories.create');
    }

    // Lưu category mới
    public function store(Request $request)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $data = $request->all();
        $response = Http::withToken($token)->post($apiUrl . '/api/categories', $data);
        if ($response->successful()) {
            return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
        }
        return back()->withErrors('Lỗi khi thêm danh mục');
    }

    // Form edit category
    public function edit($id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $response = Http::withToken($token)->get($apiUrl . "/api/categories/{$id}");
        $category = $response->json('data') ?? [];
        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật category+
    public function update(Request $request, $id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $data = $request->all();
        $response = Http::withToken($token)->put($apiUrl . "/api/categories/{$id}", $data);
        if ($response->successful()) {
            return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
        }
        return back()->withErrors('Lỗi khi cập nhật danh mục');
    }
    public function destroy($id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $response = Http::withToken($token)->delete($apiUrl . "/api/categories/{$id}");
        if ($response->successful()) {
            return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
        }
        return back()->withErrors('Lỗi khi xóa danh mục');
    }
}
