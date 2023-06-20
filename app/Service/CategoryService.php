<?php
/**
 * Created by PhpStorm .
 * User: datchitu .
 * Date: 4/10/23 .
 * Time: 2:46 AM .
 */

namespace App\Service;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService
{
    public static function index(Request $request)
    {
        $categories = Category::paginate(6);
        return  new CategoryCollection($categories);
    }

    public static function show(Request $request, $id)
    {
        $category = Category::find($id);
        return new CategoryResource($category);
    }
    
    public static function showBySlug(Request $request, $slug)
    {
        $category = Category::where('slug',$slug)->first();
        return new CategoryResource($category);
    }
}
