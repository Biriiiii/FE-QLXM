<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Helpers\ProductHelper; // 👈 1. Đảm bảo đã import Helper

class CartController extends Controller
{
    // ... (Hàm getCart() và saveCart() của bạn đã tốt, giữ nguyên) ...

    private function getCart()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            $cartCookie = Cookie::get('cart');
            if ($cartCookie) {
                $cart = json_decode($cartCookie, true) ?: [];
                Session::put('cart', $cart);
                Session::save();
            }
        }
        return $cart;
    }

    private function saveCart($cart)
    {
        Session::put('cart', $cart);
        Session::save();
        Cookie::queue('cart', json_encode($cart), 60 * 24 * 30);
    }

    /**
     * TỐI ƯU HÓA:
     * Hàm index() giờ đây không cần gọi API nào, 
     * nó chỉ đọc dữ liệu đã được lưu sẵn trong session.
     */
    public function index()
    {
        $cart = $this->getCart();
        $cartItems = [];
        $totalPrice = 0;

        foreach ($cart as $id => $item) {
            // Lấy trực tiếp thông tin đã lưu từ session
            $subtotal = ($item['price'] ?? 0) * $item['quantity'];
            $cartItems[] = [
                'id' => $id,
                'name' => $item['name'] ?? 'Sản phẩm không rõ',
                'price' => $item['price'] ?? 0,
                'image_url' => $item['image_url'] ?? asset('img/product_01.jpg'), // Ảnh placeholder
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal
            ];
            $totalPrice += $subtotal;
        }

        return view('client.cart.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * TỐI ƯU HÓA:
     * Hàm add() sẽ gọi API 1 lần để lấy chi tiết sản phẩm
     * và lưu vào session.
     */
    public function add(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $quantity = (int) $request->input('quantity', 1);

            // 1. Lấy thông tin chi tiết sản phẩm TỪ API (1 lần duy nhất)
            $product = ProductHelper::getProductById($productId);

            // 2. Kiểm tra sản phẩm có tồn tại không
            if (!$product || !isset($product['id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy sản phẩm.'
                ], 404);
            }

            $cart = $this->getCart();

            if (isset($cart[$productId])) {
                // 3. Nếu đã có, chỉ cập nhật số lượng
                $cart[$productId]['quantity'] += $quantity;
            } else {
                // 4. Nếu là sản phẩm mới, lưu chi tiết vào giỏ hàng
                $cart[$productId] = [
                    'quantity' => $quantity,
                    'name' => $product['name'] ?? 'Không rõ tên',
                    'price' => $product['price'] ?? 0,
                    'image_url' => $product['image_url'] ?? null, // Lấy từ helper
                ];
            }

            $this->saveCart($cart);

            $cartCount = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm vào giỏ hàng: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi máy chủ khi thêm vào giỏ hàng.'
            ], 500);
        }
    }

    /**
     * Cập nhật số lượng sản phẩm (Đã tối ưu)
     */
    public function update(Request $request, $id)
    {
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            return $this->remove($id);
        }

        $cart = $this->getCart();

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity; // Chỉ cập nhật số lượng
            $this->saveCart($cart);
        }

        return redirect()->route('client.cart.index')->with('success', 'Đã cập nhật giỏ hàng!');
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng (Không đổi)
     */
    public function remove($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->saveCart($cart);
        }

        return redirect()->route('client.cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    /**
     * Đếm số sản phẩm trong giỏ hàng (Không đổi)
     */
    public function count()
    {
        $cart = $this->getCart();
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'cartCount' => $cartCount
        ]);
    }
}
