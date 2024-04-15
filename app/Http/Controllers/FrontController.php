<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class FrontController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null) {
        // $products = Product::orderBy('id', 'DESC')->get();
        $products = Product::orderBy('id', 'DESC');
        
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $products = $products->where('category_id', $category->id);
        }

        if (!empty($subCategorySlug)) {
            $subCategory = Category::where('slug', $subCategorySlug)->first();
            $products = $products->where('sub_category_id', $subCategory->id);
        }

        $products = $products->get();
        $data['products'] = $products;
        return view('front.home', $data);
    }
}
