@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Settings') }}
            <small>{{ trans('admin_common.Edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/settings') }}">{{ trans('admin_common.Settings') }}</a></li>
            <li class="active">{{ trans('admin_common.Edit') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin_common.Edit Setting') }}</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form" enctype="multipart/form-data">
                        <div class="box-body">

                            {!! csrf_field() !!}
                            <div class="form-group {{ $modelData->setting_required ? 'required' : '' }} {{ $errors->has('setting_value') ? ' has-error' : '' }}">
                                <label for="setting_value" class="control-label">{{ $modelData->setting_description }}</label>

                                @if($modelData->setting_field_type == 'text')
                                    <input type="text" class="form-control" name="setting_value" id="setting_value" placeholder="{{ $modelData->setting_description }}" value="{{ Util::getOldOrModelValue('setting_value', $modelData) }}">
                                @elseif ($modelData->setting_field_type == 'textarea')
                                    <textarea type="text" class="form-control" name="setting_value" id="setting_value" rows="20">{{ Util::getOldOrModelValue('setting_value', $modelData) }}</textarea>
                                @elseif ($modelData->setting_field_type == 'file')
                                    <input type="file" name="setting_value" id="setting_value"><br />
                                    <input type="checkbox" name="clear_value" id="clear_value"> {{ trans('admin_common.Clear Value') }}
                                @elseif ($modelData->setting_field_type == 'password')
                                    <input type="password" class="form-control" name="setting_value" id="setting_value" placeholder="{{ $modelData->setting_description }}" value="{{ Util::getOldOrModelValue('setting_value', $modelData) }}">
                                @elseif ($modelData->setting_field_type == 'yesno')
                                    <select name="setting_value" id="setting_value" class="form-control">
                                    @foreach($yesnoselect as $k => $v)
                                        @if(Util::getOldOrModelValue('setting_value', $modelData) == $k)
                                            <option value="{{ $k }}" selected>{{ $v }}</option>
                                        @else
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                @endif

                                @if($modelData->setting_more_info)
                                    <span class="help-block">
                                        {!! trans('admin_settings.' . $modelData->setting_more_info) !!}
                                    </span>
                                @endif
                                @if ($errors->has('setting_value'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('setting_value') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('admin_common.Save') }}</button>
                        </div>
                    </form>

                </div>
                <!-- /.box -->
            </div>

            @if($modelData->setting_field_type == 'file' && !empty($modelData->setting_value))
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">{{ trans('admin_common.Additional Info') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <img src="{{ asset('uf/settings/' . $modelData->setting_value) }}">
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            @endif

        </div>
    </section>
    <!-- /.content -->
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}" />
    <link rel="stylesheet" href="{{ asset('js/chosen/chosen-bootstrap.css') }}" />
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/datepicker/datepicker3.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/flat/blue.css')}}">
@endsection

@section('js')
    <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{asset('adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('adminlte/plugins/fastclick/fastclick.js')}}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{asset('adminlte/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
    $(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        $('#banner_active_from, #banner_active_to').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
         });
    });
    </script>
@endsection