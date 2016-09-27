@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Banners
            <small>Add/Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/banner') }}">Ad Banners</a></li>
            <li class="active">Add/Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add/Edit Banner</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form" enctype="multipart/form-data">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('banner_name') ? ' has-error' : '' }}">
                                <label for="banner_name" class="control-label">Banner Name</label>
                                <input type="text" class="form-control" name="banner_name" id="banner_name" placeholder="Banner Name" value="{{ Util::getOldOrModelValue('banner_name', $modelData) }}">
                                @if ($errors->has('banner_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banner_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('banner_position') ? ' has-error' : '' }}">
                                <label for="banner_position" class=" control-label">Banner Position</label>
                                <select name="banner_position" id="banner_position" class="form-control chosen_select" data-placeholder="Please Select">
                                    <option value="0"></option>
                                    @foreach ($bannerPosition as $k => $v)
                                        @if(Util::getOldOrModelValue('banner_position', $modelData) == $k)
                                            <option value="{{ $k }}" selected>{{ $v }}</option>
                                        @else
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('banner_position'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banner_position') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('banner_type') ? ' has-error' : '' }}">
                                <label for="banner_type" class=" control-label">Banner Type</label>
                                <select name="banner_type" id="banner_type" class="form-control chosen_select" data-placeholder="Please Select">
                                    <option value="0"></option>
                                    @foreach ($bannerType as $k => $v)
                                        @if(Util::getOldOrModelValue('banner_type', $modelData) == $k)
                                            <option value="{{ $k }}" selected>{{ $v }}</option>
                                        @else
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('banner_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banner_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <hr>

                            <div class="form-group required {{ $errors->has('banner_link') ? ' has-error' : '' }}">
                                <label for="banner_link" class="control-label">Banner Link</label>
                                <input type="text" class="form-control" name="banner_link" id="banner_link" placeholder="Banner Link" value="{{ Util::getOldOrModelValue('banner_link', $modelData) }}">
                                @if ($errors->has('banner_link'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banner_link') }}</strong>
                                    </span>
                                @endif
                                <p class="help-block">*Required if banner type is image</p>
                            </div>

                            <div class="form-group required {{ $errors->has('banner_file') ? ' has-error' : '' }}">
                                <label for="banner_file" class="control-label">Banner Image</label>
                                <input type="file" name="banner_file" id="banner_file">
                                @if ($errors->has('banner_file'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banner_file') }}</strong>
                                    </span>
                                @endif
                                <p class="help-block">*Required if banner type is image</p>
                            </div>

                            <hr>

                            <div class="form-group required {{ $errors->has('banner_code') ? ' has-error' : '' }}">
                                <label for="banner_code" class="control-label">Banner Javascript/HTML</label>
                                <textarea type="text" class="form-control" name="banner_code" id="banner_code">{{ Util::getOldOrModelValue('banner_code', $modelData) }}</textarea>
                                @if ($errors->has('banner_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banner_code') }}</strong>
                                    </span>
                                @endif
                                <p class="help-block">*Required if banner type is Javascript/HTML</p>
                            </div>

                            <hr>

                            <div class="form-group required {{ $errors->has('banner_active_from') ? ' has-error' : '' }}">
                                <label for="banner_active_from" class="control-label">Banner Active From</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" id="banner_active_from" name="banner_active_from" value="{{ Util::getOldOrModelValue('banner_active_from', $modelData) }}" >
                                </div>
                                @if ($errors->has('banner_active_from'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banner_active_from') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('banner_active_to') ? ' has-error' : '' }}">
                                <label for="banner_active_to" class="control-label">Banner Active To</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" id="banner_active_to" name="banner_active_to" value="{{ Util::getOldOrModelValue('banner_active_to', $modelData) }}" >
                                </div>
                                @if ($errors->has('banner_active_to'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('banner_active_to') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="banner_file" class="control-label">Banner Num Views</label>
                                <input type="text" class="form-control" id="banner_num_views" name="banner_num_views" value="{{ Util::getOldOrModelValue('banner_num_views', $modelData) }}" readonly>
                            </div>



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