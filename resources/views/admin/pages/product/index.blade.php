@extends('admin.layouts.master')
@section('content')
    <div class="col-lg-11 col-xl-9">
        <section class="py-4 py-lg-5">
            <h3 class="display-5 mb-3">Sản phẩm</h3>
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel" id="profile">
                            <div class="media mb-4">
                                <a href="{{ route('get_admin.product.create') }}" class="btn btn-secondary">Thêm mới</a>
                            </div>
                            <!--end of avatar-->
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Mame</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    @foreach($products ?? [] as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->slug }}</td>
                                            <td>{{ number_format($item->price,0,',','.') }} đ</td>
                                            <td>
                                                <img src="{{ pare_url_file($item->avatar) }}" style="width: 40px;height: 40px" alt="">
                                            </td>
                                            <td>
                                                <a href="{{ route('get_admin.product.update', $item->id) }}" class="text-info">Edit</a>
{{--                                                <a href="" class="text-danger">Delete</a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <div class="d-sm-flex justify-content-sm-between align-items-sm-center mt-2 mt-sm-2">
                                    <!-- Content -->
                                    <p class="mb-sm-0 text-center text-sm-start">
                                        Hiển thị: {{ $products->firstItem() }} to {{ $products->lastItem() }} /
                                        Tổng {{ $products->total() }} record &nbsp;
                                    </p>
                                    <nav class="my-5" aria-label="navigation">
                                        {!! $products->appends($query ?? [])->links('pagination.customer') !!}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
