@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Pages') }}
            <small>{{ trans('admin_common.Add/Edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/adtype') }}">{{ trans('admin_common.Pages') }}</a></li>
            <li class="active">{{ trans('admin_common.Add/Edit') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">{{ trans('admin_common.Add/Edit Pages') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('page_position') ? ' has-error' : '' }}">
                                <label for="car_brand_id" class="control-label">{{ trans('admin_common.Page Position') }}</label>
                                @if(!empty($page_menu_position))
                                <select name="page_position" id="page_position" class="form-control chosen_select" data-placeholder="{{ trans('admin_common.Select Page Position') }}">
                                    <option value="0"></option>
                                    @foreach ($page_menu_position as $k => $v)
                                        @if(Util::getOldOrModelValue('page_position', $modelData) == $k)
                                            <option value="{{ $k }}" selected>{{ $v }}</option>
                                        @else
                                            <option value="{{ $k }}">{{ $v }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                                @if ($errors->has('page_position'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('page_position') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('page_slug') ? ' has-error' : '' }}">
                                <label for="page_slug" class="control-label">{{ trans('admin_common.Page Slug') }}</label>
                                <input type="text" class="form-control" name="page_slug" id="page_slug" placeholder="{{ trans('admin_common.Page Slug') }}" value="{{ Util::getOldOrModelValue('page_slug', $modelData) }}">
                                @if ($errors->has('page_slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('page_slug') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('page_title') ? ' has-error' : '' }}">
                                <label for="page_title" class="control-label">{{ trans('admin_common.Page Title') }}</label>
                                <input type="text" class="form-control" name="page_title" id="page_title" placeholder="{{ trans('admin_common.Page Title') }}" value="{{ Util::getOldOrModelValue('page_title', $modelData) }}">
                                @if ($errors->has('page_slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('page_slug') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="page_description" class="control-label">{{ trans('admin_common.Page Meta Description') }}</label>
                                <input type="text" class="form-control" name="page_description" id="page_description" placeholder="{{ trans('admin_common.Page Meta Description') }}" value="{{ Util::getOldOrModelValue('page_description', $modelData) }}">
                                <span class="help-block">
                                    <strong>{{ $errors->first('page_slug') }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="page_keywords" class="control-label">{{ trans('admin_common.Page Meta Keywords') }}</label>
                                <input type="text" class="form-control" name="page_keywords" id="page_keywords" placeholder="{{ trans('admin_common.Page Meta Keywords') }}" value="{{ Util::getOldOrModelValue('page_keywords', $modelData) }}">
                                <span class="help-block">
                                    <strong>{{ $errors->first('page_slug') }}</strong>
                                </span>
                            </div>

                            <div class="form-group required {{ $errors->has('page_content') ? ' has-error' : '' }}">
                                <label for="page_content" class="control-label">{{ trans('admin_common.Page Content') }}</label>
                                <textarea class="form-control" name="page_content" id="page_content" placeholder="{{ trans('admin_common.Enter Page Content') }}" rows="{{ config('dc.num_rows_ad_description_textarea') }}">{{ Util::getOldOrModelValue('page_content', $modelData) }}</textarea>
                                @if ($errors->has('page_content'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('page_content') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('page_ord') ? ' has-error' : '' }}">
                                <label for="page_ord" class="control-label">{{ trans('admin_common.Page Order') }}</label>
                                <input type="text" class="form-control" name="page_ord" id="page_ord" placeholder="{{ trans('admin_common.Page Order') }}" value="{{ Util::getOldOrModelValue('page_ord', $modelData) }}">
                                @if ($errors->has('page_ord'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('page_ord') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="page_active" {{ Util::getOldOrModelValue('page_active', $modelData) ? 'checked' : '' }}> {{ trans('admin_common.Active') }}
                                </label>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('admin_common.Add/Save') }}</button>
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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/flat/blue.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
@endsection

@section('js')
    <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
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
    });
    </script>
    <script src="{{asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <script>
        $(function () {
            //bootstrap WYSIHTML5 - text editor
            $("#page_content").wysihtml5();
        });
    </script>
@endsection