@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Categories') }}
            <small>{{ trans('admin_common.Add/Edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/category') }}">{{ trans('admin_common.Categories') }}</a></li>
            <li class="active">{{ trans('admin_common.Add/Edit') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin_common.Add/Edit Categories') }}</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form" enctype="multipart/form-data">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="category_parent_id">{{ trans('admin_common.Category Parent') }}</label>
                                <select class="form-control chosen_select" name="category_parent_id" id="category_parent_id" data-placeholder="{{ trans('admin_common.Select Parent Category') }}">
                                <option value="0"></option>
                                @foreach ($c as $k => $v)
                                    @if(isset($cid) && $cid == $v['cid'])
                                        <option value="{{$v['cid']}}" selected>{{$v['title']}}</option>
                                    @else
                                        <option value="{{$v['cid']}}">{{$v['title']}}</option>
                                    @endif

                                    @if(isset($v['c']) && !empty($v['c'])){
                                        @include('common.cselect', ['c' => $v['c']])
                                    @endif
                                @endforeach
                                </select>
                            </div>

                            <div class="form-group required {{ $errors->has('category_type') ? ' has-error' : '' }}">
                                <label for="category_type" class="control-label">{{ trans('admin_common.Category Type') }}</label>
                                <select class="form-control chosen_select" name="category_type" id="category_type" data-placeholder="{{ trans('admin_common.Select Category Type') }}">
                                <option value=""></option>
                                @foreach ($categoryType as $k => $v)
                                    @if(Util::getOldOrModelValue('category_type', $modelData) == $k)
                                        <option value="{{$k}}" selected>{{$v}}</option>
                                    @else
                                        <option value="{{$k}}">{{$v}}</option>
                                    @endif
                                @endforeach
                                </select>
                                @if ($errors->has('category_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('category_title') ? ' has-error' : '' }}">
                                <label for="category_title" class="control-label">{{ trans('admin_common.Category Name') }}</label>
                                <input type="text" class="form-control" name="category_title" id="category_title" placeholder="{{ trans('admin_common.Category Name') }}" value="{{ Util::getOldOrModelValue('category_title', $modelData) }}">
                                @if ($errors->has('category_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('category_slug') ? ' has-error' : '' }}">
                                <label for="category_slug" class="control-label">{{ trans('admin_common.Category Slug') }}</label>
                                <input type="text" class="form-control" name="category_slug" id="category_slug" placeholder="{{ trans('admin_common.Category Slug') }}" value="{{ Util::getOldOrModelValue('category_slug', $modelData) }}">
                                @if ($errors->has('category_slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_slug') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="category_description" class="control-label">{{ trans('admin_common.Category Description') }}</label>
                                <input type="text" class="form-control" name="category_description" id="category_description" placeholder="{{ trans('admin_common.Category Description') }}" value="{{ Util::getOldOrModelValue('category_description', $modelData) }}">
                            </div>

                            <div class="form-group">
                                <label for="category_keywords" class="control-label">{{ trans('admin_common.Category Keywords') }}</label>
                                <input type="text" class="form-control" name="category_keywords" id="category_keywords" placeholder="{{ trans('admin_common.Category Keywords') }}" value="{{ Util::getOldOrModelValue('category_keywords', $modelData) }}">
                            </div>

                            <div class="form-group required {{ $errors->has('category_ord') ? ' has-error' : '' }}">
                                <label for="category_ord" class="control-label">{{ trans('admin_common.Category Order') }}</label>
                                <input type="text" class="form-control" name="category_ord" id="category_ord" placeholder="{{ trans('admin_common.Category Order') }}" value="{{ Util::getOldOrModelValue('category_ord', $modelData) }}">
                                @if ($errors->has('category_ord'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_ord') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="icon_file" class="control-label">{{ trans('admin_common.Category Icon') }}</label>
                                <input type="file" name="icon_file" id="icon_file">
                                <p class="help-block">{{ trans('admin_common.Visible only for main categories') }}</p>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="category_active" id="category_active" {{ Util::getOldOrModelValue('category_active', $modelData) > 0 ? 'checked' : '' }}> {{ trans('admin_common.Active') }}
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
@endsection

@section('js')
    <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
@endsection