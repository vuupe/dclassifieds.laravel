@extends('layout.index_layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ trans('myprofile.Home') }}</a></li>
                    <li class="active">{{ trans('myprofile.My Profile') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li role="presentation" class="active"><a href="{{ url('myprofile') }}">{{ trans('myprofile.My Profile') }}</a></li>
                    <li role="presentation"><a href="{{ url('myads') }}">{{ trans('myprofile.My Classifieds') }}</a></li>
                    <li role="presentation"><a href="{{ url('mymail') }}">{{ trans('myprofile.My Messages') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if (session()->has('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                @endif

                <form class="form-horizontal" method="POST" enctype="multipart/form-data">

                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            <h2>{{ trans('myprofile.My Profile') }}</h2>
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">{{ trans('myprofile.Name') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="name" name="name" value="{{ Util::getOldOrModelValue('name', $user) }}" maxlength="255"/>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">{{ trans('myprofile.E-Mail') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="email" name="email" value="{{ Util::getOldOrModelValue('email', $user) }}" maxlength="255" readonly/>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('avatar_img') ? ' has-error' : '' }}">
                        <label for="avatar_img" class="col-md-4 control-label">{{ trans('myprofile.Avatar') }}</label>
                        <div class="col-md-5">
                            <input type="file" name="avatar_img">
                            @if ($errors->has('avatar_img'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('avatar_img') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h4>{{ trans('myprofile.If you want fill your contact info') }}</h4>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('user_location_id') ? ' has-error' : '' }}">
                        <label for="user_location_id" class="col-md-4 control-label">{{ trans('myprofile.Location') }}</label>
                        <div class="col-md-5">
                            @if(isset($l) && !empty($l))
                            <select name="user_location_id" id="user_location_id" class="form-control lid_select">
                                <option value="0"></option>
                                @foreach ($l as $k => $v)
                                    <optgroup label="{{$v['title']}}">
                                        @if(isset($v['c']) && !empty($v['c'])){
                                            @include('common.lselect', ['c' => $v['c'], 'lid' => Util::getOldOrModelValue('user_location_id', $user)])
                                        @endif
                                    </optgroup>
                                @endforeach
                            </select>
                            @endif
                            @if ($errors->has('user_location_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('user_location_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user_address" class="col-md-4 control-label">{{ trans('myprofile.Address') }}</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control" id="user_address" name="user_address" value="{{ Util::getOldOrModelValue('user_address', $user) }}" maxlength="255" />
                                <span class="input-group-btn">
                                    <input type="button" class="btn btn-info" id="ad_address_show_map" name="ad_address_show_map" value="{{ trans('myprofile.Find on Map') }}" >
                                </span>
                            </div>
                            <input type="hidden" class="form-control" id="user_lat_lng" name="user_lat_lng" value="{{ Util::getOldOrModelValue('user_lat_lng', $user) }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user_phone" class="col-md-4 control-label">{{ trans('myprofile.Phone') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="user_phone" name="user_phone" value="{{ Util::getOldOrModelValue('user_phone', $user) }}" maxlength="255" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user_skype" class="col-md-4 control-label">{{ trans('myprofile.Skype') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="user_skype" name="user_skype" value="{{ Util::getOldOrModelValue('user_skype', $user) }}" maxlength="255" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user_site" class="col-md-4 control-label">{{ trans('myprofile.Web Site') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="user_site" name="user_site" value="{{ Util::getOldOrModelValue('user_site', $user) }}" maxlength="255" />
                            <span id="helpBlock" class="help-block">{{ trans('myprofile.Insert link to your site in this format: http://www.site.com') }}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <h4>{{ trans('myprofile.If you want to change your password, type new one, if not leave blank') }}</h4>
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">{{ trans('myprofile.Password') }}</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" id="password" name="password" value="{{ Util::getOldOrModelValue('password', $user) }}" maxlength="255" />
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">{{ trans('myprofile.Password Again') }}</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ Util::getOldOrModelValue('password_confirmation', $user) }}" maxlength="255" />
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn btn-primary">{{ trans('myprofile.Save') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="google_map_container" style="display:none;">
        <div style="margin:10px 0px 20px 0px">
            <form class="form-inline">
                <div class="form-group">
                    <input type="text" name="address" id="address" class="form-control" style="width:445px;"/>
                    <input type="hidden" name="lat" id="lat"/>
                    <button type="button" name="location_find" id="location_find" class="btn btn-primary">
                        <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> {{ trans('myprofile.Find on the map') }}
                    </button>
                    <button type="button" name="location_ok" id="location_ok" class="btn btn-success">
                        <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span> {{ trans('myprofile.Yes, this is my location') }}
                    </button>
                </div>
            </form>
        </div>
        <div style="width: 800px; height:400px;" id="map_canvas"></div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('js/fancybox/jquery.fancybox.css')}}" />
@endsection

@section('js')
    <script src="{{asset('js/fancybox/jquery.fancybox.pack.js')}}"></script>
    <script src="http://maps.googleapis.com/maps/api/js?sensor=true&language=en"></script>
    <script>
        var __LOCATION_FIELD_ID = 'user_location_id';
        var __ADDESS_FIELD_ID = 'user_address';
        var __LAT_LNG_FIELD_ID = 'user_lat_lng';
    </script>
    <script src="{{ asset('js/google.map.js') }}"></script>
@endsection