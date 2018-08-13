@extends('backend.layouts.master')
@section('link')
@stop
@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{asset('backend/dist/img/user4-128x128.jpg')}}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{(!empty(Auth::user()->name))?Auth::user()->name:"GUEST"}}</h3>

                        <p class="text-muted text-center">{{(!empty(Auth::user()->fullname))?Auth::user()->fullname:"GUEST"}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="pull-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="pull-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="pull-right">13,287</a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
@stop