<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ProductService;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiUserController extends Controller
{
    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $user = UserService::update($request, $user->id);
            return response()->json([
                'status' => 'success',
                'data'   => $user
            ], 200);

        } catch ( \Exception $exception ) {
            Log::error("ApiUserController@update => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'status' => 'fail',
                'data'   => []
            ], 501);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::user();
            if (!Hash::check($request->password_old, $user->password)) {
                return response()->json([
                    'status' => 'fail',
                    'data'   => 'Mật khẩu không khớp'
                ], 501);
            }

            $user->password = bcrypt($request->password_new);
            $user->save();

            return response()->json([
                'status' => 'success',
                'data'   => $user
            ], 200);

        } catch ( \Exception $exception ) {
            Log::error("ApiUserController@update => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'status' => 'fail',
                'data'   => []
            ], 501);
        }
    }
}
