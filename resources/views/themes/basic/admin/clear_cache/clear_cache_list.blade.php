@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Clear Cache') }}
            <small>{{ trans('admin_common.List') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li class="active">{{ trans('admin_common.Clear Cache') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    

    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-info"></i> {{ trans('admin_common.Information') }}</h4>
        {{ $message }}
    </div>

    
    </section>
    <!-- /.content -->
@endsection