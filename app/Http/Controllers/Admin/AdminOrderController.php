<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user:id,name,email');
        if ($request->id) $orders->where('id', $request->id);
        if ($request->order_type) $orders->where('order_type', $request->order_type);
        if ($request->status) $orders->where('status', $request->status);

        if ($request->form) {
            $start = Carbon::parse($request->form)->startOfDay();
            $orders->where('created_at', '>=', $start);
        }

        if ($request->to) {
            $to = Carbon::parse($request->to)->endOfDay();
            $orders->where('created_at', '<=', $to);
        }


        $ordersTotal = $orders;
        $orderTotalMoney = $ordersTotal->sum('total_money');

        $orders = $orders->withCount('transactions')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $orderModel = new Order();
        $status = $orderModel->statusConfig;

        $viewData = [
            'orders'          => $orders,
            'status'          => $status,
            'orderTotalMoney' => $orderTotalMoney,
            'query'           => $request->query()
        ];

        return view('admin.pages.order.index', $viewData);
    }

    public function edit($id)
    {
        $order = Order::find($id);
        $orderModel = new Order();
        $status = $orderModel->statusConfig;
        $statusShippingConfig = $orderModel->statusShippingConfig;

        return view('admin.pages.order.update', compact('order', 'status', 'statusShippingConfig'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->note = $request->note;
        $order->status = $request->status;
        $order->shipping_status = $request->shipping_status;
        $order->receiver_address = $request->address;
        $order->updated_at = Carbon::now();
        $order->save();
        return redirect()->route('get_admin.order.index');
    }
}
