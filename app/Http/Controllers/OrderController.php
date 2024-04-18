<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function order($orderId) {
        $order = Order::find($orderId);
        if ($order == null) {
            abort(404);
        }
        $orderItems = OrderItem::where('order_id', $orderId)->get();
        $data['order'] = $order;
        $data['orderItems'] = $orderItems;
        return view('front.order', $data);
    }
}
