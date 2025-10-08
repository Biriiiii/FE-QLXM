<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use \App\Http\Controllers\Admin\CustomerController;
use \App\Http\Controllers\Admin\OrderController;
use \App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\AuthController;

// Client Controllers
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\MotorcycleController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\ContactController;
use \App\Http\Controllers\Client\BrandClientController;
// Client Routes
Route::name('client.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/motorcycles', [MotorcycleController::class, 'index'])->name('motorcycles');
    Route::get('/motorcycles/{id}', [MotorcycleController::class, 'show'])->name('motorcycles.show');
    // Thay thế brands bằng controller mới
    Route::get('/brands', [BrandClientController::class, 'index'])->name('brands');
    Route::get('/brands/{id}', [BrandClientController::class, 'show'])->name('brands.show');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

    // Test image route - không cần token
    Route::get('/test-image', function () {
        return view('test-image');
    })->name('test.image');

    // Test product route
    Route::get('/test-product/{id}', [MotorcycleController::class, 'show'])->name('test.product');
    Route::get('/test-product', function () {
        return view('test-product');
    })->name('test.product.index');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot', [AuthController::class, 'showForgot'])->name('auth.forgot');
    Route::post('/forgot', [AuthController::class, 'forgot']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
});
