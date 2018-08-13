@extends('backend.layouts.master')
@section('link')
@stop
@section('content')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6 col-md-offset-3">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Đổi mật khẩu</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{URL::route('user.post-reset-password')}}" method="post">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group {{($errors->has('password_old'))?"has-error":""}}">
                                <label for="password-old">Mật khẩu cũ</label>
                                <input type="password" class="form-control" name="password_old" id="password-old" placeholder="">
                                <p class="text-danger">{{$errors->first('password_old')}}</p>
                            </div>
                            <div class="form-group {{($errors->has('password_new'))?"has-error":""}}">
                                <label for="password-new">Mật khẩu mới</label>
                                <input type="password" class="form-control" name="password_new" id="password-new" placeholder="">
                                <p class="text-danger">{{$errors->first('password_new')}}</p>
                            </div>
                            <div class="form-group {{($errors->has('confirm_password'))?"has-error":""}}">
                                <label for="confirm-password">Nhập lại mật khẩu mới</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm-password" placeholder="">
                                <p class="text-danger">{{$errors->first('confirm_password')}}</p>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-right">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@stop