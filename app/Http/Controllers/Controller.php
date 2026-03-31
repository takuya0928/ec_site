<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

class CartController extends Controller
{
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        $productId = $request->product_id;

        $cart[$productId] = ($cart[$productId] ?? 0) + 1;

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'added',
            'count' => array_sum($cart)
        ]);
    }

    public function count()
    {
        $cart = session()->get('cart', []);

        return response()->json([
            'count' => array_sum($cart)
        ]);
    }
}

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['message' => 'カートが空です'], 400);
        }

        DB::transaction(function () use ($cart) {

            // ① 注文作成
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => 0
            ]);

            $total = 0;

            foreach ($cart as $productId => $qty) {

                $product = Product::lockForUpdate()->find($productId);

                // 在庫チェック
                if (!$product || $product->stock < $qty) {
                    throw new \Exception('在庫不足');
                }

                // ② 注文明細作成
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'price' => $product->price,
                    'quantity' => $qty
                ]);

                // ③ 在庫減少
                $product->stock -= $qty;
                $product->save();

                $total += $product->price * $qty;
            }

            // 合計更新
            $order->total = $total;
            $order->save();

            // ④ カートクリア
            session()->forget('cart');
        });

        return response()->json([
            'message' => '注文完了しました'
        ]);
    }
}