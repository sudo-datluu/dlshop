<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart (Request $request) {
        $product = Product::find($request->id);
        if ($product == null) {
            return response() -> json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }
        Cart::add($product->id, $product->title, 1, $product->price, [$product->image])->associate('App\Product');
        return response() -> json([
            'status' => true,
            'message' => $product->title . ' has been added to cart'
        ]);
    }

    public function cart() {
        $cartContent = Cart::content();
        $data['cartContent'] = $cartContent;
        return view('front.cart', $data);
    }

    public function cartJson() {
        $cartContent = Cart::content();
        dd($cartContent);
    }

    public function updateCart(Request $request) {
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        $message = 'Cart updated';
        return response() -> json([
            'newSubtotal' => Cart::subtotal(),
            'status' => true,
            'message' => $message
        ]);
    }

    public function deleteCartItem(Request $request) {
        $rowId = $request->rowId;
        Cart::remove($rowId);
        $message = 'Item removed from cart';
        return response() -> json([
            'newSubtotal' => Cart::subtotal(),
            'status' => true,
            'message' => $message
        ]);
    }

    public function clearCart() {
        Cart::destroy();
        return response() -> json([
            'status' => true,
            'message' => 'Cart cleared'
        ]);
    }
}
