<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
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
        $customers = Http::withToken($token)->get($apiUrl . '/api/customers')->json('data') ?? [];
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $response = Http::post(env('BE_API_URL', 'http://localhost:8000') . '/api/customers', $data);
        if ($response->successful()) {
            return redirect()->route('admin.customers.index')->with('success', 'Tạo khách hàng thành công.');
        }
        return back()->withErrors('Lỗi khi tạo khách hàng');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $response = Http::get(env('BE_API_URL', 'http://localhost:8000') . "/api/customers/{$id}");
        $customer = $response->json() ?? [];
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $response = Http::get("http://localhost:8000/api/customers/{$id}");
        $customer = $response->json() ?? [];
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $response = Http::put(env('BE_API_URL', 'http://localhost:8000') . "/api/customers/{$id}", $data);
        if ($response->successful()) {
            return redirect()->route('admin.customers.index')->with('success', 'Cập nhật khách hàng thành công.');
        }
        return back()->withErrors('Lỗi khi cập nhật khách hàng');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete(env('BE_API_URL', 'http://localhost:8000') . "/api/customers/{$id}");
        if ($response->successful()) {
            return redirect()->route('admin.customers.index')->with('success', 'Xóa khách hàng thành công.');
        }
        return back()->withErrors('Lỗi khi xóa khách hàng');
    }
}
