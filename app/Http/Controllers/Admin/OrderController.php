<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
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
        $orders = Http::withToken($token)->get($apiUrl . '/api/orders')->json('data') ?? [];
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Http::get(env('BE_API_URL', 'http://localhost:8000') . '/api/customers')->json() ?? [];
        return view('admin.orders.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $response = Http::post(env('BE_API_URL', 'http://localhost:8000') . '/api/orders', $data);
        if ($response->successful()) {
            return redirect()->route('admin.orders.index')->with('success', 'Tạo đơn hàng thành công.');
        }
        return back()->withErrors('Lỗi khi tạo đơn hàng');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $response = Http::get(env('BE_API_URL', 'http://localhost:8000') . "/api/orders/{$id}");
        $order = $response->json() ?? [];
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Http::get(env('BE_API_URL', 'http://localhost:8000') . "/api/orders/{$id}")->json() ?? [];
        $customers = Http::get(env('BE_API_URL', 'http://localhost:8000') . '/api/customers')->json() ?? [];
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $response = Http::put(env('BE_API_URL', 'http://localhost:8000') . "/api/orders/{$id}", $data);
        if ($response->successful()) {
            return redirect()->route('admin.orders.index')->with('success', 'Cập nhật đơn hàng thành công.');
        }
        return back()->withErrors('Lỗi khi cập nhật đơn hàng');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = Http::delete(env('BE_API_URL', 'http://localhost:8000') . "/api/orders/{$id}");
        if ($response->successful()) {
            return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công.');
        }
        return back()->withErrors('Lỗi khi xóa đơn hàng');
    }
}
