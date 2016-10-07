@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header" xmlns="http://www.w3.org/1999/html">
        <h1>
            {{ trans('admin_common.User Mail') }}
            <small>{{ trans('admin_common.List') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li class="active">{{ trans('admin_common.User Mail') }}</li>
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
    @if($mailList->isEmpty())
        {{ trans('admin_common.There are no user mails.') }}
    @else
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('admin_common.All User Mails') }}</h3>

            </div>
            <!-- /.box-header -->

            <form method="get" name="list_form" id="list_form">
            {!! csrf_field() !!}
                <div class="controls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
                        <button type="submit" onclick="$('#list_form').attr('action', '{{ url('admin/mail/delete') }}');" class="btn btn-default btn-sm need_confirm"><i class="fa fa-trash-o"></i></button>
                    </div>
                    <a href="{{ url('admin/mail/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-file-o"></i> {{ trans('admin_common.Add Mail') }}</a>
                </div>

                <div class="box-body">

                    <table id="ad_list_table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ trans('admin_common.#Id') }}</th>
                                <th>{{ trans('admin_common.Mail Ad Id') }}</th>
                                <th>{{ trans('admin_common.Mail User Id From') }}</th>
                                <th>{{ trans('admin_common.Mail User Id To') }}</th>
                                <th>{{ trans('admin_common.Mail Text') }}</th>
                                <th>{{ trans('admin_common.Mail Date') }}</th>
                                <th>{{ trans('admin_common.Mail Conversation Hash') }}</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" class="form-control filter_field" name="mail_id_search" id="mail_id_search" value="{{ isset($params['mail_id_search']) ? $params['mail_id_search'] : ''}}" /></td>
                                <td><input type="text" class="form-control filter_field" name="ad_id" id="ad_id" value="{{ isset($params['ad_id']) ? $params['ad_id'] : ''}}" /></td>
                                <td><input type="text" class="form-control filter_field" name="user_id_from" id="user_id_from" value="{{ isset($params['user_id_from']) ? $params['user_id_from'] : ''}}" /></td>
                                <td><input type="text" class="form-control filter_field" name="user_id_to" id="user_id_to" value="{{ isset($params['user_id_to']) ? $params['user_id_to'] : ''}}" /></td>
                                <td><input type="text" class="form-control filter_field" name="mail_text" id="mail_text" value="{{ isset($params['mail_text']) ? $params['mail_text'] : ''}}" /></td>
                                <td></td>
                                <td><input type="text" class="form-control filter_field" name="mail_hash" id="mail_hash" value="{{ isset($params['mail_hash']) ? $params['mail_hash'] : ''}}" /></td>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-primary" style="width: 100%;" name="search_submit" id="search_submit" onclick="$('#list_form').attr('action', '{{ url('admin/mail') }}');">
                                        <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> {{ trans('admin_common.Search') }}
                                    </button>
                                </td>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($mailList as $k => $v)
                            <tr>
                                <td><input type="checkbox" name="mail_id[]" value="{{ $v->mail_id }}"></td>
                                <td>{{ $v->mail_id }}</td>
                                <td>{{ $v->ad_id }}</td>
                                <td>{{ $v->user_id_from }}</td>
                                <td>{{ $v->user_id_to }}</td>
                                <td style="width:500px;">{!! $v->mail_text !!}</td>
                                <td>{{ $v->mail_date }}</td>
                                <td>{{ $v->mail_hash }}</td>
                                <td><a href="{{ url('admin/mail/delete/' . $v->mail_id) }}" class="text-danger need_confirm"><i class="fa fa-trash"></i> {{ trans('admin_ad.Delete') }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                {!! $mailList->appends($params)->links() !!}
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
    });
    </script>
@endsection