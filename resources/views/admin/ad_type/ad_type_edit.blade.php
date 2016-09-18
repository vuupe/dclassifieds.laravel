@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ad Types
            <small>Add/Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/adtype') }}">Ad Types</a></li>
            <li class="active">Add/Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add/Edit Ad Types</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('ad_type_name') ? ' has-error' : '' }}">
                                <label for="ad_type_name" class="control-label">Ad Type</label>
                                <input type="text" class="form-control" name="ad_type_name" id="ad_type_name" placeholder="Ad Type" value="{{ Util::getOldOrModelValue('ad_type_name', $modelData) }}">
                                @if ($errors->has('ad_type_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ad_type_name') }}</strong>
                                    </span>
                                @endif
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