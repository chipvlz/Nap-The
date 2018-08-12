@extends('backend.layouts.master')
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
                                        <label for="date-to">Loại sim</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="999">Tất cả</option>
                                            @foreach(config('constant.phone_type') as $k=>$v)
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date-to">Trạng thái</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="999">Tất cả</option>
                                            @foreach(config('constant.status') as $k=>$v)
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

                        <div class="box-footer text-right">
                            <button type="button" class="btn btn-primary" id="btn-search">Lọc dữ liệu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách đơn hàng</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="phone-list" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Số Điện Thoại</th>
                                <th>Loại Sim</th>
                                <th>Số Tiền Cần Nạp</th>
                                <th>Số Tiền Đã Nạp</th>
                                <th>Trạng thái</th>
                                <th>Người Thêm</th>
                                <th>Ngày Thêm</th>
                            </tr>
                            </thead>
                            <tbody>

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
            ajax: {
                url: '{{URL::route('phone.post-index')}}',
                type: 'POST',
                data: function ( d ) {
                    d._token = '{{csrf_token()}}';
                    d.dateFrom = $('#date-from').val();
                    d.dateTo = $('#date-to').val();
                    d.type = $('#type option:selected').val();
                    d.status = $('#status option:selected').val();
                    d.phone = $('#phone').val();
                },
                dataSrc:"data",
                complete: function (data) {
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
    </script>
@stop