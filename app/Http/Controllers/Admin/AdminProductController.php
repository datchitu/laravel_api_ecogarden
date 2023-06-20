<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\CreateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(20);
        $viewData = [
            'products' => $products
        ];

        return view('admin.pages.product.index', $viewData);
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.pages.product.create', compact('categories'));
    }

    public function store(CreateProductRequest $request)
    {
        $data               = $request->except('token','avatar');
        $data['slug']       = Str::slug($request->name);
        $data['created_at'] = Carbon::now();
        if ($request->avatar) {
            $image = upload_image('avatar');
            if ($image['code'] == 1)
                $data['avatar'] = $image['name'];
        }

        $product = Product::create($data);

        return redirect()->route('get_admin.product.index');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('admin.pages.product.update', compact('product','categories'));
    }

    public function update(CreateProductRequest $request, $id) {
        $data               = $request->except('token','avatar');
        $data['slug']       = Str::slug($request->name);
        $data['updated_at'] = Carbon::now();
        if ($request->avatar) {
            $image = upload_image('avatar');
            if ($image['code'] == 1)
                $data['avatar'] = $image['name'];
        }
        Product::find($id)->update($data);
        return redirect()->route('get_admin.product.index');
    }
}
