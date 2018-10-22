@extends('backend.layouts.master')
@section('title')
    Log Nạp Thẻ
@stop
@section('link')
    <link rel="stylesheet" href="{{asset('backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <style>
        div.dt-buttons {
            position: relative;
            float: right;
        }
    </style>
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
                                        <label for="date-from">Từ ngày</label>
                                        <input type="text" class="form-control" data-date-format="dd-mm-yyyy" id="date-from" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date-to">Đến ngày</label>
                                        <input type="text" class="form-control" data-date-format="dd-mm-yyyy" id="date-to" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date-to">Trạng thái</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="999">Tất cả</option>
                                            @foreach(config('constant.pay_status') as $k=>$v)
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date-to">Đối Tác</label>
                                        <select name="provider" id="provider" class="form-control">
                                            @if(empty(\Auth::user()->is_admin))
                                            <option value="999">Tất cả</option>
                                            @endif
                                            @foreach($dataProvider as $item)
                                                <option value="{{$item->provider}}">{{$item->provider}}</option>
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date-to">Mã thẻ</label>
                                        <input type="text" class="form-control" name="code" id="code" placeholder="Mã thẻ">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
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
                        <h3 class="box-title">Danh sách log chi tiết nạp thẻ</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                        <table id="phone-list" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                @if (empty(Auth::user()->is_admin))
                                <th>Số Điện Thoại</th>
                                @endif
                                <th>Mã số thẻ</th>
                                <th>Seri thẻ</th>
                                <th>Mệnh giá từ người nạp</th>
                                <th>Mệnh giá từ nhà mạng</th>
                                <th>Trạng thái</th>
                                <th>Đối Tác</th>
                                <th>Ngày nạp</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <thead>
                            <tr>
                                <th colspan="4" style="padding-left: 30px">Tổng</th>
                                <th class="text-center" id="total-money-request">0</th>
                                <th class="text-center" id="total-money-response">0</th>
                                <th colspan="2" id="sub-money"></th>
                            </tr>
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
    {{--button--}}
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src=" https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
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
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Export excel',
                    className:'btn btn-success',
                    title:'Thống kê',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Export pdf',
                    className:'btn btn-success',
                    title:'Thống kê',
                    customize: function (doc) {
                        doc.defaultStyle.alignment = 'center';
                        doc.content[1].table.widths =
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                } ,
                {
                    extend: 'print',
                    text: '<i class="fa fa-print" aria-hidden="true"></i> Print',
                }
            ],
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
            info:false,
            searching: false,
            lengthMenu: [[10, 20,50, 100, 200, -1], [10, 20,50, 100, 200, "ALL"]],
            serverSide: true,
            processing: true,
            ajax: {
                url: '{{URL::route('pay-card.report')}}',
                type: 'POST',
                beforeSend:function(){
                },
                data: function ( d ) {
                    d._token = '{{csrf_token()}}';
                    d.dateFrom = $('#date-from').val();
                    d.dateTo = $('#date-to').val();
                    d.status = $('#status option:selected').val();
                    d.provider = $('#provider option:selected').val();
                    d.phone = $('#phone').val();
                    d.code = $('#code').val(); 
                },
                complete: function (data) {
                    $('#total-money-request').html(accounting.formatNumber(data.responseJSON.total_money_request));
                    $('#total-money-response').html(accounting.formatNumber(data.responseJSON.total_money_response));
                    $('#sub-money').html('Tổng tiền nạp sai mệnh giá: <b class="text-danger">'+accounting.formatNumber(data.responseJSON.total_money_request-data.responseJSON.total_money_response)+'</b>')
                },
                error: function (xhr, error, thrown) {
                    $("#divloader").hide();
                }
            },

            "initComplete":function( settings, data){
            },
            columns: [
                {
                    "data": "id" ,
                    "name": "id",
                    "className":"text-center"
                }, @if (empty(Auth::user()->is_admin))
                {
                    "data": "phone" ,
                    "name": "phone",
                    "className":"text-center",
                    "render":function (data) {
                        return '<b class="text-primary">'+'0'+accounting.formatNumber(data,',')+'</b>';
                    }
                },
                @endif

                {
                    "data": "card_code" ,
                    "name": "card_code",
                    "className":"text-left"
                },

                {
                    "data": "card_seri" ,
                    "name": "card_seri",
                    "className":"text-left"
                },

                {
                    "data": "money_request" ,
                    "name": "money_request",
                    "className":"text-center",
                    "render":function (data) {
                        return '<b class="text-success">'+accounting.formatNumber(data)+'</b>';
                    }
                },

                {
                    "data": "money_response" ,
                    "name": "money_response",
                    "className":"text-center",
                    "render":function (data) {
                        return '<b class="text-danger">'+accounting.formatNumber(data)+'</b>';
                    }
                },

                {
                    "data": "status" ,
                    "name": "status",
                    "className":"text-center",
                    "render":function (data) {
                        var result='';
                        if (data==0) {
                            result='<span class="btn btn-danger btn-xs">Nạp sai mệnh giá</span>';
                        } else if(data==1) {
                            result='<span class="btn btn-success btn-xs">Nạp thành công</span>';
                        }
                        return result;
                    }
                },
                {
                    "data": "provider" ,
                    "name": "provider",
                    "className":"text-center",
                    "render":function (data) {
                          var  result='<span class="btn btn-success btn-xs">'+data+'</span>';
                        return result;
                    }
                },

                {
                    "data": "created_at" ,
                    "name": "created_at",
                    "className":"text-center"
                },


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

    </script>
@stop