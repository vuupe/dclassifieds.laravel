@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Locations
            <small>Add/Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/location') }}">Locations</a></li>
            <li class="active">Add/Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add/Edit Locations</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="location_parent_id">Location Parent</label>
                                <select class="form-control chosen_select" name="location_parent_id" id="location_parent_id" data-placeholder="Select Parent Location">
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

                            <div class="form-group required {{ $errors->has('location_name') ? ' has-error' : '' }}">
                                <label for="location_name" class="control-label">Location Name</label>
                                <input type="text" class="form-control" name="location_name" id="location_name" placeholder="Location Name" value="{{ Util::getOldOrModelValue('location_name', $modelData) }}">
                                @if ($errors->has('location_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('location_slug') ? ' has-error' : '' }}">
                                <label for="location_slug" class="control-label">Location Slug</label>
                                <input type="text" class="form-control" name="location_slug" id="location_slug" placeholder="Location Slug" value="{{ Util::getOldOrModelValue('location_slug', $modelData) }}">
                                @if ($errors->has('location_slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location_slug') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="location_post_code" class="control-label">Location Post Code</label>
                                <input type="text" class="form-control" name="location_post_code" id="location_post_code" placeholder="Location Post Code" value="{{ Util::getOldOrModelValue('location_post_code', $modelData) }}">
                            </div>

                            <div class="form-group">
                                <label for="location_ord" class="control-label">Location Order</label>
                                <input type="text" class="form-control" name="location_ord" id="location_ord" placeholder="Location Order" value="{{ Util::getOldOrModelValue('location_ord', $modelData) }}">
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="location_active" id="location_active" {{ Util::getOldOrModelValue('location_active', $modelData) > 0 ? 'checked' : '' }}> Location Active
                                </label>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Add/Save Location</button>
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
@endsection

@section('js')
    <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
@endsection