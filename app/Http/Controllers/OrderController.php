<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/cart')->with('error', 'カートが空です');
        }

        DB::transaction(function () use ($cart) {

            foreach ($cart as $productId => $quantity) {

                $product = Product::lockForUpdate()->find($productId);

                // 在庫チェック
                if (!$product || $product->stock < $quantity) {
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
    }
}