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
                    <li class="active">{{ trans('myads.My Classifieds') }}</li>
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
                        <h2>{{ trans('myads.My Classifieds') }} ({{ $my_ad_list->count() }})</h2>
                    </div>
                </div>
                @if(!$my_ad_list->isEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="max-width: 100px;">Image{{ trans('myads.Image') }}</th>
                                    <th>{{ trans('myads.Title') }}</th>
                                    <th>{{ trans('myads.Views') }}</th>
                                    <th>{{ trans('myads.Price') }}</th>
                                    <th>{{ trans('myads.Promo') }}</th>
                                    <th>{{ trans('myads.Publish date') }}</th>
                                    <th>{{ trans('myads.Expire date') }}</th>
                                    <th>{{ trans('myads.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($my_ad_list as $k => $v)
                                <?$link = url(str_slug($v->ad_title) . '-' . 'ad' . $v->ad_id . '.html');?>
                                <tr>
                                    <td>{{ $v->ad_id }}</td>
                                    <td style="max-width: 100px;">
                                        <a href="{{ $link }}" target="_blank"><img src="{{ asset('uf/adata/' . '740_' . $v->ad_pic) }}" class="img-responsive" /></a>
                                    </td>
                                    <td><a href="{{ $link }}" target="_blank">{{ $v->ad_title }}</a></td>
                                    <td>{{ $v->ad_view }}</td>
                                    <td>{{ $v->ad_price ? Util::formatPrice($v->ad_price) . config('dc.site_price_sign') : trans('myads.Free') }}</td>
                                    <td>{!! $v->ad_promo ? '<span style="color:#CFB53B; font-weight:bold;">' . trans('myads.Promo') . '</span>' : '' !!}</td>
                                    <td>{{ $v->ad_publish_date }}</td>
                                    <td>{!! date('Y-m-d') > $v->ad_valid_until ? '<span style="color:red; font-weight:bold;">' . trans('myads.Expired') . '</span>' : $v->ad_valid_until !!}</td>
                                    <td nowrap>
                                        <a href="" class="btn btn-warning btn-block btn-sm">{{ trans('myads.Make Promo') }}</a>
                                        <a href="{{ route('republish', ['token' => $v->code]) }}" class="btn btn-success btn-block btn-sm">{{ trans('myads.Republish') }}</a>
                                        <a href="{{ route('adedit', array('id' => $v->ad_id)) }}" class="btn btn-primary btn-block btn-sm">{{ trans('myads.Edit') }}</a>
                                        <a href="{{ route('delete', ['token' => $v->code]) }}" class="btn btn-danger btn-block need_confirm btn-sm">{{ trans('myads.Delete') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">{{ trans('myads.You dont have classifieds.') }} <a href="{{ url('publish') }}">{{ trans('myads.Click here to publish.') }}</a></div>
                @endif
            </div>
        </div>
    </div>
@endsection        
