<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(20);
        $viewData = [
            'categories' => $categories
        ];

        return view('admin.pages.category.index', $viewData);
    }

    public function create()
    {
        return view('admin.pages.category.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        $data               = $request->except('token','avatar');
        $data['slug']       = Str::slug($request->name);
        $data['created_at'] = Carbon::now();
        if ($request->avatar) {
            $image = upload_image('avatar');
            if ($image['code'] == 1)
                $data['avatar'] = $image['name'];
        }
        $category = Category::create($data);

        return redirect()->route('get_admin.category.index');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.pages.category.update', compact('category'));
    }

    public function update(CreateCategoryRequest $request, $id) {
        $data               = $request->except('token','avatar');
        $data['slug']       = Str::slug($request->name);
        $data['updated_at'] = Carbon::now();
        if ($request->avatar) {
            $image = upload_image('avatar');
            if ($image['code'] == 1)
                $data['avatar'] = $image['name'];
        }
        $category = Category::find($id)->update($data);
        return redirect()->route('get_admin.category.index');
    }
}
