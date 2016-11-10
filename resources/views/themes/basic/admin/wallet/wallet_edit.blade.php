@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Wallet') }}
            <small>{{ trans('admin_common.Add/Remove Credit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/wallet') }}">{{ trans('admin_common.Wallet') }}</a></li>
            <li class="active">{{ trans('admin_common.Add/Remove Credit') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">{{ trans('admin_common.Add/Remove Credit') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('user_id') ? ' has-error' : '' }}">
                                <label for="user_id" class="control-label">{{ trans('admin_common.Wallet User Id') }}</label>
                                <input type="text" class="form-control" name="user_id" id="user_id" placeholder="{{ trans('admin_common.Wallet User Id') }}" value="{{ Util::getOldOrModelValue('user_id', $modelData) }}">
                                @if ($errors->has('user_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('ad_id') ? ' has-error' : '' }}">
                                <label for="ad_id" class="control-label">{{ trans('admin_common.Wallet Ad Id') }}</label>
                                <input type="text" class="form-control" name="ad_id" id="ad_id" placeholder="{{ trans('admin_common.Wallet Ad Id') }}" value="{{ Util::getOldOrModelValue('ad_id', $modelData) }}">
                                @if ($errors->has('ad_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('sum') ? ' has-error' : '' }}">
                                <label for="ad_id" class="control-label">{{ trans('admin_common.Wallet Sum') }}</label>
                                <input type="text" class="form-control" name="sum" id="sum" placeholder="{{ trans('admin_common.Wallet Sum') }}" value="{{ Util::getOldOrModelValue('sum', $modelData) }}">
                                @if ($errors->has('sum'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sum') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('wallet_date') ? ' has-error' : '' }}">
                                <label for="ad_id" class="control-label">{{ trans('admin_common.Wallet Date') }}</label>
                                <input type="text" class="form-control" name="wallet_date" id="wallet_date" placeholder="{{ trans('admin_common.Wallet Date') }}" value="{{ Util::getOldOrModelValue('wallet_date', $modelData) }}" readonly>
                                @if ($errors->has('wallet_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('wallet_date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('wallet_description') ? ' has-error' : '' }}">
                                <label for="ad_id" class="control-label">{{ trans('admin_common.Wallet Description') }}</label>
                                <input type="text" class="form-control" name="wallet_description" id="wallet_description" placeholder="{{ trans('admin_common.Wallet Description') }}" value="{{ Util::getOldOrModelValue('wallet_description', $modelData) }}">
                                @if ($errors->has('wallet_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('wallet_description') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('admin_common.Add/Remove') }}</button>
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