@extends('layout.index_layout')

@section('title', join(' / ', $title))

@section('header_tags')
    <link rel="canonical" href="{{ url(str_slug($ad_detail->ad_title) . '-' . 'ad' . $ad_detail->ad_id . '.html') }}" />
    <meta property="og:title" content="{{ join(' / ', $title) }}"/>
    <meta property="og:site_name" content="{{ config('dc.site_domain') }}"/>
    <meta property="og:image" content="{{ asset('uf/adata/1000_' . $ad_detail->ad_pic) }}"/>
@endsection

@section('search_filter')
    <div style="margin-bottom: 20px;"></div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb" vocab="http://schema.org/" typeof="BreadcrumbList">
                    <li property="itemListElement" typeof="ListItem"><a href="{{ route('home') }}" property="item" typeof="WebPage"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <span property="name">{{ trans('detail.Home') }}</span></a></li>
                    <li property="itemListElement" typeof="ListItem"><a href="{{ url('l-' . $ad_detail->location_slug)}}" property="item" typeof="WebPage"><span property="name">{{ $ad_detail->location_name }}</span></a></li>
                    @if(isset($breadcrump['c']) && !empty($breadcrump['c']))
                        @foreach ($breadcrump['c'] as $k => $v)
                            <li property="itemListElement" typeof="ListItem"><a href="{{ $v['category_url'] }}" property="item" typeof="WebPage"><span property="name">{{ $v['category_title'] }}</span></a></li>
                        @endforeach
                    @endif
                    <li class="active wrap" property="itemListElement" typeof="ListItem"><span property="name">{{ $ad_detail->ad_title }}</span></li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container ad_detail_container" itemscope itemtype="http://schema.org/Product">
        <div class="row">
            <div class="col-md-12"><h1 class="wrap" itemprop="name">{{ $ad_detail->ad_title }}</h1></div>
        </div>
        <div class="row ad_detail_publish_info">
            <div class="col-md-12"><a href="{{ url('l-' . $ad_detail->location_slug)}}">{{ $ad_detail->location_name }}</a> | <span class="text-muted">{{ trans('detail.Added on') }} {{ $ad_detail->ad_publish_date }}.</span></div>
        </div>
        <div class="row ad_detail_ad_info">
            <div class="col-md-12"><span class="text-muted">{{ trans('detail.Ad Id') }}: <span itemprop="productID">{{ $ad_detail->ad_id }}</span> | {{ trans('detail.Views') }}: {{ $ad_detail->ad_view }}</span></div>
        </div>
        <div class="row ad_detail_ad_info">
            <div class="col-md-12">
                <div class="pull-left">
                    <g:plusone></g:plusone>
                </div>
                <div class="pull-left" style="height:24px;">
                    <div class="fb-like" data-href="{{ url(str_slug($ad_detail->ad_title) . '-' . 'ad' . $ad_detail->ad_id . '.html') }}" data-send="true" data-width="450" data-show-faces="false"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">

                <div class="row">
                    <div class="col-md-12">
                        <div class="ad_detail_main_image_container">
                            @if($ad_detail->ad_promo)
                                <div class="ribbon"><span>{{ trans('detail.PROMO') }}</span></div>
                            @endif
                            @if(!empty($ad_detail->ad_pic))
                                <a href="{{ asset('uf/adata/1000_' . $ad_detail->ad_pic) }}" class="fancybox" rel="group"><img src="{{ asset('uf/adata/740_' . $ad_detail->ad_pic) }}" class="img-responsive"  itemprop="image" /></a>
                            @else
                                <img src="{{ 'https://www.gravatar.com/avatar/' . md5(trim($ad_detail->email)) . '?s=740&d=identicon' }}" class="img-responsive">
                            @endif
                        </div>
                    </div>
                </div>

                @if(isset($ad_pic) && !$ad_pic->isEmpty())
                    <div class="row">
                        @foreach($ad_pic as $k => $v)
                            <div class="col-md-3">
                                <a href="{{ asset('uf/adata/1000_' . $v->ad_pic) }}" class="fancybox" rel="group">
                                    <img src="{{ asset('uf/adata/1000_' . $v->ad_pic) }}" class="img-responsive" class="fancybox" rel="group" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

                <hr>

                <div class="row ad_detail_detail_info">
                    @if(!empty($ad_detail->condition_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Condition') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->ad_condition_name}}</strong></span></div>
                    @endif

                    <div class="col-md-6"><span class="text-muted">{{ trans('detail.Ad Type') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->ad_type_name}}</strong></span></div>

                    <!-- estate info -->
                    @if(!empty($ad_detail->estate_type_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Estate Type') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_type_name}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->estate_sq_m))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Estate sq. m.') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_sq_m}}{{ config('dc.site_metric_system') }}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->estate_year))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Estate year of construction') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_year}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->estate_construction_type_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Estate Construction Type') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_construction_type_name}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->estate_floor))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Estate floor') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_floor}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->estate_num_floors_in_building))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Num Floors in Building') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_num_floors_in_building}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->estate_heating_type_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Estate Heating') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_heating_type_name}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->estate_furnishing_type_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Estate Furnishing') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->estate_furnishing_type_name}}</strong></span></div>
                    @endif

                    <!-- cars info -->
                    @if(!empty($ad_detail->car_brand_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Car Brand') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->car_brand_name}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->car_model_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Car Model') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->car_model_name}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->car_modification_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Modification') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->car_modification_name}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->car_engine_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Car Engine') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->car_engine_name}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->car_transmission_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Car Transmission') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->car_transmission_name}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->car_year))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Car Year') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->car_year}}</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->car_kilometeres))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Car Kilometers') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->car_kilometeres}}km.</strong></span></div>
                    @endif

                    @if(!empty($ad_detail->car_condition_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Car Condition') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->car_condition_name}}</strong></span></div>
                    @endif

                    <!-- clothes info -->
                    @if(!empty($ad_detail->clothes_size_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Clothes Size') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->clothes_size_name}}</strong></span></div>
                    @endif

                    <!-- shoes info -->
                    @if(!empty($ad_detail->shoes_size_id))
                        <div class="col-md-6"><span class="text-muted">{{ trans('detail.Shoes Size') }}:</span> <span class="text-primary"><strong>{{ $ad_detail->shoes_size_name}}</strong></span></div>
                    @endif

                    <!-- ad link -->
                    @if(config('dc.enable_link_in_ad'))
                        @if(!empty($ad_detail->ad_link))
                            @if(config('dc.enable_dofollow_link') || (config('dc.enable_dofollow_link_promo') && $ad_detail->ad_promo == 1))
                                <div class="col-md-6"><span class="text-muted">{{ trans('detail.Site') }}:</span> <a href="{{ $ad_detail->ad_link }}" target="_blank">{{ $ad_detail->ad_link }}</a></div>
                            @else
                                <div class="col-md-6"><span class="text-muted">{{ trans('detail.Site') }}:</span> <a href="{{ $ad_detail->ad_link }}" rel="nofollow" target="_blank">{{ $ad_detail->ad_link }}</a></div>
                            @endif
                        @endif
                    @endif
                </div>

                <hr>

                <div class="row ad_detail_ad_text">
                    <div class="col-md-12 wrap" itemprop="description">
                        {!! $ad_detail->ad_description !!}
                    </div>
                </div>

                <hr>

                @if(!empty($ad_detail->ad_video))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="embed-responsive embed-responsive-16by9">
                                {!! $ad_detail->ad_video_fixed !!}
                            </div>
                        </div>
                    </div>
                    <hr>
                @endif
            </div>
            <div class="col-md-4">
                <div class="ad_detail_price text-center" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                    <h2>
                        @if($ad_detail->ad_free)
                            <span itemprop="price">{{ trans('detail.free') }}</span>
                        @else
                            @if(config('dc.show_price_sign_before_price'))
                                {{ config('dc.site_price_sign') }}<span itemprop="price">{{ Util::formatPrice($ad_detail->ad_price) }}</span>
                            @else
                                <span itemprop="price">{{ Util::formatPrice($ad_detail->ad_price) }}</span>{{ config('dc.site_price_sign') }}
                            @endif
                        @endif
                        <meta itemprop="priceCurrency" content="{{ config('dc.site_currency_code') }}">
                    </h2>
                </div>

                <hr>

                <div class="ad_detail_panel">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ url('ad/user/' . $ad_detail->user_id) }}" class="thumbnail">
                                @if(empty($ad_detail->avatar))
                                    <img src="{{ 'https://www.gravatar.com/avatar/' . md5(trim($ad_detail->email)) . '?s=100&d=identicon' }}" alt="{{ $ad_detail->name }}">
                                @else
                                    <img src="{{ asset('uf/udata/100_' . $ad_detail->avatar) }}" alt="{{ $ad_detail->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="col-md-8">
                            <h4>{{ trans('detail.Ad from') }} <a href="{{ url('ad/user/' . $ad_detail->user_id) }}">{{ $ad_detail->name }}</a></h4>
                            <small><span class="text-muted">({{ trans('detail.Registered') }}: {{ $ad_detail->user_register_date }})</span></small>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="ad_detail_panel">
                    @if(Auth::check() && Auth::user()->user_id == $ad_detail->user_id)
                        @if(config('dc.enable_promo_ads'))
                            <a href="{{ route('makepromo', ['ad_id' => $ad_detail->ad_id]) }}" class="btn btn-warning btn-block btn-lg">{{ trans('detail.Make Promo') }}</a>
                        @endif
                    @else
                        <a href="{{ route('ad_contact', ['ad_id' => $ad_detail->ad_id]) }}" class="btn btn-primary btn-block btn-lg"><span class="fa fa-envelope-o" aria-hidden="true"></span> {{ trans('detail.Send Message') }}</a>
                    @endif

                    @if(!empty($ad_detail->ad_phone))
                        <a href="callto:{{ $ad_detail->ad_phone }}" class="btn btn-primary btn-block btn-lg"><span class="fa fa-phone" aria-hidden="true"></span> {{ $ad_detail->ad_phone }}</a>
                    @endif

                    @if(!empty($ad_detail->ad_skype))
                        <a href="callto:{{ $ad_detail->ad_skype }}" class="btn btn-primary btn-block btn-lg"><span class="fa fa-skype"></span> {{ $ad_detail->ad_skype }}</a>
                    @endif
                </div>

                <hr>

                <div class="ad_detail_panel">
                    @if($ad_fav)
                        <a href="#" id="add_to_fav" class="btn btn-default btn-block btn-sm" data-loading-text="{{ trans('detail.Saving...') }}" data-addfav-text='<span class="fa fa-star"></span> {{ trans('detail.Add to favorites') }}' data-removefav-text='<span class="fa fa-star"></span> {{ trans('detail.Remove from favorites') }}'>
                            <span class="fa fa-star"></span> {{ trans('detail.Remove from favorites') }}
                        </a>
                    @else
                        <a href="#" id="add_to_fav" class="btn btn-default btn-block btn-sm" data-loading-text="{{ trans('detail.Saving...') }}" data-addfav-text='<span class="fa fa-star"></span> {{ trans('detail.Add to favorites') }}' data-removefav-text='<span class="fa fa-star"></span> {{ trans('detail.Remove from favorites') }}'>
                            <span class="fa fa-star"></span> {{ trans('detail.Add to favorites') }}
                        </a>
                    @endif

                    <a href="#" onclick="window.print(); return false;" class="btn btn-default btn-block btn-sm"><span class="fa fa-print"></span> {{ trans('detail.Print this ad') }}</a>
                    @if(Auth::check() && Auth::user()->user_id == $ad_detail->user_id)
                        <a href="{{ url('ad/edit/' . $ad_detail->ad_id) }}" class="btn btn-default btn-block btn-sm"><span class="fa fa-pencil-square-o"></span> {{ trans('detail.Edit this ad') }}</a>
                    @endif
                    <button class="btn btn-danger btn-block btn-sm" data-toggle="modal" data-target="#report_modal"><span class="fa fa-exclamation-triangle"></span> {{ trans('detail.Report this ad') }}</button>

                </div>
                <hr>

                @if(!empty($ad_detail->ad_lat_lng))
                <div class="row">
                    <div class="col-md-12">
                        <div id="gmap_detail" style="width: 100%; height:300px;"></div>
                    </div>
                </div>

                <hr>
                @endif

                @include('common.ad_detail_banner')

            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                @if(!$other_ads->isEmpty())
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{ trans('detail.Other Classifieds from this user') }}</h4>
                        </div>
                    </div>

                    <div class="row margin_bottom_15">
                        @foreach ($other_ads as $k => $v)
                            @include('common.ad_list')
                        @endforeach
                    </div>
                @endif

                @if(session()->has('last_view') && !empty(session('last_view')))
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{ trans('detail.Last Viewed') }}</h4>
                        </div>
                    </div>

                    <div class="row">
                        <?$last_view_array = array_reverse(session('last_view'));?>
                        @foreach($last_view_array as $k => $v)
                            <?$link = url(str_slug($v['ad_title']) . '-' . 'ad' . $v['ad_id'] . '.html');?>
                            <!-- ad -->
                            <div class="col-md-3 ad-list-item-container">
                                <div class="ad-list-item">

                                    <div class="ad-list-item-image">
                                        <a href="{{ $link }}"><img src="{{ asset('uf/adata/' . '740_' . $v['ad_pic']) }}" class="img-responsive"></a>
                                    </div>
                                    <div class="ad-list-item-content">
                                        <h5 class="ad_list_title"><a href="{{ $link }}">{{ str_limit($v['ad_title'], 60) }}</a></h5>
                                        <p class="ad-list-item-location"><i class="fa fa-map-marker"></i> {{ $v['location_name'] }}</p>
                                        <h4>{{ $v['ad_price'] ? Util::formatPrice($v['ad_price'], config('dc.site_price_sign')) : trans('publish_edit.Free') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end of ad-->
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div class="modal fade" id="report_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('detail.Report this ad') }}</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" id="report_form" name="report_form">
                        {!! csrf_field() !!}
                        <input type="hidden" name="report_ad_id" id="report_ad_id" value="{{ $ad_detail->ad_id }}">
                        <div class="radio">
                            <label>
                                <input type="radio" name="report_radio" id="report_radio_1" value="1">
                                {{ trans('detail.Spam') }}
                            </label>
                        </div>

                        <div class="radio">
                            <label>
                                <input type="radio" name="report_radio" id="report_radio_2" value="2">
                                {{ trans('detail.Scam') }}
                            </label>
                        </div>

                        <div class="radio">
                            <label>
                                <input type="radio" name="report_radio" id="report_radio_3" value="3">
                                {{ trans('detail.Wrong category') }}
                            </label>
                        </div>

                        <div class="radio">
                            <label>
                                <input type="radio" name="report_radio" id="report_radio_4" value="4">
                                {{ trans('detail.Prohibited goods or services') }}
                            </label>
                        </div>

                        <div class="radio">
                            <label>
                                <input type="radio" name="report_radio" id="report_radio_5" value="5">
                                {{ trans('detail.Ad outdated') }}
                            </label>
                        </div>

                        <div class="radio">
                            <label>
                                <input type="radio" name="report_radio" id="report_radio_6" value="6">
                                {{ trans('detail.Other') }}
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">{{ trans('detail.More information') }}</label>
                            <textarea name="report_more_info" id="report_more_info" class="form-control" rows="3"></textarea>
                        </div>
                    </form>

                    <div class="alert alert-info" role="alert" id="report_result_info" style="display:none;"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('detail.Close') }}</button>
                    <button type="button" class="btn btn-primary" id="btn_send_report" data-loading-text="{{ trans('detail.Sending Report...') }}">{{ trans('detail.Send Report') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('js/fancybox/jquery.fancybox.css')}}" />
@endsection

@section('js')
    <script src="{{asset('js/fancybox/jquery.fancybox.pack.js')}}"></script>
    <script src="http://maps.googleapis.com/maps/api/js?sensor=true&language=en"></script>
    <script type="text/javascript">
        var latlng = new google.maps.LatLng({{ trim($ad_detail->ad_lat_lng, '()') }});
        var myOptions = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("gmap_detail"), myOptions);
        marker = new google.maps.Marker({
            map: map,
            draggable:true,
            position: latlng
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox();

            $('#btn_send_report').click(function(){
                var token = $('input[name=_token]').val();
                var btn = $(this).button('loading');
                var checked = $("input[name='report_radio']:checked").val();
                $('#report_result_info').hide();
                if(checked){
                    $.ajax({
                        url: '{{ url('axreportad') }}',
                        headers: {'X-CSRF-TOKEN': token},
                        type: 'POST',
                        data: {'form_data': $('#report_form').serialize()},
                        dataType: "json",
                        success: function( data ) {
                            $("input[name='report_radio']:checked").prop('checked',false);
                            $('#report_more_info').val('');
                            btn.button('reset');
                            $('#report_result_info').html(data.message);
                            $('#report_result_info').show();
                        }
                    });
                } else {
                    btn.button('reset');
                    $('#report_result_info').html('{{ trans('detail.Please select reason for your report.') }}');
                    $('#report_result_info').show();
                }
                return false;
            });

            $('#add_to_fav').click(function(){
                var token = $('input[name=_token]').val();
                var btn = $(this).button('loading');
                $.ajax({
                    url: '{{ url('axsavetofav') }}',
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    data: {'ad_id': $('#report_ad_id').val()},
                    dataType: "json",
                    success: function( data ) {
                        if(data.code == 200){
                            btn.button('removefav');
                        }
                        if(data.code == 201){
                            btn.button('addfav');
                        }
                    }
                });
                return false;
            });
        });
    </script>
    <script type="text/javascript">
        (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();
    </script>
@endsection
