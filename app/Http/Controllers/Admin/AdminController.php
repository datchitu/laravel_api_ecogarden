<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;


class AdminController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')
            ->limit(10)
            ->get();

        $products = Product::with('category:id,name')
            ->limit(10)
            ->orderByDesc('id')
            ->get();

        $countUser = User::count();
        $countProduct = Product::count();
        $countOrder = Order::count();


        // Doanh thu ngày
        $totalMoneyDay = Order::whereDay('created_at', date('d'))
            ->where('status', 4)
            ->sum('total_money');

        // doanh thu thag
        $totalMoneyMonth = Order::whereMonth('created_at', date('m'))
            ->where('status', Order::STATUS_PAID)
            ->sum('total_money');

        // doanh thu nam
        $totalMoneyYear = Order::whereYear('created_at', date('Y'))
            ->where('status', Order::STATUS_PAID)
            ->sum('total_money');

        // Doanh thu ngày
        $totalMoneyDayOnline = Order::whereDay('created_at', date('d'))
            ->where([
                'status' => 4,
                'order_type' => 1
            ])
            ->sum('total_money');

        // doanh thu thag tại quầy
        $totalMoneyMonthOnline = Order::whereMonth('created_at', date('m'))
            ->where([
                'status' => Order::STATUS_PAID,
                'order_type' => 1
            ])
            ->sum('total_money');

        // doanh thu nam tại quầy
        $totalMoneyYearOnline = Order::whereYear('created_at', date('Y'))
            ->where([
                'status' => Order::STATUS_PAID,
                'order_type' => 1
            ])
            ->sum('total_money');

        $viewData = [
            'users' => $users,
            'products' => $products,
            'countUser' => $countUser,
            'countOrder' => $countOrder,
            'countProduct' => $countProduct,
            'totalMoneyDay' => $totalMoneyDay,
            'totalMoneyMonth' => $totalMoneyMonth,
            'totalMoneyYear' => $totalMoneyYear,
            'totalMoneyDayOnline' => $totalMoneyDayOnline,
            'totalMoneyMonthOnline' => $totalMoneyMonthOnline,
            'totalMoneyYearOnline' => $totalMoneyYearOnline,
        ];

        return view('admin.pages.index', $viewData ?? []);
    }
}
