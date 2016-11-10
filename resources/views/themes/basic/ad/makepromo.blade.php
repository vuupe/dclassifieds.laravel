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
                    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> {{ trans('myads.Home') }}</a></li>
                    <li><a href="{{ route('myads') }}">{{ trans('myads.My Classifieds') }}</a></li>
                    <li class="active">{{ trans('makepromo.Make promo Ad Id') . ' #' . $ad_detail->ad_id }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li role="presentation"><a href="{{ url('myprofile') }}">{{ trans('myads.My Profile') }}</a></li>
                    <li role="presentation" class="active"><a href="{{ url('myads') }}">{{ trans('myads.My Classifieds') }}</a></li>
                    @if(config('dc.enable_promo_ads'))
                        <li role="presentation"><a href="{{ url('mywallet') }}">{{ trans('mywallet.My Wallet') }}</a></li>
                    @endif
                    <li role="presentation"><a href="{{ url('mymail') }}">{{ trans('myads.My Messages') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container margin_bottom_15">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{ trans('makepromo.Make promo Ad Id') . ' #' . $ad_detail->ad_id }}</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('message'))
                            <div class="alert alert-info">{{ session('message') }}</div>
                        @endif

                        @if(config('dc.enable_promo_ads') && !$payment_methods->isEmpty())
                            <form method="POST" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="form-group required {{ $errors->has('ad_type_pay') ? ' has-error' : '' }}">
                                    <label class="control-label">{{ trans('makepromo.Choose payment method') }}</label>

                                    <?
                                    $checked = 0;
                                    if($enable_pay_from_wallet){
                                        $checked = 1000;
                                    }
                                    if(old('ad_type_pay')){
                                        $checked = old('ad_type_pay');
                                    }
                                    ?>

                                    @if($enable_pay_from_wallet)
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="ad_type_pay" value="1000" {{ (1000 == $checked) ? 'checked' : '' }}> {{ trans('publish_edit.Pay promo ad from wallet', ['sum' => config('dc.wallet_promo_ad_price'), 'cur' => config('dc.site_price_sign'), 'period' => config('dc.wallet_promo_ad_period')]) }}
                                            </label>
                                        </div>
                                    @endif

                                    @foreach($payment_methods as $k => $v)
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="ad_type_pay" value="{{ $v->pay_id }}" {{ ($v->pay_id == $checked) ? 'checked' : '' }}> {{ trans('publish_edit.Pay promo ad payment method', ['sum' => number_format($v->pay_sum, 2, '.', ''), 'cur' => config('dc.site_price_sign'), 'period' => $v->pay_promo_period, 'pay_type' => $v->pay_name]) }}
                                            </label>
                                        </div>
                                    @endforeach

                                    @if ($errors->has('ad_type_pay'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ad_type_pay') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{ trans('makepromo.Make Promo') }}</button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-info">{{ trans('makepromo.No active payment methods, please contact us.') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
