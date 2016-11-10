@extends('layout.index_layout')

@section('title', join(' / ', $title))

@section('header_tags')
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
@endsection

@section('search_filter')
    <div style="margin-bottom: 20px;"></div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> {{ trans('contact.home') }}</a></li>
                    <li><a href="{{ url('l-' . $ad_detail->location_slug)}}">{{ $ad_detail->location_name }}</a></li>
                    @if(isset($breadcrump['c']) && !empty($breadcrump['c']))
                        @foreach ($breadcrump['c'] as $k => $v)
                            <li><a href="{{ $v['category_url'] }}">{{ $v['category_title'] }}</a></li>
                        @endforeach
                    @endif
                    <li><a href="{{ url(str_slug($ad_detail->ad_title) . '-' . 'ad' . $ad_detail->ad_id . '.html') }}">{{ $ad_detail->ad_title }}</a></li>
                    <li class="active">{{ trans('contact.Send Message') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container ad_detail_container">
        <div class="row">
            <div class="col-md-12"><h1>{{ $ad_detail->ad_title }} - {{ trans('contact.Send Message') }}</h1></div>
        </div>
        <div class="row ad_detail_publish_info">
            <div class="col-md-12"><a href="{{ url('l-' . $ad_detail->location_slug)}}">{{ $ad_detail->location_name }}</a> | <span class="text-muted">{{ trans('contact.Added_on') }} {{ $ad_detail->ad_publish_date }}.</span></div>
        </div>
        <div class="row ad_detail_ad_info">
            <div class="col-md-12"><span class="text-muted">{{ trans('contact.Ad_Id') }}: {{ $ad_detail->ad_id }} | {{ trans('contact.Views') }}: {{ $ad_detail->ad_view }}</span></div>
        </div>

        <div class="row">
            <div class="col-md-8">

                <div style="display:none;" id="ad_info">
                    <div class="row">
                        <div class="ad_detail_main_image_container">
                            @if($ad_detail->ad_promo)
                                <div class="ribbon"><span>PROMO</span></div>
                            @endif
                            @if(!empty($ad_detail->ad_pic))
                                <a href="{{ asset('uf/adata/1000_' . $ad_detail->ad_pic) }}" class="fancybox" rel="group"><img src="{{ asset('uf/adata/740_' . $ad_detail->ad_pic) }}" class="img-responsive"  itemprop="image" /></a>
                            @else
                                <img src="" class="img-responsive">
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row ad_detail_ad_text">
                        <div class="col-md-12">
                            {{ $ad_detail->ad_description }}
                        </div>
                    </div>
                    <hr>
                </div>

                <div><a href="" id="show_hide_ad">{{ trans('contact.show ad') }}</a> | <a href="{{ url(str_slug($ad_detail->ad_title) . '-' . 'ad' . $ad_detail->ad_id . '.html') }}">{{ trans('contact.return to ad') }}</a></div>

                @if (session()->has('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ trans('contact.Send Message') }}</h4>
                    </div>
                </div>

                <div class="row margin_bottom_15">
                    <div class="col-md-12">
                        <form method="POST">
                            {!! csrf_field() !!}

                            @if(!Auth::check())
                                <div class="form-group required {{ $errors->has('contact_name') ? ' has-error' : '' }}">
                                    <label for="contact_name" class="control-label">{{ trans('contact.Your name') }}</label>
                                    <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="{{ trans('contact.Your name') }}" value="{{ old('contact_name') }}" maxlength="255"/>
                                    @if ($errors->has('contact_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('contact_name') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="form-group required {{ $errors->has('contact_mail') ? ' has-error' : '' }}">
                                    <label for="contact_mail" class="control-label">{{ trans('contact.Your E-Mail') }}</label>
                                    <input type="text" class="form-control" id="contact_mail" name="contact_mail" placeholder="{{ trans('contact.Your E-Mail') }}" value="{{ old('contact_mail') }}" maxlength="255"/>
                                    @if ($errors->has('contact_mail'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('contact_mail') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="form-group required {{ $errors->has('contact_message') ? ' has-error' : '' }}">
                                <label for="contact_message" class="control-label">{{ trans('contact.Message') }}</label>
                                <textarea class="form-control" rows="7" name="contact_message" id="contact_message">{{ old('contact_message') }}</textarea>
                                @if ($errors->has('contact_message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_message') }}</strong>
                                    </span>
                                @endif
                            </div>

                            @if(config('dc.enable_recaptcha_ad_contact'))
                            <div class="form-group required {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                <label for="g-recaptcha-response" class="control-label">{{ trans('publish_edit.Captcha') }}</label>
                                {!! Recaptcha::render(['lang' => config('dc.recaptcha_lang')]) !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endif

                            <button type="submit" class="btn btn-primary">{{ trans('contact.Send') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ad_detail_price text-center">
                    <h2>
                        @if($ad_detail->ad_free)
                            {{ trans('contact.free') }}
                        @else
                            {{ number_format($ad_detail->ad_price, 2, '.', '') . config('dc.site_price_sign') }}
                        @endif
                    </h2>
                </div>

                <hr>

                @include('common.ad_detail_banner')

            </div>
        </div>
    </div>

    <div class="container home_info_link_panel">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                      <li class="active">Main Cateegories</li>
                      <li><a href="#">Real Eastates</a></li>
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
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#show_hide_ad').click(function(){
                if($('#ad_info').is(':visible')){
                    $('#ad_info').hide();
                    $(this).html('show ad');
                } else {
                    $('#ad_info').show();
                    $(this).html('hide ad');
                }
                return false;
            });
        });
    </script>
@endsection