<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Models\Product;

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
// カート関連（ログイン必須）
// =========================
Route::middleware('auth')->group(function () {

    // カート画面
    Route::get('/cart', function () {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();

        return view('cart.index', compact('products', 'cart'));
    });

    // カート追加
    Route::post('/cart/add', [CartController::class, 'add']);

    // カート削除
    Route::post('/cart/remove', function (Request $request) {
        $cart = session()->get('cart', []);

        unset($cart[$request->product_id]);

        session()->put('cart', $cart);

        return redirect('/cart');
    });

    // カート件数取得（非同期用）
    Route::get('/cart/count', [CartController::class, 'count']);

    // 注文処理（トランザクション）
    Route::post('/order/checkout', [OrderController::class, 'checkout']);

});


// =========================
// プロフィール（Breeze標準）
// =========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// =========================
// ログアウト
// =========================
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/');
});

Route::post('/order/checkout', function () {

    DB::transaction(function () {

        $cart = session()->get('cart', []);

        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\Product::lockForUpdate()->find($productId);

            if (!$product || $product->stock < $quantity) {
                abort(400, '在庫不足');
            }

            $product->stock -= $quantity;
            $product->save();
        }

        session()->forget('cart');
    });

    return response()->json([
        'message' => '注文完了しました'
    ]);
})->middleware('auth');


// =========================
// 認証ルート（Breeze）
// =========================
require __DIR__.'/auth.php';