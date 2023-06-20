@extends('admin.layouts.master')
@section('content')
    <div class="col-lg-11 col-xl-9">
        <section class="py-4 py-lg-5">
            <h3 class="display-5 mb-3">Thành viên</h3>
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel" id="profile">
                            <!--end of avatar-->
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Mame</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    @foreach($users ?? [] as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                <a href="{{ route('get_admin.user.delete', $item->id) }}">Xoá</a>
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
