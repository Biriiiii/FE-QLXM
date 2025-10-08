<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrandClientController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('app.be_api_url', 'http://127.0.0.1:8000');
    }

    public function index(Request $request)
    {
        try {
            $response = Http::timeout(10)->get($this->apiUrl . '/api/client/brands', [
                'page' => $request->get('page', 1)
            ]);
            $brands = [];
            $pagination = null;
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['data'])) {
                    $brands = $data['data'];
                    $pagination = $data['meta'] ?? null;
                } elseif (is_array($data)) {
                    $brands = $data;
                }
            } else {
                Log::error('Brand API Error: ' . $response->status());
            }
            return view('client.brands.index', compact('brands', 'pagination'));
        } catch (\Exception $e) {
            Log::error('BrandClientController Error: ' . $e->getMessage());
            return view('client.brands.index', [
                'brands' => [],
                'pagination' => null,
                'error' => 'Không thể tải dữ liệu từ server'
            ]);
        }
    }

    public function show($id, Request $request)
    {
        try {
            $brandResponse = Http::timeout(10)->get($this->apiUrl . "/api/client/brands/{$id}");
            $brand = null;
            if ($brandResponse->successful()) {
                $data = $brandResponse->json();
                if (isset($data['data']) && is_array($data['data']) && isset($data['data']['name'])) {
                    $brand = $data['data'];
                } elseif (isset($data['name'])) {
                    $brand = $data;
                }
            }

            $productsResponse = Http::timeout(10)->get($this->apiUrl . "/api/client/products", [
                'brand_id' => $id,
                'page' => $request->get('page', 1)
            ]);
            $products = [];
            $pagination = null;
            if ($productsResponse->successful()) {
                $productsData = $productsResponse->json();
                $products = $productsData['data'] ?? [];
                $pagination = $productsData['meta'] ?? null;
            }
            return view('client.brands.brand-detail', compact('brand', 'products', 'pagination'));
        } catch (\Exception $e) {
            Log::error('BrandClientController Show Error: ' . $e->getMessage());
            return view('client.brands.brand-detail', [
                'brand' => [],
                'products' => [],
                'pagination' => null,
                'error' => 'Không thể tải dữ liệu từ server'
            ]);
        }
    }
}
