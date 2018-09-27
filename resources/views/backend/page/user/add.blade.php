@extends('backend.layouts.master')
@section('title')
    Danh Sách User
@stop
@section('link')
    <style>
        .register-box {
            width: 55% !important;
            margin: 0 auto !important;
        }
    </style>
@stop
@section('content')
<section class="add-user">
    <div class="row">
        <div class="col-md-12">
            <div class="register-box">

                <div class="register-box-body">
                    <form action="{{URL::route('user.post-add')}}" method="post">
                        {{csrf_field()}}
                       <div class="row">
                           <div class="col-md-12">
                               <div class="image-avatar text-center">
                                   <img style="margin-bottom: 5px; width: 100px; height: 100px; cursor: pointer" id="label-image"  title="click để thêm ảnh" src="{{asset('backend/dist/img/avatar_add.png')}}" alt="">
                                   <input type="hidden" name="image" value="{{old('image')}}" id="image-add-user">
                               </div>
                           </div>
                       </div>
                        <div class="form-group has-feedback {{($errors->has('fullname'))?"has-error":""}}">
                            <input type="text" class="form-control" value="{{old('fullname')}}" name="fullname" placeholder="Họ Tên">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            <p class="text-danger">{{$errors->first('fullname')}}</p>
                        </div>
                        <div class="form-group has-feedback {{($errors->has('name'))?"has-error":""}}">
                            <input type="text" class="form-control" value="{{old('name')}}" name="name" placeholder="Username">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            <p class="text-danger">{{$errors->first('name')}}</p>
                        </div>
                        <div class="form-group has-feedback {{($errors->has('email'))?"has-error":""}}">
                            <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            <p class="text-danger">{{$errors->first('email')}}</p>
                        </div>
                        <div class="form-group has-feedback {{($errors->has('token'))?"has-error":""}}">
                            <input type="text" class="form-control" value="{{old('token')}}" name="token" placeholder="key API">
                            <span class="glyphicon glyphicon-check form-control-feedback"></span>
                            <p class="text-danger">{{$errors->first('token')}}</p>
                        </div>
                        <div class="form-group has-feedback {{($errors->has('phone'))?"has-error":""}}">
                            <input type="text" class="form-control"  value="{{old('phone')}}" name="phone" placeholder="Số điện thoại">
                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                            <p class="text-danger">{{$errors->first('phone')}}</p>
                        </div>
                        <div class="form-group has-feedback {{($errors->has('password'))?"has-error":""}}">
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            <p class="text-danger">{{$errors->first('password')}}</p>
                        </div>
                        <div class="form-group has-feedback {{($errors->has('confirm_password'))?"has-error":""}}">
                            <input type="password" class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu">
                            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            <p class="text-danger">{{$errors->first('confirm_password')}}</p>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat text-center">Thêm mới</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.form-box -->
            </div>
        </div>
    </div>
</section>
@stop
@section('script')
    <script>
        $(document).on('click', '#label-image', function () {
            $('#imageModalLogo').modal('show');
            $("#imageModalLogo").on('hidden.bs.modal', function(e) {
                var image=$('#image-add-user').val();
                $('#label-image').attr('src', image);
            });
        });
    </script>
@stop