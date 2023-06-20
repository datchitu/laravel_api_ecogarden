@extends('admin.layouts.master')
@section('content')
    <style>
        .success {
            color: #155724;
            font-weight: bold;
        }
        .danger {
            color: #721c24;
            font-weight: bold;
        }
        .default {color: #383d41; font-weight: bold}
        .warning {color: #856404; font-weight: bold}
        .pagination {
            display: inline-block;
        }

        .pagination li {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
        }
        
        .pagination li a{
            padding: 8px 16px;
            text-decoration: none;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
            border-radius: 5px;
        }
    </style>
    <div class="col-lg-11">
        <section class="py-4 py-lg-5">
            <h3 class="display-5 mb-3">Đơn hàng</h3>
            <form class="form-inline" action="">
                
                <input type="number" value="{{ Request::get('id')}}" name="id" class="form-control mb-2 mr-sm-2" placeholder="Mã đơn" >
                
                <select name="order_type" id="" class="form-control mb-2 mr-sm-2">
                    <option value="">------------</option>
                    <option value="1" {{ Request::get('order_type') == 1 ? "selected" : ""}}>TT tại quầy</option>
                    <option value="2" {{ Request::get('order_type') == 2 ? "selected" : ""}}>TT Online</option>
                </select>
                <input type="date" name="form" class="form-control mb-2 mr-sm-2" value="{{ Request::get('form') }}">
                <input type="date" name="to" class="form-control mb-2 mr-sm-2" value="{{ Request::get('to') }}">
                <select name="status" id="" class="form-control mb-2 mr-sm-2">
                    <option value="">------Trạng thái------</option>
                    @foreach($status ?? [] as $item)
                        <option value="{{ $item['status'] }}" {{ Request::get('status') == $item['status'] ? "selected" : ""}}>{{ $item['name'] }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary mb-2">Lọc</button>
              </form>
            <div class="card">
                <div class="card-body">
                    <p>Tổng số <b>{{ $orders->total() ?? 0 }}</b> đơn hàng, tổng tiền <b>{{ number_format($orderTotalMoney ?? 0,0,',','.') }} VNĐ</b></p>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel" id="profile">
                            <!--end of avatar-->
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Người nhận</th>
                                        <th scope="col">Tổng tiền</th>
                                        <th scope="col">Số SP</th>
                                        <th scope="col">Ghi chú</th>
                                        <th scope="col">Loại thanh toán</th>
                                        <th scope="col">Thanh toán</th>
                                        <th scope="col">Vận chuyển</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    @foreach($orders ?? [] as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>
                                                <ul>
                                                    <li>{{ $item->receiver_name }}</li>
                                                    <li>{{ $item->receiver_phone }}</li>
                                                    <li>{{ $item->receiver_address }}</li>
                                                </ul>
                                            </td>
                                            <td>
                                                {{ number_format($item->total_money,0,',','.') }} đ
                                                @if($item->discount)
                                                    <br>
                                                    <span>- {{ number_format($item->discount,0,',','.') }} đ</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->transactions_count }} SP</td>
                                            <td>{{ $item->note }}</td>
                                            <td>{{ $item->order_type == 1 ? "Tại quầy" : "Online" }}</td>
                                            <td>
                                                <span class="{{ $item->getStatus($item->status)['class'] ?? "" }}">{{ $item->getStatus($item->status)['name'] ?? "" }}</span>
                                            </td>
                                            <td>
                                                <span class="{{ $item->getStatusShippingConfig($item->shipping_status)['class'] ?? "" }}">{{ $item->getStatusShippingConfig($item->shipping_status)['name'] ?? "" }}</span>
                                            </td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <a href="{{ route('get_admin.order.update', $item->id) }}">Cập nhật</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            {!! $orders->links('vendor.pagination.default', ['query' => $query ?? []]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
