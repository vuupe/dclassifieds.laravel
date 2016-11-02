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
                    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> {{ trans('register.Home') }}</a></li>
                    <li class="active">{{ trans('contact.Contact Us') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
                        <h2>{{ trans('contact.Contact Us') }}</h2>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                @endif

                <form class="form-horizontal" method="POST">

                    {!! csrf_field() !!}

                    <div class="form-group required {{ $errors->has('contact_name') ? ' has-error' : '' }}">
                        <label for="contact_name" class="control-label col-md-2">{{ trans('contact.Your name') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="{{ trans('contact.Your name') }}" value="{{ old('contact_name') }}" maxlength="255"/>
                            @if ($errors->has('contact_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('contact_mail') ? ' has-error' : '' }}">
                        <label for="contact_mail" class="control-label col-md-2">{{ trans('contact.Your E-Mail') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="contact_mail" name="contact_mail" placeholder="{{ trans('contact.Your E-Mail') }}" value="{{ old('contact_mail') }}" maxlength="255"/>
                            @if ($errors->has('contact_mail'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_mail') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group required {{ $errors->has('contact_message') ? ' has-error' : '' }}">
                        <label for="contact_message" class="control-label col-md-2">{{ trans('contact.Message') }}</label>
                        <div class="col-md-5">
                            <textarea class="form-control" rows="7" name="contact_message" id="contact_message">{{ old('contact_message') }}</textarea>
                            @if ($errors->has('contact_message'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_message') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @if(config('dc.enable_recaptcha_site_contact'))
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
                            <button type="submit" class="btn btn-primary">{{ trans('contact.Send') }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
