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
                    <li class="active">{{ trans('myfav.My Favorite Classifieds') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container margin_bottom_15">
        <div class="row">
            <div class="col-md-12">
                {!! csrf_field() !!}
                @if(!$my_ad_list->isEmpty())
                    <div class="row">
                        @foreach ($my_ad_list as $k => $v)
                            <!-- ad -->
                            <?$link = url(str_slug($v->ad_title) . '-' . 'ad' . $v->ad_id . '.html');?>
                            <div class="col-md-3 ad-list-item-container" id="ad_{{ $v->ad_id }}">
                                <div class="ad-list-item">
                                    @if($v->ad_promo)
                                        <div class="ribbon"><span>{{ trans('search.PROMO') }}</span></div>
                                    @endif
                                    <div class="ad-list-item-image">
                                        @if(!empty($v->ad_pic))
                                            <a href="{{ $link }}"><img src="{{ asset('uf/adata/' . '740_' . $v->ad_pic) }}" class="img-responsive"></a>
                                        @else
                                            <a href="{{ $link }}"><img src="{{ 'https://www.gravatar.com/avatar/' . md5(trim($v->email)) . '?s=740&d=identicon' }}" class="img-responsive"></a>
                                        @endif
                                    </div>
                                    <div class="ad-list-item-content">
                                        <h5 class="ad_list_title"><a href="{{ $link }}">{{ str_limit($v->ad_title, 60) }}</a></h5>
                                        <p class="ad-list-item-location"><i class="fa fa-map-marker"></i> {{ $v->location_name }}</p>
                                        <h4>{{ $v->ad_price ? Util::formatPrice($v->ad_price) . config('dc.site_price_sign') : trans('publish_edit.Free') }}</h4>
                                    </div>

                                    <div style="margin-bottom: 10px;">
                                        <a href="#" class="btn btn-default btn-block btn-sm remove_from_fav" data-id="{{ $v->ad_id }}" data-loading-text="{{ trans('detail.Saving...') }}" data-addfav-text='<span class="fa fa-star"></span> {{ trans('detail.Add to favorites') }}' data-removefav-text='<span class="fa fa-star"></span> {{ trans('detail.Remove from favorites') }}'>
                                            <span class="fa fa-star"></span> {{ trans('detail.Remove from favorites') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- end of ad-->
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <nav>{{  $my_ad_list->appends($params)->links() }}</nav>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">{{ trans('myfav.You dont have favorite classifieds.') }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.remove_from_fav').click(function(){
                var token = $('input[name=_token]').val();
                var btn = $(this).button('loading');
                var ad_id = $(this).data('id');
                $.ajax({
                    url: '{{ url('axsavetofav') }}',
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    data: {'ad_id': ad_id},
                    dataType: "json",
                    success: function( data ) {
                        if(data.code == 201){
                            $('#ad_' + ad_id).hide();
                        }
                    }
                });
                return false;
            });
        });
    </script>
@endsection
