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
                    <li class="active">{{ trans('mywallet.My Wallet') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                    <li role="presentation"><a href="{{ url('myprofile') }}">{{ trans('myads.My Profile') }}</a></li>
                    <li role="presentation"><a href="{{ url('myads') }}">{{ trans('myads.My Classifieds') }}</a></li>
                    @if(config('dc.enable_promo_ads'))
                        <li role="presentation" class="active"><a href="{{ url('mywallet') }}">{{ trans('mywallet.My Wallet') }}</a></li>
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
                        <h2>
                            {{ trans('mywallet.My Wallet') }} -
                            @if($wallet_total > 0)
                                <span style="color: green;">{{ trans('mywallet.Total:') }} {{ Util::formatPrice($wallet_total, config('dc.site_price_sign')) }}</span>
                            @else
                                <span style="color: red;">{{ trans('mywallet.Total:') }} {{ Util::formatPrice($wallet_total, config('dc.site_price_sign')) }}</span>
                            @endif
                        </h2>
                    </div>
                </div>
                <div class="row margin_bottom_15">
                    <div class="col-md-12">
                        <a href="{{ url('addtowallet') }}" class="btn btn-success">{{ trans('mywallet.Click here to add money to your wallet.') }}</a>
                    </div>
                </div>
                @if(isset($walletList) && !$walletList->isEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('mywallet.Date') }}</th>
                                    <th>{{ trans('mywallet.Ad Id') }}</th>
                                    <th style="font-weight: bold; text-align: right;">{{ trans('mywallet.Sum') }}</th>
                                    <th>{{ trans('mywallet.Description') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($walletList as $k => $v)
                                <tr>
                                    <td>{{ $v->wallet_id }}</td>
                                    <td>{{ $v->wallet_date }}</td>
                                    <td>{{ $v->ad_id }}</td>
                                    <td style="font-weight: bold; text-align: right;">
                                        @if($v->sum > 0)
                                            <span style="color:green;">{{ Util::formatPrice($v->sum, config('dc.site_price_sign')) }}</span>
                                        @else
                                            <span style="color:red;">{{ Util::formatPrice($v->sum, config('dc.site_price_sign')) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $v->wallet_description }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <nav>{{  $walletList->appends($params)->links() }}</nav>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">{{ trans('mywallet.You dont have money in your wallet.') }} <strong><a href="{{ url('addtowallet') }}">{{ trans('mywallet.Click here to add money to your wallet.') }}</a></strong></div>
                @endif
            </div>
        </div>
    </div>
@endsection
