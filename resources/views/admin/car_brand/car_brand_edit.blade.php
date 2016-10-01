@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Car Brands') }}
            <small>{{ trans('admin_common.Add/Edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/carbrand') }}">{{ trans('admin_common.Car Brands') }}</a></li>
            <li class="active">{{ trans('admin_common.Add/Edit') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin_common.Add/Edit Car Brands') }}</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('car_brand_name') ? ' has-error' : '' }}">
                                <label for="car_brand_name" class="control-label">{{ trans('admin_common.Car Brand') }}</label>
                                <input type="text" class="form-control" name="car_brand_name" id="car_brand_name" placeholder="{{ trans('admin_common.Car Brand') }}" value="{{ Util::getOldOrModelValue('car_brand_name', $modelData) }}">
                                @if ($errors->has('car_brand_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_brand_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="car_brand_active" id="car_brand_active" {{ Util::getOldOrModelValue('car_brand_active', $modelData) > 0 ? 'checked' : '' }}> {{ trans('admin_common.Active') }}
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