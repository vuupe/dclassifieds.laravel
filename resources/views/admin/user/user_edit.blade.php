@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Users
            <small>Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('admin/user') }}">Ads</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Edit User #{{ $modelData->user_id }}</h3>
                    </div>
                    <!-- /.box-header -->

                    <form role="form" method="post" name="edit_form" id="edit_form" enctype="multipart/form-data">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Util::getOldOrModelValue('name', $modelData) }}" maxlength="255" />
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">E-Mail</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ Util::getOldOrModelValue('email', $modelData) }}" maxlength="255" />
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="location_parent_id">Location</label>
                                <select class="form-control chosen_select" name="user_location_id" id="user_location_id" data-placeholder="User Location">
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

                            <div class="form-group">
                                <label for="user_address" class="control-label">Address</label>
                                <input type="text" class="form-control" id="user_address" name="user_address" value="{{ Util::getOldOrModelValue('user_address', $modelData) }}" maxlength="255" />
                            </div>

                            <div class="form-group">
                                <label for="user_phone" class="control-label">Phone</label>
                                <input type="text" class="form-control" id="user_phone" name="user_phone" value="{{ Util::getOldOrModelValue('user_phone', $modelData) }}" maxlength="255" />
                            </div>

                            <div class="form-group">
                                <label for="user_skype" class="control-label">Skype</label>
                                <input type="text" class="form-control" id="user_skype" name="user_skype" value="{{ Util::getOldOrModelValue('user_skype', $modelData) }}" maxlength="255" />
                            </div>

                            <div class="form-group">
                                <label for="user_site" class="control-label">Site</label>
                                <input type="text" class="form-control" id="user_site" name="user_site" value="{{ Util::getOldOrModelValue('user_site', $modelData) }}" maxlength="255" />
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="created_at" class="control-label">Registered at</label>
                                <input type="text" class="form-control" id="created_at" name="created_at" value="{{ Util::getOldOrModelValue('created_at', $modelData) }}" maxlength="255" readonly />
                            </div>

                            <div class="form-group">
                                <label for="updated_at" class="control-label">Updated at</label>
                                <input type="text" class="form-control" id="updated_at" name="updated_at" value="{{ Util::getOldOrModelValue('updated_at', $modelData) }}" maxlength="255" readonly />
                            </div>

                            <hr>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="user_activated" {{ Util::getOldOrModelValue('user_activated', $modelData) ? 'checked' : '' }}> User Activated
                                </label>
                            </div>

                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="is_admin" {{ Util::getOldOrModelValue('is_admin', $modelData) ? 'checked' : '' }}> User is Admin
                                </label>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
                <!-- /.box -->
            </div>

            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">User #{{ $modelData->user_id }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?$link = url('ad/user/' . $modelData->user_id);?>
                        <p class="help-block">User URL: <a href="{{ $link }}" target="_blank">{{ $link }}</a></p>

                        <hr>

                        <?if(isset($modelData->avatar) && !empty($modelData->avatar)){?>
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ $link }}" target="_blank">
                                        <img src="{{ asset('uf/udata/100_' . $modelData->avatar) }}" />
                                    </a>
                                    <a href="{{ url('admin/user/deleteavatar/' . $modelData->user_id) }}" class="btn btn-danger btn-sm need_confirm">Delete</a>
                                </div>
                            </div>
                        <?}?>
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
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/datepicker/datepicker3.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/flat/blue.css')}}">
@endsection

@section('js')
    <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{asset('adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('adminlte/plugins/fastclick/fastclick.js')}}"></script>
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

        $('#ad_valid_until, #ad_promo_until').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
         });
    });
    </script>
@endsection

