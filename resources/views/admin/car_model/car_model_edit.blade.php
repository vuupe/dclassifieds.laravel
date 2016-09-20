@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Car Models
            <small>Add/Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/carmodel') }}">Car Models</a></li>
            <li class="active">Add/Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add/Edit Car Model</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('car_brand_id') ? ' has-error' : '' }}">
                                <label for="car_brand_id" class="control-label">Car Brand</label>
                                @if(!$car_brand_id->isEmpty())
                                <select name="car_brand_id" id="car_brand_id" class="form-control chosen_select" data-placeholder="Select Car Brand">
                                    <option value="0"></option>
                                    @foreach ($car_brand_id as $k => $v)
                                        @if(Util::getOldOrModelValue('car_brand_id', $modelData) == $v->car_brand_id)
                                            <option value="{{ $v->car_brand_id }}" selected>{{ $v->car_brand_name }}</option>
                                        @else
                                            <option value="{{ $v->car_brand_id }}">{{ $v->car_brand_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                                @if ($errors->has('car_brand_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_brand_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('car_model_name') ? ' has-error' : '' }}">
                                <label for="car_model_name" class="control-label">Car Model</label>
                                <input type="text" class="form-control" name="car_model_name" id="car_model_name" placeholder="Car Model" value="{{ Util::getOldOrModelValue('car_model_name', $modelData) }}">
                                @if ($errors->has('car_model_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('car_model_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="car_model_active" id="car_model_active" {{ Util::getOldOrModelValue('car_model_active', $modelData) > 0 ? 'checked' : '' }}> Car Model Active
                                </label>
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
@endsection

@section('js')
    <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
@endsection