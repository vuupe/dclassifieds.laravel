<!-- ad -->
<?$link = url(str_slug($v->ad_title) . '-' . 'ad' . $v->ad_id . '.html');?>
<div class="col-md-2 ad-list-item-container">
    <div class="ad-list-item">
        @if($v->ad_promo)
            <div class="ribbon"><span>PROMO</span></div>
        @endif
        <div class="ad-list-item-image">
            <a href="{{ $link }}"><img src="{{ asset('uf/adata/' . '740_' . $v->ad_pic) }}" class="img-responsive"></a>
        </div>
        <div class="ad-list-item-content">
            <h5 class="ad_list_title"><a href="{{ $link }}">{{ str_limit($v->ad_title, 60) }}</a></h5>
            <p class="ad-list-item-location"><i class="fa fa-map-marker"></i> {{ $v->location_name }}</p>
            <h4>{{ $v->ad_price ? Util::formatPrice($v->ad_price) . config('dc.site_price_sign') : trans('publish_edit.Free') }}</h4>
        </div>
    </div>
</div>
<!-- end of ad-->
