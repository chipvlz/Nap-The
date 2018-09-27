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
                        <form action="{{URL::route('post-add-card')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group has-feedback {{($errors->has('card_code'))?"has-error":""}}">
                                <input type="text" class="form-control" value="{{old('card_code')}}" name="card_code" placeholder="Mã thẻ">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                <p class="text-danger">{{$errors->first('card_code')}}</p>
                            </div>
                            <div class="form-group has-feedback {{($errors->has('card_seri'))?"has-error":""}}">
                                <input type="text" class="form-control" value="{{old('card_seri')}}" name="card_seri" placeholder="Seri thẻ">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                <p class="text-danger">{{$errors->first('card_seri')}}</p>
                            </div>
                            <div class="form-group has-feedback {{($errors->has('money'))?"has-error":""}}">
                                <input type="number" name="money" value="{{old('money')}}" class="form-control" placeholder="Số tiền">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                <p class="text-danger">{{$errors->first('money')}}</p>
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