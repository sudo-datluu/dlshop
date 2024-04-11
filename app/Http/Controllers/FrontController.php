<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FrontController extends Controller
{
    public function index() {
        $products = Product::orderBy('id', 'DESC')->get();
        $data['products'] = $products;
        return view('front.home', $data);
    }
}
