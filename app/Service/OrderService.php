<?php
/**
 * Created by PhpStorm .
 * User: datchitu .
 * Date: 4/14/23 .
 * Time: 5:53 PM .
 */

namespace App\Service;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public static function index(Request $request)
    {
        $orders = Order::with('transactions:id,price,quantity,order_id,name,avatar');
        if ($request->user_id) $orders->where('user_id', $request->user_id);

        $orders = $orders
            ->orderBy('id','DESC')
            ->paginate(20);
        return new OrderCollection($orders);
    }

    public static function add(Request $request)
    {
        try {
            DB::beginTransaction();
            $products = $request->products;

            $totalMoney = 0;
            // Validate product
            foreach ($products as $key => $item) {
                $product = Product::find($item['product_id'] ?? 0);
                if (!$product) {
                    return [
                        'status' => 'fail',
                        'data'   => [
                            'message' => 'ID SP: ' . ($item['product_id'] ?? 0) . ' không tồn tại'
                        ]
                    ];
                }
                // Tổng tiền trong transaction = quantity * price - discount = total_price
                $products[$key]['avatar'] = $product->avatar;
                $totalMoney += $item['quantity'] * $item['price'] - $item['discount'];
            }
            $order = self::createOrder($request, $totalMoney);
            foreach ($products as $item) self::createTransaction($order, $item);

            DB::commit();
            $order = Order::with('transactions')->find($order->id);

            return [
                'status' => 'success',
                'data'   => $order
            ];
        } catch (\Exception $exception) {
            Log::error("OrderService@add => File:  " .
                $exception->getFile() . " Line: " .
                $exception->getLine() . " Message: " .
                $exception->getMessage());
            DB::rollBack();

            return [
                'status' => 'fail',
                'data'   => [
                    'message' => 'Lỗi tạo đơn, xin vui lòng thử lại'
                ]
            ];
        }
    }

    public static function createOrder(Request $request, $totalMoney)
    {
        $order                   = new Order();
        $order->user_id          = $request->user_id ?? 0;
        $order->total_money      = $totalMoney;
        $order->discount         = $request->discount ?? 0;
        $order->receiver_name    = $request->name;
        $order->receiver_email   = $request->email;
        $order->receiver_phone   = $request->phone;
        $order->receiver_address = $request->address;
        $order->order_type       = $request->order_type ?? 1;
        $order->note             = $request->note;
        $order->status           = 1;
        $order->created_at       = Carbon::now();
        $order->save();

        return $order;
    }

    public static function createTransaction($order, $product = [])
    {
        $transaction             = new Transaction();
        $transaction->order_id   = $order->id;
        $transaction->product_id = $product['product_id'] ?? 0;
        $transaction->price      = $product['price'] ?? 0;
        $transaction->quantity   = $product['quantity'] ?? 1;
        $transaction->discount   = $product['discount'] ?? 0;
        $transaction->name       = $product['name'] ?? "";
        $transaction->avatar     = pare_url_file($product['avatar'] ?? "");
        $transaction->status     = $order->status;
        $transaction->created_at = Carbon::now();
        $transaction->save();
        return $transaction;
    }

    public static function findById(Request $request, $id)
    {
        return Order::find($id);
    }

    public static function updateStatus($order, $status)
    {
        $order->status     = $status;
        $order->updated_at = Carbon::now();
        $order->save();
        return $order;
    }

    public static function show(Request $request, $id)
    {
        $order = Order::with('transactions:id,price,quantity,order_id,name,avatar')->find($id);
        $order = new OrderResource($order);
        return [
            'status' => 'success',
            'data'   => $order
        ];
    }

}
