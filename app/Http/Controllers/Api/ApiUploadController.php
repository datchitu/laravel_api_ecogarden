<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        try{
            $this->validate($request, [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            $file = upload_image('image');
            $image = null;

            if ($file['code'] == 1)
            {
                $image = pare_url_file($file['name']);
            }else {

                if ($file['code'] == 0)
                {
                    return response()->json([
                        'status' => 'fail',
                        'data' => []
                    ], 501);
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'image' => $image
                ]
            ], 200);

        }catch (\Exception $exception) {
            Log::error("ApiUploadController@uploadImage => File:  \n".
                $exception->getFile(). " Line: \n".
                $exception->getLine() ." Message: \n".
                $exception->getMessage()) . '\n\n\n\n\n';
            return response()->json([
                'status' => 'fail',
                'data' => []
            ], 501);
        }
    }
}
