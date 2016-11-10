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
                    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> {{ trans('mailview.Home') }}</a></li>
                    <li><a href="{{ route('mymail') }}">{{ trans('mailview.My Messages') }}</a></li>
                    <li class="active">{{ trans('mailview.Mail View') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container margin_bottom_15">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li role="presentation"><a href="{{ url('myprofile') }}">{{ trans('mailview.My Profile') }}</a></li>
                    <li role="presentation"><a href="{{ url('myads') }}">{{ trans('mailview.My Classifieds') }}</a></li>
                    @if(config('dc.enable_promo_ads'))
                        <li role="presentation"><a href="{{ url('mywallet') }}">{{ trans('mywallet.My Wallet') }}</a></li>
                    @endif
                    <li role="presentation" class="active"><a href="{{ url('mymail') }}">{{ trans('mailview.My Messages') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container margin_bottom_15">
        <div class="row">
            <div class="col-md-12">
                @if(!$mailList->isEmpty())
                    @foreach($mailList as $k => $v)
                        @if($v->user_id_from == Auth::user()->user_id)
                            <div class="media">
                                <div class="media-body">
                                    <h4>{{ $v->name }}</h4>
                                    <p>{!! $v->mail_text !!}</p>
                                    <p><small class="text-muted">{{ $v->mail_date }}</small></p>
                                </div>
                                <div class="media-right">
                                    <a href="{{ url('ad/user/' . Auth::user()->user_id) }}">
                                        @if(empty(Auth::user()->avatar))
                                            <img class="media-object" src="{{ 'https://www.gravatar.com/avatar/' . md5(trim(Auth::user()->email)) . '?s=100&d=identicon' }}" alt="{{ Auth::user()->name }}">
                                        @else
                                            <img class="media-object" src="{{ asset('uf/udata/100_' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="media">
                                <div class="media-left">
                                    <a href="{{ url('ad/user/' . $v->user_id) }}">
                                        @if(empty($v->avatar))
                                            <img class="media-object" src="{{ 'https://www.gravatar.com/avatar/' . md5(trim($v->email)) . '?s=100&d=identicon' }}" alt="{{ $v->name }}">
                                        @else
                                            <img class="media-object" src="{{ asset('uf/udata/100_' . $v->avatar) }}" alt="{{ $v->name }}" >
                                        @endif
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4>{{ $v->name }}</h4>
                                    <p>{!! $v->mail_text !!}</p>
                                    <p><small class="text-muted">{{ $v->mail_date }}</small></p>
                                </div>
                            </div>
                        @endif
                        <hr>
                    @endforeach
                    <a href="{{ route('maildelete', ['hash' => $hash]) }}" class="btn btn-danger need_confirm btn-sm">{{ trans('mailview.Delete Conversation') }}</a>
                @else
                    <div class="alert alert-info">{{ trans('mailview.You dont have messages.') }}</div>
                @endif
            </div>
        </div>

        <!-- send message form -->
        @if (session()->has('message'))
            <div class="alert alert-info">{{ session('message') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <h4>{{ trans('mailview.Send Message') }}</h4>
            </div>
        </div>

        <div class="row margin_bottom_15">
            <div class="col-md-12">
                <form method="POST">
                    {!! csrf_field() !!}
                    <div class="form-group required {{ $errors->has('contact_message') ? ' has-error' : '' }}">
                        <label for="contact_message" class="control-label">{{ trans('mailview.Message') }}</label>
                        <textarea class="form-control" rows="7" name="contact_message" id="contact_message">{{ old('contact_message') }}</textarea>
                        @if ($errors->has('contact_message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('contact_message') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">{{ trans('mailview.Send') }}</button>
                </form>
            </div>
        </div>
        <!-- end of send message form -->
    </div>
@endsection