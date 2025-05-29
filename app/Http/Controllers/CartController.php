<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('shop.cart', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image
            ];
        }

        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function update(Request $request, $productId)
    {
        $cart = Session::get('cart', []);
        $quantity = $request->input('quantity');

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]);
            }
        }

        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Корзина обновлена');
    }

    public function remove($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Товар удален из корзины');
    }

    public function clear()
    {
        Session::forget('cart');
        return redirect()->back()->with('success', 'Корзина очищена');
    }
}
