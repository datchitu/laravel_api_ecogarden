<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiCategoryController extends Controller
{
    public function index(Request $request)
    {
        try{

            $categories = CategoryService::index($request);

            return response()->json([
                'data' => $categories
            ], 200);

        }catch (\Exception $exception) {
            Log::error("ApiCategoryController@index => File:  ".
                $exception->getFile(). " Line: ".
                $exception->getLine() ." Message: ".
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }

    public function show(Request $request, $id)
    {
        try{

            $category = CategoryService::show($request, $id);

            return response()->json([
                'data' => $category
            ], 200);

        }catch (\Exception $exception) {
            Log::error("ApiCategoryController@show => File:  ".
                $exception->getFile(). " Line: ".
                $exception->getLine() ." Message: ".
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }
    
    public function showBySlug(Request $request, $slug)
    {
        try{

            $category = CategoryService::showBySlug($request, $slug);

            return response()->json([
                'data' => $category
            ], 200);

        }catch (\Exception $exception) {
            Log::error("ApiCategoryController@show => File:  ".
                $exception->getFile(). " Line: ".
                $exception->getLine() ." Message: ".
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }
}
