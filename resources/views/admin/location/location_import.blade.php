@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Locations') }}
            <small>{{ trans('admin_common.Import') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/location') }}">{{ trans('admin_common.Locations') }}</a></li>
            <li class="active">{{ trans('admin_common.Import') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin_common.Import Locations') }}</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="import_form" id="import_form" enctype="multipart/form-data">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="location_parent_id">{{ trans('admin_common.Location Parent') }}</label>
                                <select class="form-control chosen_select" name="location_parent_id" id="location_parent_id" data-placeholder="{{ trans('admin_common.Select Parent Location') }}">
                                <option value="0"></option>
                                @foreach ($l as $k => $v)
                                    @if(isset($lid) && $lid == $v['lid'])
                                        <option value="{{$v['lid']}}" selected>{{$v['title']}}</option>
                                    @else
                                        <option value="{{$v['lid']}}">{{$v['title']}}</option>
                                    @endif

                                    @if(isset($v['c']) && !empty($v['c'])){
                                        @include('common.lselect', ['c' => $v['c']])
                                    @endif
                                @endforeach
                                </select>
                            </div>

                            <div class="form-group required {{ $errors->has('csv_file') ? ' has-error' : '' }}">
                                <label for="csv_file" class="control-label">{{ trans('admin_common.CSV file to be imported') }}</label>
                                <input type="file" name="csv_file" id="csv_file">
                                @if ($errors->has('csv_file'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('csv_file') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('admin_common.Import') }}</button>
                        </div>
                    </form>

                </div>
                <!-- /.box -->
            </div>

            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">{{ trans('admin_common.CSV Import How to') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <p class="help-block">{{ trans('admin_common.CSV must be comma separed/delimeted, without header, quoted with "') }}</p>
                        <p class="help-block">{{ trans('admin_common.location_import_info') }}</p>
                        <p class="help-block">{{ trans('admin_common.location_import_fields') }}</p>
                        <p class="help-block"><strong>{{ trans('admin_common.Example') }}:</strong><br />
                            "Location name", "location_slug", "1", "10000", "10"<br />
                            "Location name 1", "location_slug_1", "1", "12000", "20"<br />
                            "Location name 2", "location_slug_2", "1", "13000", "30"<br />
                            "Location name 3", "location_slug_3", "1", "14000", "40"<br />
                        </p>
                    </div>
                    <!-- /.box-body -->
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
@endsection

@section('js')
    <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
@endsection