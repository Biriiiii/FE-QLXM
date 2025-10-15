<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ProductHelper
{
    /**
     * Lấy thông tin sản phẩm từ API theo mảng product_id
     * @param array $ids
     * @return array
     */
    public static function getProductsByIds(array $ids)
    {
        if (empty($ids)) {
            return [];
        }
        $apiUrl = config('app.be_api_url', 'https://be-qlxm-9b1bc6070adf.herokuapp.com/');
        try {
            $response = Http::get($apiUrl . '/api/products', ['ids' => implode(',', $ids)]);
            if ($response->successful()) {
                return $response->json('data') ?? [];
            }
        } catch (\Exception $e) {
            // Log error nếu cần
        }
        return [];
    }
}
