<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================
// トップ（商品一覧）
// =========================
Route::get('/', function () {
    $products = Product::all();
    return view('products.index', compact('products'));
});

// =========================
// カート・注文（ログイン必須）
// =========================
Route::middleware('auth')->group(function () {

    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/order/checkout', [OrderController::class, 'checkout']);

});

Route::get('/dashboard', function () {
    return redirect('/');
});


// =========================
// 認証ルート（Breeze）
// =========================
require __DIR__.'/auth.php';