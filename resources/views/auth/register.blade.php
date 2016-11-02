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
                    <li><a href="{{ route('home') }}">{{ trans('register.Home') }}</a></li>
                    <li class="active">{{ trans('register.Register') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
                        <h2>{{ trans('register.Register') }}</h2>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                @endif

                <form class="form-horizontal" method="POST" action="{{url('register')}}">

                    {!! csrf_field() !!}

                    <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-2 control-label">{{ trans('register.Name') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-2 control-label">{{ trans('register.E-Mail') }}</label>
                        <div class="col-md-5">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-2 control-label">{{ trans('register.Password') }}</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label for="password_confirmation" class="col-md-2 control-label">{{ trans('register.Password Again') }}</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" >
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('policy_agree') ? ' has-error' : '' }}">
                        <label for="policy_agree" class="col-md-2 control-label"></label>
                        <div class="col-md-5">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="policy_agree" {{ old('policy_agree') ? 'checked' : '' }}> {{ trans('publish_edit.I agree with') }} <a href="{{ config('dc.privacy_policy_link') }}" target="_blank">{{ trans('publish_edit."Privacy Policy"') }}</a>
                                </label>
                                @if ($errors->has('policy_agree'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('policy_agree') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(config('dc.enable_recaptcha_register'))
                    <div class="form-group required {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                        <label for="contact_message" class="control-label col-md-2">{{ trans('contact.Captcha') }}</label>
                        <div class="col-md-5">
                            {!! Recaptcha::render() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="submit" class="btn btn-primary">{{ trans('register.Register') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
