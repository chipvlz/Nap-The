@extends('backend.layouts.master')
@section('title')
    Danh Sách Số Điện Thoại 2
@stop
@section('link')
    <link rel="stylesheet" href="{{asset('backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tìm kiếm</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date-to">Trạng thái</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="999">Tất cả</option>
                                            @foreach(config('constant.status_true') as $k=>$v)
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date-to">SĐT</label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="số điện thoại">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <a href="{{URL::route('phone-true.add')}}" class="btn btn-primary">Thêm mới</a>
                            <button type="button" class="btn btn-success text-right" style="float: right !important;" id="btn-search">Lọc dữ liệu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách đơn hàng</h3><br/>
                        <button class="btn btn-danger btn-sm" id="sim-true-money"><i class="fa fa-close"></i>Xét sim đúng mệnh giá</button>
                        <button class="btn btn-success btn-sm" id="sim-map-money"><i class="fa fa-refresh"></i> Xét sim nạp gộp</button>
                      </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                        <table id="phone-list" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th data-orderable="false"><input type="checkbox" id="check-all"></th>
                                <th>ID</th>
                                <th>Số Điện Thoại</th>
                                <th>Số Tiền Cần Nạp</th>
                                <th>Số Tiền Đã Nạp</th>
                                <th>Trạng thái</th>
                                <th>Người Thêm</th>
                                <th>Ngày Thêm</th>
                                <th width="100px" class="text-center">action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot style="background: #00caff">
                            <th colspan="3" class="text-left">Tổng</th>
                            <th id="total-money"></th>
                            <th id="total-money-change"></th>
                            <th colspan="4"></th>
                            </tfoot>
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
        $(document).ready(function () {
            $('#date-from').datepicker({
                autoclose: true,
                dateFormat: 'yy-mm-dd'
            }).datepicker("setDate", new Date())

            // check all

            $(document).on('change', '#check-all', function () {
                var c = this.checked;
                $('.phone-check:checkbox').prop('checked',c);
            });

        });
        $(document).ready(function () {
            $('#date-to').datepicker({
                autoclose: true,
                dateFormat: 'yy-mm-dd'
            }).datepicker("setDate", new Date())
        });

        //datatable
        var tableListPhone = $('#phone-list').DataTable( {
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
            lengthMenu: [[50, 100,150, 200, 500, -1], [50, 100,150, 200, 500, 'ALL']],
            ajax: {
                url: '{{URL::route('phone-true.post-index')}}',
                type: 'POST',
                beforeSend:function(){
                },
                data: function ( d ) {
                    d._token = '{{csrf_token()}}';
                    d.status = $('#status option:selected').val();
                    d.phone = $('#phone').val();
                },
                dataSrc:"data",
                complete: function (data) {
                    $('#total-money').html(data.responseJSON.total.money_total)
                    $('#total-money-change').html(data.responseJSON.total.money_total_change)
                },
                error: function (xhr, error, thrown) {
                    $("#divloader").hide();
                }
            },

            "initComplete":function( settings, data){
            },
            "ordering": false,
            columns: [
                {
                    "data":{
                        'id':'id',
                        'status_key':'status_key',
                        'phone':'phone'
                    } ,
                    "name": "checkbox",
                    "orderable": false,
                    "className":"text-center",
                    "render":function (data) {
                        return `<input name="phone-check" type="checkbox" value="`+data.id+`" class="phone-check" name="id[]">`;
                    }

                },
                {
                    "data": "id" ,
                    "name": "id",
                    "className":"text-center"
                },
                {
                    "data": "phone_name" ,
                    "name": "phone",
                    "className":"text-center",
                    "render":function (data) {
                        return `<b>`+data+`</b>`;
                    }
                },
                {
                    "data": "money" ,
                    "name": "money",
                    "className":"text-center",
                    "render":function (data) {
                        return `<b class="text-success">`+data+`</b>`;
                    }
                },
                {
                    "data": "money_change" ,
                    "name": "money_change",
                    "className":"text-center",
                    "render":function (data) {
                        return `<b class="text-danger">`+data+`</b>`;
                    }
                },
                {
                    "data": "status" ,
                    "name": "status",
                    "className":"text-center",
                    "render":function (data) {
                        return `<b class="text-purple">`+data+`</b>`;
                    }
                },
                {
                    "data": "created_user" ,
                    "name": "created_user",
                    "className":"text-center"
                },
                {
                    "data": "created_at" ,
                    "name": "created_at",
                    "className":"text-left"
                },
                {
                    "data":{
                        'id':'id',
                        'status_key':'status_key',
                        'phone':'phone'
                    } ,
                    "name": "action",
                    "className":"text-center",
                    "width":"105px",
                    orderable: false,
                    "render":function (data) {
                        var result=``;
                        // if(data.status_key!=-1) {
                        //     result += `<button class="btn btn-danger btn-sm reject-sim" data-id=` + data.id + ` data-phone=`+data.phone+`>Dừng</button>`
                        // } else if(data.status_key==-1) {
                        //     result +=`<button class="btn btn-success btn-sm open-sim" data-id=` + data.id + ` data-phone=`+data.phone+`>Mở nạp</button>`
                        //
                        // }
                        result+=` <a href="/log/`+data.phone+`" class="btn btn-warning btn-sm">Log</a>`;
                        return result;
                    }
                }
            ],
            drawCallback : function() {
                if($('#phone-list tbody .dataTables_empty').length){
                    $('#phone-list tbody tr').hide()
                }
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);
            },
            deferRender: true,
        } );
        
        $(document).on('click', '#btn-search', function () {
            tableListPhone.ajax.reload();
        })

        $(document).on('click', '.reject-sim', function () {
            var id = $(this).data('id');
            var phone =$(this).data('phone');
            var check = confirm("Bạn có muốn dừng nạp SĐT:"+phone+" không?");
            if (check == true) {
                $.ajax({
                    url: '{{URL::route('phone.reject-sim')}}',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function (result) {

                            alert('Dừng nạp sim thành công!');
                            tableListPhone.ajax.reload();
                    },
                    error: function (error) {

                    }
                })
            }
        })
        //open sim
        $(document).on('click', '.open-sim', function () {
            var id = $(this).data('id');
            var phone =$(this).data('phone');
            var check = confirm("Bạn có muốn tiếp tục nạp SĐT:"+phone+" không?");
            if (check == true) {
                $.ajax({
                    url: '{{URL::route('phone.open-sim')}}',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function (result) {
                        alert('Mở nạp sim thành công!');
                        tableListPhone.ajax.reload();
                    },
                    error: function (error) {

                    }
                })
            }
        })

        //stop sim all

        $(document).on('click', '#sim-true-money', function () {
            var param = $("input[name=phone-check]:checked").map(function() {
                return this.value;
            }).get().join(",");
            if (param=='') {
                alert('Bạn chưa chọn sim !');
                return;
            }
            var check = confirm("Bạn có muốn xét sim đúng mệnh giá không?");
            if (check == true) {
                $.ajax({
                    url: '{{URL::route('phone-true.sim-money-true')}}',
                    type: 'post',
                    data: {
                        param: param
                    },
                    success: function (result) {
                        $("#check-all").prop('checked', false);
                        alert('Xét sim đúng mệnh giá thành công!');
                        tableListPhone.ajax.reload();
                    },
                    error: function (error) {

                    }
                })
            }
        });
        $(document).on('click', '#sim-map-money', function () {
            var param = $("input[name=phone-check]:checked").map(function() {
                return this.value;
            }).get().join(",");
            if (param=='') {
                alert('Bạn chưa chọn sim !');
                return;
            }
            var check = confirm("Bạn có muốn gộp mệnh giá sim không?");
            if (check == true) {
                $.ajax({
                    url: '{{URL::route('phone-true.sim-money-map')}}',
                    type: 'post',
                    data: {
                        param: param
                    },
                    success: function (result) {
                        $("#check-all").prop('checked', false);
                        alert('Gộp mệnh giá sim thành công!');
                        tableListPhone.ajax.reload();
                    },
                    error: function (error) {

                    }
                })
            }
        });

    </script>
@stop