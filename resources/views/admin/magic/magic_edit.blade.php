@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Magic Keywords') }}
            <small>{{ trans('admin_common.Add/Edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/adtype') }}">{{ trans('admin_common.Magic Keywords') }}</a></li>
            <li class="active">{{ trans('admin_common.Add/Edit') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">{{ trans('admin_common.Add/Edit Magic Keyword') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('keyword') ? ' has-error' : '' }}">
                                <label for="keyword" class="control-label">{{ trans('admin_common.Keyword') }}</label>
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="{{ trans('admin_common.Keyword') }}" value="{{ Util::getOldOrModelValue('keyword', $modelData) }}">
                                @if ($errors->has('keyword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('keyword') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('keyword_count') ? ' has-error' : '' }}">
                                <label for="keyword_count" class="control-label">{{ trans('admin_common.Count') }}</label>
                                <input type="text" class="form-control" name="keyword_count" id="keyword_count" placeholder="{{ trans('admin_common.Count') }}" value="{{ Util::getOldOrModelValue('keyword_count', $modelData) }}">
                                @if ($errors->has('keyword_count'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('keyword_count') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="keyword_url" class="control-label">{{ trans('admin_common.Url') }}</label>
                                <input type="text" class="form-control" name="keyword_url" id="keyword_url" placeholder="{{ trans('admin_common.Url') }}" value="{{ Util::getOldOrModelValue('keyword_url', $modelData) }}">
                                @if ($errors->has('keyword_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('keyword_url') }}</strong>
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