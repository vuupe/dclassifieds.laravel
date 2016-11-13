@extends('layout.index_layout')

@section('title', config('dc.site_home_page_title'))

@section('search_filter')
    <div class="search_panel">
        <div class="container">
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
                                @if(isset($cid) && $cid == $v['cid'])
                                    <option value="{{$v['cid']}}" style="font-weight: bold;" selected data-type="{{ $v['category_type'] }}">{{$v['title']}}</option>
                                @else
                                    <option value="{{$v['cid']}}" style="font-weight: bold;" data-type="{{ $v['category_type'] }}">{{$v['title']}}</option>
                                @endif
                                @if(isset($v['c']) && !empty($v['c'])){
                                    @include('common.cselect', ['c' => $v['c']])
                                @endif
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <div class="col-md-3 padding_bottom_15">
                        @if(isset($l) && !empty($l))
                        <select name="lid" id="lid" class="form-control lid_select">
                            <option value="0"></option>
                            @foreach ($l as $k => $v)
                                @if(isset($lid) && $lid == $v['lid'])
                                    <option value="{{$v['lid']}}" style="font-weight: bold;" selected>{{$v['title']}}</option>
                                @else
                                    <option value="{{$v['lid']}}" style="font-weight: bold;">{{$v['title']}}</option>
                                @endif
                                @if(isset($v['c']) && !empty($v['c'])){
                                    @include('common.lselect', ['c' => $v['c']])
                                @endif
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
    </div>
@endsection

@section('content')

    @if(isset($first_level_childs) && !$first_level_childs->isEmpty())
        <div class="container category_panel">
            <div class="row">
                @foreach ($first_level_childs as $k => $v)
                    <div class="col-md-3 padding_top_bottom_15">
                        <a href="{{ $v->category_url }}" class="home-category-link"><img src="{{ asset('uf/cicons/' . $v->category_img) }}" />{{ $v->category_title }} <small class="text-muted">({{ $v->ad_count }})</small></a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(isset($promo_ad_list) && !$promo_ad_list->isEmpty())
        <div class="container home_promo_ads_panel">
            <div class="row margin_bottom_15">
                <div class="col-md-12">
                    <h3>{{ trans('home.Promo Classifieds') }}</h3>
                    <a href="{{ url('search?promo_ads=1') }}">{{ trans('home.view all promo ads') }}</a>
                </div>
            </div>
            <!-- ad row-->
            <div class="row margin_bottom_15">
                @foreach ($promo_ad_list as $k => $v)
                    @if(config('dc.show_small_item_ads_list'))
                        @include('common.ad_list_small')
                    @else
                        @include('common.ad_list')
                    @endif
                @endforeach
            </div>
            <!--end of ad row -->
        </div>
    @endif

    @if(isset($latest_ad_list) && !$latest_ad_list->isEmpty())
        <div class="container home_promo_ads_panel">
            <div class="row margin_bottom_15">
                <div class="col-md-12">
                    <h3>{{ trans('home.Latest Classifieds') }}</h3>
                </div>
            </div>

            <!-- ad row-->
            <div class="row margin_bottom_15">
                @foreach ($latest_ad_list as $k => $v)
                    @include('common.ad_list_small')
                @endforeach
            </div>
            <!--end of ad row -->
        </div>
    @endif

    <div class="container home_info_panel">
        <div class="row">
            <div class="col-md-10">
                {!! nl2br(config('dc.home_page_seo_text')) !!}
            </div>
            <div class="col-md-2">
                <div class="fb-like" data-href="{{ config('dc.facebook_site_url') }}" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
            </div>
        </div>
        <hr>
    </div>

    @if(isset($first_level_childs) && !$first_level_childs->isEmpty())
        <div class="container home_info_link_panel">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="active">{{ trans('home.Main Categories') }}</li>
                        @foreach ($first_level_childs as $k => $v)
                            <li><a href="{{ $v->category_url }}">{{ $v->category_title }}</a></li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    @endif

    @if(config('dc.enable_magic_keywords') && !$magic_keywords->isEmpty())
        <div class="container home_info_link_panel">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li class="active">{{ trans('home.Popular Searches') }}</li>
                        @foreach ($magic_keywords as $k => $v)
                            <?
                            $url = $v->keyword_url;
                            if(empty($url)){
                                $url = url('q-' . preg_replace('/\s+/', '-', $v->keyword));
                            }
                            ?>
                            <li><a href="{{ $url }}">{{ $v->keyword }}</a></li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    @endif

@endsection
