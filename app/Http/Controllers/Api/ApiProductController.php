<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\CategoryService;
use App\Service\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiProductController extends Controller
{
    public function index(Request $request)
    {
        try{

            $products = ProductService::index($request);

            return response()->json([
                'data' => $products
            ], 200);

        }catch (\Exception $exception) {
            Log::error("ApiProductController@index => File:  ".
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

            $product = ProductService::show($request, $id);

            return response()->json([
                'data' => $product
            ], 200);

        }catch (\Exception $exception) {
            Log::error("ApiProductController@show => File:  ".
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

            $product = ProductService::showBySlug($request, $slug);
            return response()->json([
                'data' => $product
            ], 200);

        }catch (\Exception $exception) {
            Log::error("ApiProductController@showBySlug => File:  ".
                $exception->getFile(). " Line: ".
                $exception->getLine() ." Message: ".
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }
}
