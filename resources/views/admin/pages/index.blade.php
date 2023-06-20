@extends('admin.layouts.master')
@section('content')
    <style>
        .text-white h6{
            color: white;
        }
    </style>
    <div class="row py-4 py-lg-5">
        <div class="col-sm-4 col-md-4">
            <div class="box p-3 mb-2 bg-primary text-white">
                <h6>Thành viên <b>{{ $countUser ?? 0 }}</b></h6>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="box p-3 mb-2 bg-danger text-white">
                <h6>Sản phẩm <b>{{ $countProduct ?? 0 }}</b></h6>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="box p-3 mb-2 bg-info text-white">
                <h6>Đơn hàng <b>{{ $countOrder ?? 0 }}</b></h6>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="box p-3 mb-2 bg-info text-white">
                <h6>Doanh thu ngày <b>{{ number_format(($totalMoneyDay ?? 0),0,',','.') }} vnđ</b></h6>
                <h6>Doanh thu tại quầy trong ngày <b>{{ number_format(($totalMoneyDayOnline ?? 0),0,',','.') }} vnđ</b></h6>
                <h6>Doanh thu Online trong ngày <b>{{ number_format(($totalMoneyDay- $totalMoneyDayOnline ?? 0),0,',','.') }} vnđ</b></h6>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="box p-3 mb-2 bg-primary text-white">
                <h6>Doanh thu tháng <b>{{ number_format(($totalMoneyMonth ?? 0),0,',','.') }} vnđ</b></h6>
                <h6>Doanh thu tại quầy tháng <b>{{ number_format(($totalMoneyMonthOnline ?? 0),0,',','.') }} vnđ</b></h6>
                <h6>Doanh thu Online tháng <b>{{ number_format(($totalMoneyMonth - $totalMoneyMonthOnline ?? 0),0,',','.') }} vnđ</b></h6>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="box p-3 mb-2 bg-primary text-white">
                <h6>Doanh thu năm <b>{{ number_format(($totalMoneyYear ?? 0),0,',','.') }} vnđ</b></h6>
                <h6>Doanh thu tại quầy năm <b>{{ number_format(($totalMoneyYearOnline ?? 0),0,',','.') }} vnđ</b></h6>
                <h6>Doanh thu Online năm <b>{{ number_format(($totalMoneyYear - $totalMoneyYearOnline ?? 0),0,',','.') }} vnđ</b></h6>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-sm-6 col-md-6">
            <h2>Thành viên mới</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users ?? [] as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <h2>Sản phẩm mới</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products ?? [] as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category->name ?? "[N\A]" }}</td>
                            <td>{{ number_format($item->price,0,',','.') }}đ</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
