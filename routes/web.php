<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    $products = Product::all();
    return view('products.index', compact('products'));
});

Route::get('/cart', function () {
    $cart = session()->get('cart', []);
    $products = Product::whereIn('id', array_keys($cart))->get();

    return view('cart.index', compact('products', 'cart'));
})->middleware('auth');

Route::post('/cart/add', function (Request $request) {
    $cart = session()->get('cart', []);

    $productId = $request->product_id;

    if (isset($cart[$productId])) {
        $cart[$productId]++;
    } else {
        $cart[$productId] = 1;
    }

    session()->put('cart', $cart);

    return response()->json(['status' => 'ok']);
})->middleware('auth');

Route::post('/cart/remove', function (Request $request) {
    $cart = session()->get('cart', []);

    unset($cart[$request->product_id]);

    session()->put('cart', $cart);

    return redirect('/cart');
})->middleware('auth');

Route::post('/order', function () {

    DB::transaction(function () {

        $cart = session()->get('cart', []);

        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\Product::find($productId);

            // 在庫チェック
            if ($product->stock < $quantity) {
                abort(400, '在庫不足');
            }

            // 在庫減らす
            $product->stock -= $quantity;
            $product->save();
        }

        // カート空にする
        session()->forget('cart');
    });

    return redirect('/')->with('success', '購入完了！');
})->middleware('auth');

require __DIR__.'/auth.php';
