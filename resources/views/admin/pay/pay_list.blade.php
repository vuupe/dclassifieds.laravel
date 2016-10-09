@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Payment Options') }}
            <small>{{ trans('admin_common.List') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li class="active">{{ trans('admin_common.Payment Options') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
    @if (session()->has('message'))
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-info"></i> {{ trans('admin_common.Information') }}</h4>
        {!! session('message') !!}
    </div>
    @endif
    
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin_common.All Payment Options') }}</h3>
        </div>
        <!-- /.box-header -->

        <form method="post" name="list_form" id="list_form">
        {!! csrf_field() !!}

            <div class="box-body">
                <table id="list_table" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('admin_common.#Id') }}</th>
                            <th>{{ trans('admin_common.Payment Name') }}</th>
                            <th>{{ trans('admin_common.Payment Sum') }}</th>
                            <th>{{ trans('admin_common.Payment Promo Period') }}</th>
                            <th>{{ trans('admin_common.Payment Active') }}</th>
                            <th>{{ trans('admin_common.Payment Order') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach($modelData as $k => $v)
                        <tr>
                            <td>{{ $v['pay_id'] }}</td>
                            <td>{{ $v['pay_name'] }}</td>
                            <td style="text-align: right; font-weight: bold;">{{ number_format($v['pay_sum'], 2, '.', '') . config('dc.site_price_sign') }}</td>
                            <td>{{ $v['pay_promo_period'] }} {{ trans('admin_common.Days') }}</td>
                            <td>
                                @if($v['pay_active'] == 1)
                                    <span class="fa fa-check" aria-hidden="true" style="color:green;"></span>
                                @else
                                    <span class="fa fa-close" aria-hidden="true" style="color:red;"></span>
                                @endif
                            </td>
                            <td>{{ $v['pay_ord'] }}</td>
                            <td><a href="{{ url('admin/pay/edit/' . $v['pay_id']) }}"><i class="fa fa-edit"></i> {{ trans('admin_common.Edit') }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        <!-- /.box-body -->
        </form>
    </div>
    <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.css')}}" />
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/flat/blue.css')}}">
@endsection

@section('js')
    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/fastclick/fastclick.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('adminlte/plugins/iCheck/icheck.min.js')}}"></script>
    
    <script>
    $(function () {
        $('#list_table').DataTable({"order": [],
            "pageLength": 25,
            "columns": [
                        null,
                        null,
                        null,
                        null,
                        null,
                        null,
                        { "orderable": false }
                      ]
        });

        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $("input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $("input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }
          $(this).data("clicks", !clicks);
        });
    });
    </script>
@endsection
