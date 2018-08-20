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
                                <a data-toggle="modal" data-target="#apiModal" class="btn btn-success"><i class="fa fa-cog" aria-hidden="true"></i> Tạo Key Api</a>
                            </div>
                        </div>
                        <br>
                        <h3 class="box-title">Danh sách key API</h3><br>
                        <button class="btn btn-danger btn-sm" id="stop-api-more"><i class="fa fa-close"></i> Dừng key theo lựa chọn</button>
                        <button class="btn btn-success btn-sm" id="open-api-more"><i class="fa fa-refresh"></i> Mở api theo lựa chọn</button>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                        <table id="user-list" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th data-orderable="false"><input type="checkbox" id="check-all"></th>
                                <th>ID</th>
                                <th>Key API</th>
                                <th>Đối tác</th>
                                <th>Trạng thái</th>
                                <th width="100px" class="text-center">action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataApi as $item)
                                <tr>
                                    <td><input name="phone-check" type="checkbox" value="{{$item->id}}" class="api-check" name="id[]"></td>
                                    <td>{{$item->id}}</td>
                                    <td><b>{{$item->token}}</b></td>
                                    <td><span class=" btn {{($item->active==1)?"btn-success":"btn-danger"}}">{{$item->provider}}</span></td>
                                    <td>
                                        @if ($item->active==1)
                                            <span class="btn btn-success btn-xs"> Đang hoạt động</span>
                                        @else
                                            <span class="btn btn-danger btn-xs"> Ngừng hoạt động</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->active==1)
                                            <a href="" class="btn btn-danger btn-sm stop-api" data-id="{{$item->id}}"> Dừng</a>
                                        @elseif($item->active==0)
                                            <a href="" class="btn btn-success btn-sm open-api" data-id="{{$item->id}}">Mở</a>

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
    <div id="apiModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="{{URL::route('api.token')}}" method="post" id="form-forget">
                {{csrf_field()}}
                <div class="modal-content" style="width: 70%;margin: 0 auto;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Nhập tên đối tác</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group has-feedback " id="error-class">
                            <input type="text" id="api-provider" name="provider" required class="form-control" placeholder="Đối tác (chú ý tên đối tác không dấu và viết liền)">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <p class="text-danger" id="show-error"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="send-email"><i class="fa fa-send-o"></i>Tạo Key API</button>
                    </div>
                </div>
            </form>>

        </div>
    </div>
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
        var tableApi = $('#user-list').DataTable( {
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

        $(document).on('click', '.stop-api', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            var check = confirm("Bạn có muốn tạm dừng key api này không?");
            if (check == true) {
                $.ajax({
                    url: '{{URL::route('api.stop-start')}}',
                    type: 'post',
                    data: {
                        id: id,
                        active:0
                    },
                    success: function (result) {
                        if (result.status == 1) {
                            alert(result.message);
                           window.location.reload();
                        } else if (result.status == 0) {
                            alert(result.message);
                        }
                    },
                    error: function (error) {

                    }
                })
            }
        })
        $(document).on('change', '#check-all', function () {
            var c = this.checked;
            $('.api-check:checkbox').prop('checked',c);
        });
        $(document).on('click', '.open-api', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            var check = confirm("Bạn có muốn mở lại key api này không?");
            if (check == true) {
                $.ajax({
                    url: '{{URL::route('api.stop-start')}}',
                    type: 'post',
                    data: {
                        id: id,
                        active:1
                    },
                    success: function (result) {
                        if (result.status == 1) {
                            alert(result.message);
                            window.location.reload();
                        } else if (result.status == 0) {
                            alert(result.message);
                        }
                    },
                    error: function (error) {

                    }
                })
            }
        })

        $(document).on('click', '#stop-api-more', function () {
            var param = $("input[name=phone-check]:checked").map(function() {
                return this.value;
            }).get().join(",");
            if (param=='') {
                alert('Bạn chưa chọn api cần dừng !');
                return;
            }
            var check = confirm("Bạn có muốn dừng nhiều api không?");
            if (check == true) {
                $.ajax({
                    url: '{{URL::route('api.stop-more')}}',
                    type: 'post',
                    data: {
                        param: param
                    },
                    success: function (result) {
                        alert('Dừng sử dụng api thành công!');
                        window.location.reload();

                    },
                    error: function (error) {

                    }
                })
            }
        });
        $(document).on('click', '#open-api-more', function () {
            var param = $("input[name=phone-check]:checked").map(function() {
                return this.value;
            }).get().join(",");
            if (param=='') {
                alert('Bạn chưa chọn api cần mở !');
                return;
            }
            var check = confirm("Bạn có muốn mở nhiều api không?");
            if (check == true) {
                $.ajax({
                    url: '{{URL::route('api.open-more')}}',
                    type: 'post',
                    data: {
                        param: param
                    },
                    success: function (result) {
                        alert('Mở sử dụng api thành công!');
                        window.location.reload();

                    },
                    error: function (error) {

                    }
                })
            }
        });


    </script>
@stop