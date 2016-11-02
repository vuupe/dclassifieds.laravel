@extends('layout.index_layout')

@section('title', join(' / ', $title))

@section('search_filter')
    <div style="margin-bottom: 20px;"></div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ trans('login.Home') }}</a></li>
                    <li class="active">{{ trans('login.Login') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
                        <h2>{{ trans('login.Login') }}</h2>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ url('login') }}">

                    {!! csrf_field() !!}

                    <div class="form-group required {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-2 control-label">{{ trans('login.E-Mail') }}</label>
                        <div class="col-md-5">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <p class="help-block">
                                Use: test@test.com<br />
                                Password: 123456
                            </p>
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-2 control-label">{{ trans('login.Password') }}</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" name="password" id="password" >
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> {{ trans('login.Remember me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10 margin_bottom_15">
                            <button type="submit" class="btn btn-primary">{{ trans('login.Login') }}</button>
                        </div>
                        <div class="col-md-offset-2 col-md-10">
                            <a href="{{ url('register') }}">{{ trans('login.Register') }}</a> | <a href="{{ url('lostpassword') }}">{{ trans('login.Lost Password?') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
