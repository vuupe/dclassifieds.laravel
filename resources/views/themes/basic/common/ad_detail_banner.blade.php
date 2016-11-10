@if(isset($adDetailBanner) && !empty($adDetailBanner))
    <div class="ad_detail_panel">
        @if($adDetailBanner->banner_type == \App\Banner::BANNER_IMAGE)
            <a href="{{ $adDetailBanner->banner_link }}"><img src="{{ asset('uf/banner/' . $adDetailBanner->banner_image) }}" class="center-block img-responsive"></a>
        @endif
        @if($adDetailBanner->banner_type == \App\Banner::BANNER_CODE)
            <div style="text-align: center;">{!! $adDetailBanner->banner_code !!}</div>
        @endif
    </div>
@endif