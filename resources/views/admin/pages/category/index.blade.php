@extends('admin.layouts.master')
@section('content')
    <div class="col-lg-11 col-xl-9">
        <section class="py-4 py-lg-5">
            <h3 class="display-5 mb-3">Danh mục</h3>
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel" id="profile">
                            <div class="media mb-4">
                                <a href="{{ route('get_admin.category.create') }}" class="btn btn-secondary">Thêm mới</a>
                            </div>
                            <!--end of avatar-->
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Mame</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Hot</th>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    @foreach($categories ?? [] as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->slug }}</td>
                                            <td>{{ $item->hot == 1 ? "Nổi bật" : "Mặc định" }}</td>
                                            <td>
                                                <img src="{{ pare_url_file($item->avatar) }}" style="width: 40px;height: 40px" alt="">
                                            </td>
                                            <td>
                                                <a href="{{ route('get_admin.category.update', $item->id) }}" class="text-info">Edit</a>
{{--                                                <a href="" class="text-danger">Delete</a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
