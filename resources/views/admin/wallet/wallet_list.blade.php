@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header" xmlns="http://www.w3.org/1999/html">
        <h1>
            {{ trans('admin_common.Wallet') }}
            <small>{{ trans('admin_common.List') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li class="active">{{ trans('admin_common.Wallet') }}</li>
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
    @if($walletList->isEmpty())
        {{ trans('admin_common.There are no wallet rows.') }}
    @else
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('admin_common.All Wallet Rows') }}</h3>

            </div>
            <!-- /.box-header -->

            <form method="get" name="list_form" id="list_form">
            {!! csrf_field() !!}
                <div class="controls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                        <button type="submit" onclick="$('#list_form').attr('action', '{{ url('admin/wallet/delete') }}');" class="btn btn-default btn-sm need_confirm"><i class="fa fa-trash-o"></i></button>
                    </div>
                    <a href="{{ url('admin/wallet/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-file-o"></i> {{ trans('admin_common.Add/Remove Credit') }}</a>
                </div>

                <div class="box-body">

                    <div class="table-responsive">
                        <table id="list_table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ trans('admin_common.#Id') }}</th>
                                    <th>{{ trans('admin_common.Wallet Ad Id') }}</th>
                                    <th>{{ trans('admin_common.Wallet User Id') }}</th>
                                    <th>{{ trans('admin_common.Wallet User Name') }}</th>
                                    <th>{{ trans('admin_common.Wallet User Email') }}</th>
                                    <th>{{ trans('admin_common.Wallet Date') }}</th>
                                    <th>{{ trans('admin_common.Wallet Sum') }}</th>
                                    <th>{{ trans('admin_common.Wallet Description') }}</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="text" class="form-control filter_field" name="wallet_id_search" id="wallet_id_search" value="{{ isset($params['wallet_id_search']) ? $params['wallet_id_search'] : ''}}" /></td>
                                    <td><input type="text" class="form-control filter_field" name="ad_id" id="ad_id" value="{{ isset($params['ad_id']) ? $params['ad_id'] : ''}}" /></td>
                                    <td><input type="text" class="form-control filter_field" name="user_id" id="user_id" value="{{ isset($params['user_id']) ? $params['user_id'] : ''}}" /></td>
                                    <td><input type="text" class="form-control filter_field" name="name" id="name" value="{{ isset($params['name']) ? $params['name'] : ''}}" /></td>
                                    <td><input type="text" class="form-control filter_field" name="email" id="email" value="{{ isset($params['email']) ? $params['email'] : ''}}" /></td>
                                    <td><input type="text" class="form-control filter_field" name="wallet_date" id="wallet_date" value="{{ isset($params['wallet_date']) ? $params['wallet_date'] : ''}}" /></td>
                                    <td><input type="text" class="form-control filter_field" name="sum" id="sum" value="{{ isset($params['sum']) ? $params['sum'] : ''}}" /></td>
                                    <td><input type="text" class="form-control filter_field" name="wallet_description" id="wallet_description" value="{{ isset($params['wallet_description']) ? $params['wallet_description'] : ''}}" /></td>
                                    <td colspan="2">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;" name="search_submit" id="search_submit" onclick="$('#list_form').attr('action', '{{ url('admin/wallet') }}');">
                                            <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> {{ trans('admin_common.Search') }}
                                        </button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>

                            <?$total_sum = 0;?>
                            @foreach($walletList as $k => $v)
                                <?$total_sum += $v->sum ?>
                                <tr>
                                    <td><input type="checkbox" name="wallet_id[]" value="{{ $v->wallet_id }}"></td>
                                    <td>{{ $v->wallet_id }}</td>
                                    <td>{{ $v->ad_id }}</td>
                                    <td>{{ $v->user_id }}</td>
                                    <td>{{ $v->name }}</td>
                                    <td>{{ $v->email }}</td>
                                    <td>{{ $v->wallet_date }}</td>
                                    <td style="text-align:right;">{!! $v->sum < 0 ? '<span style="color:red; font-weight:bold;">' . number_format($v->sum, 2, '.', '') . config('dc.site_price_sign')  . '</span>' : '<span style="color:green; font-weight:bold;">' . number_format($v->sum, 2, '.', '') . config('dc.site_price_sign')  . '</span>' !!}</td>
                                    <td>{{ $v->wallet_description }}</td>
                                    <td><a href="{{ url('admin/wallet/delete/' . $v->wallet_id) }}" class="text-danger need_confirm"><i class="fa fa-trash"></i> {{ trans('admin_ad.Delete') }}</a></td>
                                </tr>
                            @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align:right;">{{ number_format($total_sum, 2, '.', '') . config('dc.site_price_sign') }}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                <?=$walletList->appends($params)->links()?>
                            </nav>
                        </div>
                    </div>
                </div>
            <!-- /.box-body -->
            </form>
         </div>
         <!-- /.box -->
    @endif
    </section>
    <!-- /.content -->
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.css')}}" />
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/flat/blue.css')}}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/datepicker/datepicker3.css')}}">
@endsection

@section('js')
    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('adminlte/plugins/fastclick/fastclick.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('adminlte/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{asset('adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    
    <script>
    $(function () {
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

        $('.filter_field').keypress(function(e){
            if(e.which == 13) {
                e.preventDefault();
                $('#search_submit').click();
            }    
        });

        $('#wallet_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    });
    </script>
@endsection