<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCartSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Khởi tạo session nếu chưa có
        if (!$request->hasSession()) {
            $request->setLaravelSession(app('session')->driver());
        }
        
        // Khởi tạo cart trong session nếu chưa có
        if (!$request->session()->has('cart')) {
            $request->session()->put('cart', []);
        }
        
        $response = $next($request);
        
        // Đảm bảo session được lưu
        $request->session()->save();
        
        return $response;
    }
}