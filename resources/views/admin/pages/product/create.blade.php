@extends('admin.layouts.master')
@section('content')
    <div class="col-lg-11 col-xl-9">
        <section class="py-4 py-lg-5">
            <h1 class="display-4 mb-3">Thêm mới sản phẩm</h1>
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel" id="profile">
                            <!--end of avatar-->
                            @include('admin.pages.product.form')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
