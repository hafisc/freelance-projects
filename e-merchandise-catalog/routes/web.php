<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/product/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::get('/complete-profile', [AuthController::class, 'showCompleteProfile'])->name('profile.complete');
Route::post('/complete-profile', [AuthController::class, 'completeProfile'])->name('profile.complete.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');

Route::middleware(['auth'])->group(function () {
    Route::resource('cart', CartController::class);
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/midtrans/callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');
    Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
    
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
        Route::get('/orders/{orderNumber}', [CustomerController::class, 'orderDetail'])->name('order.detail');
        Route::get('/orders/{orderNumber}/invoice', [CustomerController::class, 'downloadInvoice'])->name('order.invoice');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::post('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    });
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,panitia'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/banners', [AdminController::class, 'banners'])->name('banners');
    Route::post('/banners', [AdminController::class, 'storeBanner'])->name('banners.store');
    Route::put('/banners/{id}', [AdminController::class, 'updateBanner'])->name('banners.update');
    Route::delete('/banners/{id}', [AdminController::class, 'destroyBanner'])->name('banners.destroy');
    
    Route::get('/users', [AdminController::class, 'users'])->name('users')->middleware('role:admin');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store')->middleware('role:admin');
    
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');
    Route::post('/orders/{id}/pickup', [AdminController::class, 'pickUpOrder'])->name('orders.pickup');
    Route::get('/pickup/{qrCode}', [AdminController::class, 'verifyPickup'])->name('pickup.verify');
    
    Route::get('/vouchers', [AdminController::class, 'vouchers'])->name('vouchers');
    Route::post('/vouchers', [AdminController::class, 'storeVoucher'])->name('vouchers.store');
    Route::delete('/vouchers/{id}', [AdminController::class, 'destroyVoucher'])->name('vouchers.destroy');
    
    Route::get('/export', [AdminController::class, 'exportReport'])->name('export');
    
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
