@extends('backend.layouts.master')
@section('title')
    Danh Sách Số Điện Thoại
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
                    <form role="form" action="" method="get">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date-from">Từ ngày</label>
                                        <input type="text" name="start_date" value="{{Request::get('start_date','')}}" class="form-control" data-date-format="dd-mm-yyyy" id="date-from" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date-to">Đến ngày</label>
                                        <input type="text" name="end_date" value="{{Request::get('end_date','')}}" class="form-control" data-date-format="dd-mm-yyyy" id="date-to" placeholder="">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success text-right" style="float: right !important;" id="btn-search">Lọc dữ liệu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách sim hoàn thành</h3><br/>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="phone-list" class="table table-bordered table-hover" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Số Tiền Cần Nạp</th>
                                    <th>Số Tiền Đã Nạp</th>
                                    <th>Trạng thái</th>
                                    <th>Người Thêm</th>
                                    <th>Ngày Thêm</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($dataPhone as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td><b class="text-success">{{number_format($item->money)}}</b></td>
                                    <td><b class="text-danger">{{number_format($item->money_change)}}</b></td>
                                    <td><span class="btn btn-success btn-xs">Nạp đủ</span></td>
                                    <td><b>{{$item->created_user}}</b></td>
                                    <td><b class="text-primary">{{$item->created_at}}</b></td>
                                @empty
                                @endforelse
                                </tbody>
                                <tfoot style="background: #00caff">
                                <th colspan="2" class="text-left">Tổng</th>
                                <th id="total-money">{{number_format($total['money_total'])}}</th>
                                <th id="total-money-change">{{number_format($total['money_total_change'])}}</th>
                                <th colspan="3"></th>
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
        $(document).ready(function () {
            console.log("{{date('Y', strtotime(Request::get('start_date',date('Y-m-d'))))}}")
            console.log(new Date());
            $('#date-from').datepicker({
                autoclose: true,
                dateFormat: 'yy-mm-dd'
            }).datepicker("setDate", new Date("{{date('Y', strtotime(Request::get('start_date',date('Y-m-d'))))}}", parseInt("{{date('m', strtotime(Request::get('start_date',date('Y-m-d'))))}}")-1,"{{date('d', strtotime(Request::get('start_date',date('Y-m-d'))))}}"));
        });
        $(document).ready(function () {
            $('#date-to').datepicker({
                autoclose: true,
                dateFormat: 'yy-mm-dd'
            }).datepicker("setDate", new Date("{{date('Y', strtotime(Request::get('end_date',date('Y-m-d'))))}}", parseInt("{{date('m', strtotime(Request::get('end_date',date('Y-m-d'))))}}")-1,"{{date('d', strtotime(Request::get('end_date',date('Y-m-d'))))}}"));
        });

        //datatable
       $(document).ready(function () {
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
               },
           } );
       })
        </script>
@stop