<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;

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
        $isEmpty = Cart::count() == 0 ? true : false;
        return response() -> json([
            'isEmpty' => $isEmpty,
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

    public function checkout() {
        if (Cart::count() == 0) {
            return redirect() -> route('front.cart');
        }
        return view('front.checkout');
    }

    public function processCheckout(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);

        if ($validator->fails()) {
            return response() -> json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $qty_errror = [];
        foreach (Cart::content() as $item) {
            $product = Product::find($item->id);
            if ($product->qty < $item->qty) {
                $msg = $product->title . ' quantity can not greater than ' . $product->qty;
                array_push($qty_errror, $msg);
            }
        }

        if ($qty_errror != []) {
            return response() -> json([
                'status' => false,
                'errors' => ['qty_errrors' => $qty_errror]
            ]);
        }

        $order = new Order();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->mobile = $request->mobile;
        $order->street = $request->street;
        $order->city = $request->city;
        $order->state = $request->state;
        $order->total = Cart::subtotal(2, '.', '');
        $order->save();

        foreach (Cart::content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->qty = $item->qty;
            $orderItem->name = $item->name;
            $orderItem->price = $item->price;
            $orderItem->total = $item->price * $item->qty;

            $product = Product::find($item->id);
            $product->qty = $product->qty - $item->qty;
            $product->save();
            $orderItem->save();
        }

        Cart::destroy();

        return response() -> json([
            'status' => true,
            'message' => 'Order placed successfully',
            'order_url' => route('front.order', $order->id)
        ]);
    }
}
