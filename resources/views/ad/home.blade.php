@extends('layout.index_layout')

@section('search_filter')
    <div class="container search_panel">
        <form method="GET" action="{{ url('proxy') }}" class="form" id="search_form">
            <div class="row">
                <div class="col-md-3 padding_bottom_15">
                    <input type="text" name="search_text" id="search_text" class="form-control" placeholder="{{ trans('home.1 000 000 Ads') }}" value="{{ isset($search_text) ? stripslashes($search_text) : '' }}"/>
                </div>
                <div class="col-md-3 padding_bottom_15">
                    @if(isset($c) && !empty($c))
                    <select name="cid" id="cid" class="form-control cid_select" onchange="$('#search_form').submit();">
                        <option value="0"></option>
                        @foreach ($c as $k => $v)
                            <optgroup label="{{$v['title']}}">
                                @if(isset($v['c']) && !empty($v['c'])){
                                    @include('common.cselect', ['c' => $v['c']])
                                @endif
                            </optgroup>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-md-3 padding_bottom_15">
                    @if(isset($l) && !empty($l))
                    <select name="lid" id="lid" class="form-control lid_select">
                        <option value="0"></option>
                        @foreach ($l as $k => $v)
                            <optgroup label="{{$v['title']}}">
                                @if(isset($v['c']) && !empty($v['c'])){
                                    @include('common.lselect', ['c' => $v['c']])
                                @endif
                            </optgroup>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-md-3 padding_bottom_15">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span> {{ trans('home.Search') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')

    <div class="container category_panel">
        <div class="row">
        @foreach ($clist as $k => $v)
            <div class="col-md-3 padding_top_bottom_15"><a href="{{ $v->category_url }}"><img src="{{ asset('uf/cicons/' . $v->category_img) }}" /> {{ $v->category_title }}</a></div>
        @endforeach
        </div>
    </div>

    <div class="container home_promo_ads_panel">
        <div class="row margin_bottom_15">
            <div class="col-md-12">
                <h2>{{ trans('home.Promo Classifieds') }}</h2>
            </div>
        </div>

        <!-- ad row-->
        <div class="row margin_bottom_15">
            @if(isset($promo_ad_list) && !$promo_ad_list->isEmpty())
                @foreach ($promo_ad_list as $k => $v)
                    @include('common.ad_list')
                @endforeach
            @endif
        </div>
        <!--end of ad row -->
    </div>

    <div class="container home_info_panel">
        <div class="row">
            <div class="col-md-10">
                {!! nl2br(config('dc.home_page_seo_text')) !!}
            </div>
            <div class="col-md-2">
                <div class="fb-like" data-href="{{ config('dc.facebook_site_url') }}" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
            </div>
        </div>
    </div>

    <div class="container home_info_link_panel">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                      <li class="active">Main Cateegories</li>
                      <li><a href="#">Real Estates</a></li>
                      <li><a href="#">Cars and Parts</a></li>
                      <li><a href="#">Electronics</a></li>
                      <li><a href="#">Sport, Books, Hobby</a></li>
                      <li><a href="#">Home and Garden</a></li>
                      <li><a href="#">Fashion</a></li>
                      <li><a href="#">Baby and Kids</a></li>
                      <li><a href="#">Тourism</a></li>
                      <li><a href="#">Business, Services</a></li>
                      <li><a href="#">Job</a></li>
                </ol>
            </div>
        </div>
    </div>
@endsection
