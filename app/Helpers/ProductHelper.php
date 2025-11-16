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
        $apiUrl = config('app.be_api_url', 'https://be-qlxm-9b1bc6070adf.herokuapp.com');
        try {
            // Sử dụng client endpoint
            $response = Http::get($apiUrl . '/api/client/products', ['ids' => implode(',', $ids)]);
            if ($response->successful()) {
                return $response->json('data') ?? [];
            }
        } catch (\Exception $e) {
            // Log error nếu cần
        }
        return [];
    }

    /**
     * Lấy thông tin một sản phẩm theo ID
     * @param int $id
     * @return array|null
     */
    public static function getProductById($id)
    {
        $apiUrl = config('app.be_api_url', 'https://be-qlxm-9b1bc6070adf.herokuapp.com');
        try {
            // Sử dụng client endpoint giống như MotorcycleController
            $response = Http::timeout(10)->get($apiUrl . '/api/client/products/' . $id);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Thử nhiều cách lấy data
                if (isset($data['data'])) {
                    return $data['data'];
                } elseif (isset($data['product'])) {
                    return $data['product'];
                } elseif (is_array($data) && !empty($data)) {
                    return $data;
                }
            }
        } catch (\Exception $e) {
            // Log lỗi nếu cần
        }
        return null;
    }
}
