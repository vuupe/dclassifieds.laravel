@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Settings
            <small>Add/Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/settings') }}">Settings</a></li>
            <li class="active">Add/Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add/Edit Setting</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <?if($modelData->setting_field_type == 'text'){?>
                                <div class="form-group required {{ $errors->has('setting_value') ? ' has-error' : '' }}">
                                    <label for="setting_value" class="control-label">{{ $modelData->setting_description }}</label>
                                    <input type="text" class="form-control" name="setting_value" id="setting_value" placeholder="{{ $modelData->setting_description }}" value="{{ Util::getOldOrModelValue('setting_value', $modelData) }}">
                                    @if ($errors->has('setting_value'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('setting_value') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            <?} else {?>
                                <div class="form-group required {{ $errors->has('setting_value') ? ' has-error' : '' }}">
                                    <label for="setting_value" class="control-label">{{ $modelData->setting_description }}</label>
                                    <textarea type="text" class="form-control" name="setting_value" id="setting_value">{{ Util::getOldOrModelValue('setting_value', $modelData) }}</textarea>
                                    @if ($errors->has('setting_value'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('setting_value') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            <?}?>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Add/Save</button>
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