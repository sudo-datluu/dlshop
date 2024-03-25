<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index() {}

    public function create() {
        return view('admin.category.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);
        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request -> name;
            $category->slug = $request -> slug;
            $category->save();
        } else {
            return response() -> json([
                'status' => true,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit() {}

    public function update() {}

    public function destroy() {}

}
