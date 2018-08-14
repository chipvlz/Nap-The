@extends('backend.layouts.master')
@section('link')
    <link rel="stylesheet" href="{{asset('backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Log giao dịch của sim:{{$phone}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="phone-list" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Số Điện Thoại</th>
                                <th>Mã số thẻ</th>
                                <th>Seri thẻ</th>
                                <th>Mệnh giá từ người nạp</th>
                                <th>Mệnh giá từ nhà mạng</th>
                                <th>Trạng thái</th>
                                <th>Ngày nạp</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($dataLog as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td><b>{{$item->phone}}</b></td>
                                <td><b class="text-success">{{$item->card_code}}</b></td>
                                <td><b class="text-danger">{{$item->card_seri}}</b></td>
                                <td><b class="text-primary">{{number_format($item->money_request)}}</b></td>
                                <td><b class="text-warning">{{number_format($item->money_response)}}</b></td>
                                <td>
                                    @if ($item->status==0)
                                        <lable class="btn btn-danger btn-xs"> Nạp sai mệnh giá</lable>
                                    @else
                                        <lable class="btn btn-success btn-xs"> Nạp thành công</lable>
                                    @endif

                                </td>
                                <td>{{$item->created_at}}</td>
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

            deferRender: true,
        } );



    </script>
@stop