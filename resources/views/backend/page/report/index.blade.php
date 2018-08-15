@extends('backend.layouts.master')
@section('title')
Tổng Hợp
@stop
@section('link')
    <style>
        .small-box{
            height: 220px;
        }
        .small-box>.small-box-footer {
            position: absolute;
            text-align: center;
            width: 100%;
            bottom: 0px;
            padding: 3px 0;
            color: #fff;
            color: rgba(255,255,255,0.8);
            display: block;
            z-index: 10;
            background: rgba(0,0,0,0.1);
            text-decoration: none;
        }
    </style>
@stop
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>Tổng:{{$dataLogPayCard->count_order}}</h3>
                <p>Log Nạp Đúng: {{$dataLogPayCard->log_true}}</p>
                <p>Log Nạp Sai Mệnh Giá: {{$dataLogPayCard->log_false}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{URL::route('pay-card.index')}}" style="margin-top: 60px;" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><b>Tổng:{{$dataPhone->count_phone}}</b></h3>
                <p>Số điện thoại mới: {{$dataPhone->phone_new}}</p>
                <p>Số điện thoại đang nạp: {{$dataPhone->phone_start}}</p>
                <p>Số điện thoại nạp thành công: {{$dataPhone->phone_success}}</p>
                <p>Số điện thoại tạm dừng: {{$dataPhone->phone_stop}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{URL::route('phone.index')}}" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>Tổng: {{$dataUser}}</h3>

                <p>User Hệ Thống</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Xem thêm<i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>69</h3>

                <p>Chờ....</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->

@stop