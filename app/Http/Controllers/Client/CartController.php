<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Hiển thị form đặt hàng (checkout)
    public function checkout()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng trống!');
        }
        // Lấy thông tin customer từ cookie nếu có
        $customerInfo = null;
        if (request()->hasCookie('customer_info')) {
            $customerInfo = json_decode(request()->cookie('customer_info'), true);
        }
        return view('client.order.checkout', compact('cart', 'customerInfo'));
    }

    // Xử lý đặt hàng
    public function processCheckout(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng trống!');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
        ]);
        // Lưu thông tin khách hàng vào cookie (30 ngày)
        cookie()->queue(cookie('customer_info', json_encode($validated), 60 * 24 * 30));
        // TODO: Gọi API hoặc lưu vào DB: tạo customer nếu chưa có, tạo order với customer_id, tổng tiền, đặt cọc 30%
        // Sau khi đặt hàng thành công:
        Session::forget('cart');
        return redirect()->route('client.cart.index')->with('success', 'Đặt hàng thành công!');
    }
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = Session::get('cart', []);
        $productIds = collect($cart)->pluck('product_id')->all();
        $products = [];
        if (!empty($productIds)) {
            $products = \App\Helpers\ProductHelper::getProductsByIds($productIds);
        }
        // Map product_id => product info for easy lookup
        $productMap = [];
        foreach ($products as $prod) {
            if (isset($prod['id'])) {
                $productMap[$prod['id']] = $prod;
            }
        }
        // Đảm bảo luôn truyền biến productMap (dù rỗng)
        return view('client.order.cart', [
            'cart' => $cart,
            'productMap' => $productMap
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity
            ];
        }
        Session::put('cart', $cart);
        return redirect()->route('client.cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        unset($cart[$id]);
        Session::put('cart', $cart);
        return redirect()->route('client.cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    // Cập nhật số lượng sản phẩm
    public function update(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }
        return redirect()->route('client.cart.index')->with('success', 'Đã cập nhật số lượng!');
    }

    // ...existing code...
}
