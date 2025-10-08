<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.auth.login');
        }
        $apiUrl = env('BE_API_URL', 'http://localhost:8000');
        $token = session('admin_token');
        $products = Http::withToken($token)->get($apiUrl . '/api/products')->json('data') ?? [];
        $customers = Http::withToken($token)->get($apiUrl . '/api/customers')->json('data') ?? [];
        $orders = Http::withToken($token)->get($apiUrl . '/api/orders')->json('data') ?? [];
        $users = Http::withToken($token)->get($apiUrl . '/api/users')->json('data') ?? [];

        $productCount = count($products);
        $customerCount = count($customers);
        $orderCount = count($orders);
        $userCount = count($users);

        $latestOrders = array_slice($orders, 0, 5);
        $latestProducts = array_slice($products, 0, 5);

        return view('admin.dashboard', compact(
            'productCount',
            'customerCount',
            'orderCount',
            'userCount',
            'latestOrders',
            'latestProducts'
        ));
    }
}
