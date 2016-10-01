@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Furnishing Types') }}
            <small>{{ trans('admin_common.Add/Edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/estatefurnishing') }}">{{ trans('admin_common.Furnishing Types') }}</a></li>
            <li class="active">{{ trans('admin_common.Add/Edit') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin_common.Add/Edit Furnishing Type') }}</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('estate_furnishing_type_name') ? ' has-error' : '' }}">
                                <label for="estate_furnishing_type_name" class="control-label">{{ trans('admin_common.Furnishing Type') }}</label>
                                <input type="text" class="form-control" name="estate_furnishing_type_name" id="estate_furnishing_type_name" placeholder="{{ trans('admin_common.Furnishing Type') }}" value="{{ Util::getOldOrModelValue('estate_furnishing_type_name', $modelData) }}">
                                @if ($errors->has('estate_furnishing_type_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estate_furnishing_type_name') }}</strong>
                                    </span>
                                @endif
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