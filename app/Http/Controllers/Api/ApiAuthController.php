<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendEmailResetPassword;
use App\Models\User;
use App\Service\ResponseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = [
                "email"    => $request->email,
                "password" => $request->password
            ];

            if (Auth::attempt($credentials)) {
                $user     = Auth::user();
                $response = $user->createToken('token');
                
                $data     = [
                    'token_info' => $response,
                    'user'       => $user
                ];
                
                return response()->json(ResponseService::getSuccess($data));
            }

            return response()->json(ResponseService::getErrorCode("Đăng nhập thất bại", "ERROR01"));
        } catch (\Exception $exception) {
            Log::error("ApiAuthController@login => File:  \n" .
                $exception->getFile() . " Line: \n" .
                $exception->getLine() . " Message: \n" .
                $exception->getMessage());

            return response()->json(ResponseService::getErrorCode($exception->getMessage(), "ERROR01"), 500);
        }
    }
    
    public function forgotPassword(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'Không tồn tại user'
                ], 501);
            }

            $token = bcrypt($email) . bcrypt($user->id);
            $passwordResets = DB::table('password_resets')
                ->insert([
                    'email' => $email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);

            if (!$passwordResets) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'Xử lý dữ liệu thất bại, xin vui lòng thử lại'
                ], 501);
            }           
            

            $link = "http://localhost:3000/auth/reset-password?token=$token";

            Mail::to($user->email)
            ->cc(env('MAIL_CC'))
            ->queue(new SendEmailResetPassword($user, $link));


            return response()->json(ResponseService::getSuccess([
                'data' => [],
                'message' => 'Xin vui lòng kiểm tra email, link lấy lại mật khẩu đã được gủi vào email của bạn'
            ]));

        } catch (\Exception $exception) {
            Log::error("ApiAuthController@forgotPassword => File:  \n" .
                $exception->getFile() . " Line: \n" .
                $exception->getLine() . " Message: \n" .
                $exception->getMessage());

            return response()->json(ResponseService::getErrorCode($exception->getMessage(), "ERROR01"), 500);
        }
    }
    
    public function resetPassword(Request $request)
    {
        try {
            $token = $request->token;

            $passwordResets = DB::table('password_resets')
                ->where('token', $token)->first();

            if (!$passwordResets) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'Không tồn tại token'
                ], 501);
            }

            User::where('email', $passwordResets->email)
                ->update([
                    'password' => bcrypt($request->password),
                    'updated_at' => Carbon::now()
                ]);

            DB::table('password_resets')
                ->where('token', $token)->delete();

            return response()->json(ResponseService::getSuccess([
                'data' => [],
                'message' => 'Mật khẩu đã được cập nhật, xin vui lòng login lại'
            ]));

        } catch (\Exception $exception) {
            Log::error("ApiAuthController@forgotPassword => File:  \n" .
                $exception->getFile() . " Line: \n" .
                $exception->getLine() . " Message: \n" .
                $exception->getMessage());

            return response()->json(ResponseService::getErrorCode($exception->getMessage(), "ERROR01"), 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $data = [
                "email"    => $request->email,
                "password" => bcrypt($request->password),
                "name"     => $request->name
            ];

            $user = User::create($data);
            if ($user) {
                if (Auth::attempt([
                    "email"    => $request->email,
                    "password" => $request->password,
                ])) {
                    $user     = Auth::user();
                    $response = $user->createToken('token');
                    $data     = [
                        'token_info' => $response,
                        'user'       => $user
                    ];
                    return response()->json(ResponseService::getSuccess($data));
                }

                return response()->json(ResponseService::getErrorCode("Đăng nhập thất bại", "ERROR01"));
            }

            return response()->json(ResponseService::getErrorCode("Đăng ký thất bại", "ERROR03"));
        } catch (\Exception $exception) {
            Log::error("ApiAuthController@register => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }

    public function info(Request $request)
    {
        try {
            $user = Auth::user();
            return response()->json(ResponseService::getSuccess([
                'user' => $user
            ]));

        } catch (\Exception $exception) {
            Log::error("ApiAuthController@info => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }

    public function loginSocial(Request $request, $social)
    {
        try {
            $user = DB::table('users')
                ->where('email', $request->email)
                ->first();
            
            if (!$user) {
                $user = new User();
                $user->email = $request->email;
                $user->avatar = $request->avatar;
                $user->name = $request->name;
                $user->password = bcrypt($request->provider_id);
                $user->save();
            }
            
            if (Auth::loginUsingId($user->id)) {
                $user     = Auth::user();
                $response = $user->createToken('token');
                $data     = [
                    'token_info' => $response
                ];
               
                return response()->json(ResponseService::getSuccess($data));
            }

            Log::info("----------- userLogin FIAL: ");

        } catch (\Exception $exception) {
            Log::error("ApiAuthController@info => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }
}
