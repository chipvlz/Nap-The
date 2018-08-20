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
                    <form role="form" method="post" action="{{URL::route('phone.sim')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Danh sách số điện thoại</label>
                                <textarea name="info_phone" required style="font-size: 20px; overflow-y: scroll"  class="form-control" id="" cols="30" rows="6"></textarea>
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

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Upload file</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{URL::route('phone.upload')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputFile">Nhập file</label>
                                <input type="file" name="file" id="exampleInputFile">

                                <p class="help-block">Chọn file excel theo mẫu để thực hiện thêm danh sách </p>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{url('uploads/template/template _card.xlsx')}}" class="btn btn-danger">Download file mẫu</a>
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop