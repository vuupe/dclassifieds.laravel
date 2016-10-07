@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.User Mail') }}
            <small>{{ trans('admin_common.Add Mail') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/wallet') }}">{{ trans('admin_common.User Mail') }}</a></li>
            <li class="active">{{ trans('admin_common.Add Mail') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">{{ trans('admin_common.Add Mail') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('user_id_to') ? ' has-error' : '' }}">
                                <label for="user_id_to" class="control-label">{{ trans('admin_common.Mail User Id To') }}</label>
                                <input type="text" class="form-control" name="user_id_to" id="user_id_to" placeholder="{{ trans('admin_common.Mail User Id To') }}" value="{{ Util::getOldOrModelValue('user_id_to', $modelData) }}">
                                @if ($errors->has('user_id_to'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_id_to') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('ad_id') ? ' has-error' : '' }}">
                                <label for="ad_id" class="control-label">{{ trans('admin_common.Mail Ad Id') }}</label>
                                <input type="text" class="form-control" name="ad_id" id="ad_id" placeholder="{{ trans('admin_common.Mail Ad Id') }}" value="{{ Util::getOldOrModelValue('ad_id', $modelData) }}">
                                @if ($errors->has('ad_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('mail_text') ? ' has-error' : '' }}">
                                <label for="mail_text" class="control-label">{{ trans('admin_common.Mail Text') }}</label>
                                <textarea class="form-control" name="mail_text" id="mail_text" rows="{{ config('dc.num_rows_ad_description_textarea') }}">{{ Util::getOldOrModelValue('mail_text', $modelData) }}</textarea>
                                @if ($errors->has('mail_text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mail_text') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('admin_common.Add Mail') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('styles')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/datepicker/datepicker3.css')}}">
@endsection

@section('js')
    <!-- bootstrap datepicker -->
    <script src="{{asset('adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script>
    $(function () {
        $('#wallet_date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    });
    </script>
@endsection