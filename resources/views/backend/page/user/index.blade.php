@extends('backend.layouts.master')
@section('title')
    Danh Sách User
@stop
@section('link')
    <link rel="stylesheet" href="{{asset('backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{URL::route('user.add')}}" class="btn btn-success">Thêm mới</a>
                            </div>
                        </div>
                        <br>
                        <h3 class="box-title">Danh sách tài khoản</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                        <table id="user-list" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Ảnh</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Họ Tên</th>
                                <th>Ngày Thêm</th>
                                <th width="100px" class="text-center">action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataUser as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td class="text-center">
                                            <img width="100px" height="100px" style="border-radius: 10px" src="{{(!empty($item->image))?$item->image:asset('backend/dist/img/user2-160x160.jpg')}}" alt="">
                                    </td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->fullname}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td class="text-center">
                                        @if($item->id!=1)
                                            <a href="{{URL::route('user.delete',['id'=>$item->id])}}" onclick="return confirm('Bạn có muốn xóa  user này không?')" class="btn btn-danger"><i class="fa fa-trash-o"></i> Xóa</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse

                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('script')
    <script src="{{asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script >
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //datatable
        $('#user-list').DataTable( {
            pagingType: "full_numbers",
            ordering:true,
            info:false,
            dom: 'Bfrtip',
            language: {
                "paginate": {
                    "first":"Đầu",
                    "previous": "Trước",
                    "next":"Tiếp",
                    "last":"cuối"
                },
                "sLengthMenu": "Xem _MENU_ bản ghi",
                "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
                'sSearchPlaceholder':'Tìm kiếm',
                processing: "<div id='divloader'></div>",
            },
            //responsive: true,
            searching: false,
            lengthMenu: [[10, 20,50, 100, 200], [10, 20,50, 100, 200]],

            drawCallback : function() {
                if($('#phone-list tbody .dataTables_empty').length){
                    $('#phone-list tbody tr').hide()
                }
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);
            },
            deferRender: true,
        } );




    </script>
@stop