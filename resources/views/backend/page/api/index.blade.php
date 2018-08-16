@extends('backend.layouts.master')
@section('title')
    Danh Sách Api Token
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
                                <a href="{{URL::route('api.token')}}" class="btn btn-success"><i class="fa fa-cog" aria-hidden="true"></i> Tạo Key Api</a>
                            </div>
                        </div>
                        <br>
                        <h3 class="box-title">Danh sách key API</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="user-list" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Key API</th>
                                <th>Trạng thái</th>
                                <th width="100px" class="text-center">action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataApi as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td><b>{{$item->token}}</b></td>
                                    <td>
                                        @if ($item->active==1)
                                            <span class="btn btn-success btn-xs"> Đang hoạt động</span>
                                        @else
                                            <span class="btn btn-danger btn-xs"> Ngừng hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->active==1)
                                            <a href="" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Dừng</a>
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