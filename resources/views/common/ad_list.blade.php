<!-- ad -->
<?$link = url(str_slug($v->ad_title) . '-' . 'ad' . $v->ad_id . '.html');?>
<div class="col-md-3">
    <div class="thumbnail">
        <a href="{{ $link }}"><img src="{{ asset('uf/adata/' . '740_' . $v->ad_pic) }}"></a>
        <div class="caption">
            <h4 class="ad_list_title"><a href="{{ $link }}">{{ str_limit($v->ad_title, 20) }}</a></h4>
            <p>{{ $v->location_name }}</p>
            <h3>{{ $v->ad_price ? Util::formatPrice($v->ad_price) . config('dc.site_price_sign') : trans('publish_edit.Free') }}</h3>
        </div>
    </div>
</div>
<!-- end of ad-->
