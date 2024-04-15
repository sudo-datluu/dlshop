<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubCategory;

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
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = $products->where('sub_category_id', $subCategory->id);
        }

        if (!empty($request->get('search'))) {
            $products = $products->where('title', 'like', '%'.$request->get('search').'%');
        }

        $products = $products->get();
        $data['products'] = $products;
        return view('front.home', $data);
    }

    public function product($slug) {
        $product = Product::where('slug', $slug)->first();
        if ($product == null) {
            abort(404);
        }
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;
        return view('front.product', $data);
    }
}
