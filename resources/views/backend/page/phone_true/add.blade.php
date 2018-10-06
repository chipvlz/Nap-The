@extends('backend.layouts.master')
@section('title')
    Nhập Số Điện Thoại
@stop
@section('content')
    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thêm mới đơn hàng</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{URL::route('phone-true.sim-true')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh sách số điện thoại</label>
                                <textarea name="info_phone" required style="font-size: 20px; overflow-y: scroll"  class="form-control" id="" cols="30" rows="6"></textarea>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiền Nạp</label>
                                <input type="number" name="money" class="form-control">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@stop