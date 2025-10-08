<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // Danh sách brands
    public function index(Request $request)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        try {
            $page = $request->query('page', 1);
            $http = Http::timeout(10);
            if ($token) {
                $http = $http->withToken($token);
            }
            $response = $http->get($apiUrl . '/api/brands', [
                'page' => $page
            ]);

            if (!$response->successful()) {
                return view('admin.brands.index', [
                    'brands' => [],
                    'pagination' => [],
                    'paginationLinks' => [],
                    'error' => 'Không thể kết nối đến API backend. Status: ' . $response->status()
                ]);
            }

            $responseData = $response->json();
            $brands = $responseData['data'] ?? [];
            $pagination = $responseData['meta'] ?? [];
            $paginationLinks = $responseData['links'] ?? [];

            return view('admin.brands.index', compact('brands', 'pagination', 'paginationLinks'));
        } catch (\Exception $e) {
            return view('admin.brands.index', [
                'brands' => [],
                'pagination' => [],
                'paginationLinks' => [],
                'error' => 'Lỗi kết nối backend: ' . $e->getMessage()
            ]);
        }
    }

    // Form thêm mới
    public function create()
    {
        return view('admin.brands.create');
    }
    public function store(Request $request)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $data = $request->except('logo');
        $http = Http::withToken($token);
        if ($request->hasFile('logo')) {
            $http = $http->attach(
                'logo',
                fopen($request->file('logo')->getRealPath(), 'r'),
                $request->file('logo')->getClientOriginalName()
            );
        }
        $response = $http->post($apiUrl . '/api/brands', $data);
        if ($response->successful()) {
            return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công');
        }
        return back()->withErrors('Lỗi khi thêm thương hiệu');
    }

    public function edit($id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $response = Http::withToken($token)->get($apiUrl . "/api/brands/{$id}");
        $json = $response->json();
        $brand = isset($json['data']) ? $json['data'] : [];
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $data = $request->except('logo');
        $http = Http::withToken($token);
        if ($request->hasFile('logo')) {
            $http = $http->attach(
                'logo',
                fopen($request->file('logo')->getRealPath(), 'r'),
                $request->file('logo')->getClientOriginalName()
            );
        }
        $response = $http->put($apiUrl . "/api/brands/{$id}", $data);
        if ($response->successful()) {
            return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công');
        }
        return back()->withErrors('Lỗi khi cập nhật thương hiệu');
    }

    public function destroy($id)
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
        $token = session('admin_token');
        $response = Http::withToken($token)->delete($apiUrl . "/api/brands/{$id}");
        if ($response->successful()) {
            return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công!');
        }
        return back()->withErrors('Lỗi khi xóa thương hiệu');
    }
}
