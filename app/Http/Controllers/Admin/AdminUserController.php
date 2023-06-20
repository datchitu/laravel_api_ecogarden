<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        $viewData = [
            'users' => $users
        ];

        return view('admin.pages.user.index', $viewData);
    }

    public function delete(Request  $request, $id)
    {
        Order::whereHas('transactions', function ($q) use ($id){
                $q->where('user_id', $id);
        })->delete();

        User::find($id)->delete();
        return redirect()->back();
    }
}
