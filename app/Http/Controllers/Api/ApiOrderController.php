<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequestApi;
use App\Http\Requests\OrderUpdateStatusRequest;
use App\Models\Order;
use App\Service\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Service;
use App\Service\VnPayService;

class ApiOrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $order = OrderService::index($request);

            return response()->json([
                'status' => 'success',
                'data' => $order
            ], 200);

        } catch (\Exception $exception) {
            Log::error("ApiOrderController@index => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }

    public function add(OrderCreateRequestApi $request)
    {
        try {
            $response = OrderService::add($request);

            if ($response['status'] === 'fail') {
                return response()->json([
                    'status' => 'fail',
                    'data'   => $response['data']
                ], 501);
            }

            $order = $response['data'];
            \Log::info("----------- JSON: ". json_encode($order));
            // thanh toán online
            if ($order->order_type == 2) {
                $link = $this->sendDataVnPay($order);
                $response['data']['link'] = $link;
                \Log::info("----------- JSON responsePay: ". $link);
            }
            return response()->json([
                'status' => 'success',
                'data'   => $response['data']
            ], 200);

        } catch (\Exception $exception) {
            Log::error("ApiOrderController@add => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $response = OrderService::show($request, $id);

            if ($response['status'] === 'fail') {
                return response()->json([
                    'status' => 'fail',
                    'data'   => $response['data']
                ], 501);
            }
            return response()->json([
                'status' => 'success',
                'data'   => $response['data']
            ], 200);

        } catch (\Exception $exception) {
            Log::error("ApiOrderController@show => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }
    
    public function getConfig(Request $request)
    {
        try {
            $config = (new Order())->getConfigStatus();

            return response()->json([
                'status' => 'success',
                'data'   => $config
            ], 200);

        } catch (\Exception $exception) {
            Log::error("ApiOrderController@getConfig => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }

    public function cancelStatusPaid(OrderUpdateStatusRequest $request)
    {
        try {
            $orderID = $request->order_id;
            $order   = OrderService::findById($request, $orderID);
            if (!$order) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'Order ID' . $orderID . ' 404',
                    'data'    => [],
                ], 404);
            }

            $response = OrderService::updateStatus($order, Order::STATUS_CANCEL);

            return response()->json([
                'status' => 'success',
                'data'   => []
            ], 200);

        } catch (\Exception $exception) {
            Log::error("ApiOrderController@show => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }
    
    public function updateStatusPaid(Request $request, $id)
    {
        try {
            $orderID = $id;
            $order   = OrderService::findById($request, $orderID);
            \Log::info('--------------- update');
            if (!$order) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'Order ID' . $orderID . ' 404',
                    'data'    => [],
                ], 404);
            }

            \Log::info('--------------- update');
            $response = OrderService::updateStatus($order, Order::STATUS_PAID);

            return response()->json([
                'status' => 'success',
                'data'   => []
            ], 200);

        } catch (\Exception $exception) {
            Log::error("ApiOrderController@updateStatusPaid => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            return response()->json([
                'data' => []
            ], 501);
        }
    }

    public function sendDataVnPay($data)
    {
        try {

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $vnp_TmnCode    = "C6HDOV04"; //Website ID in VNPAY System
            $vnp_HashSecret = "EELRMOAOQOHRAROKOLEHISOVQPEAIOUK"; //Secret key
            $vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl  = 'http://localhost:3000/order/success';
            $vnp_TxnRef      = $data['id'];
            $vnp_OrderInfo   = 'Nạp tiền';
            $vnp_OrderType   = 'other';
            $vnp_Amount      = $data['total_money'] * 100;
            $vnp_Locale      = 'vn';
            $vnp_BankCode    = 'NCB';
            $vnp_IpAddr      = $_SERVER['REMOTE_ADDR'];
            $vnp_Bill_Mobile = '0986420994';
            $vnp_Bill_Email  = 'codethue94@gmail.com';

            $vnp_Bill_Country = 'VN';

            $vnp_Inv_Phone    = $vnp_Bill_Mobile;
            $vnp_Inv_Email    = $vnp_Bill_Email;
            $vnp_Inv_Customer = 'Phan Trung Phú';
            $vnp_Inv_Address  = 'Hà nội';
            $vnp_Inv_Company  = 'Code thuê 94';
            $vnp_Inv_Taxcode  = '0102182292';
            $vnp_Inv_Type     = 'I';
            $inputData        = array(
                "vnp_Version"      => "2.1.0",
                "vnp_TmnCode"      => $vnp_TmnCode,
                "vnp_Amount"       => $vnp_Amount,
                "vnp_Command"      => "pay",
                "vnp_CreateDate"   => date('YmdHis'),
                "vnp_CurrCode"     => "VND",
                "vnp_IpAddr"       => $vnp_IpAddr,
                "vnp_Locale"       => $vnp_Locale,
                "vnp_OrderInfo"    => $vnp_OrderInfo,
                "vnp_OrderType"    => $vnp_OrderType,
                "vnp_ReturnUrl"    => $vnp_Returnurl,
                "vnp_TxnRef"       => $vnp_TxnRef,
                "vnp_Bill_Mobile"  => $vnp_Bill_Mobile,
                "vnp_Bill_Email"   => $vnp_Bill_Email,
                "vnp_Bill_Country" => $vnp_Bill_Country,
                "vnp_Inv_Phone"    => $vnp_Inv_Phone,
                "vnp_Inv_Email"    => $vnp_Inv_Email,
                "vnp_Inv_Customer" => $vnp_Inv_Customer,
                "vnp_Inv_Address"  => $vnp_Inv_Address,
                "vnp_Inv_Company"  => $vnp_Inv_Company,
                "vnp_Inv_Taxcode"  => $vnp_Inv_Taxcode,
                "vnp_Inv_Type"     => $vnp_Inv_Type
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            ksort($inputData);
            $query    = "";
            $i        = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i        = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
                $vnp_Url       .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
        
            return $vnp_Url;
          
        } catch (\Exception $exception) {
            Log::error("==================== E: " . $exception->getMessage());
            return [];
        }
    }
}

