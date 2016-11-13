@if(isset($footerBanner) && !empty($footerBanner))
<div class="container centar_banner_728">
    <div class="row">
        <div class="col-md-12">
            @if($footerBanner->banner_type == \App\Banner::BANNER_IMAGE)
                <a href="{{ $footerBanner->banner_link }}"><img src="{{ asset('uf/banner/' . $footerBanner->banner_image) }}" class="center-block img-responsive"></a>
            @endif
            @if($footerBanner->banner_type == \App\Banner::BANNER_CODE)
                <div style="text-align: center;">{!! $footerBanner->banner_code !!}</div>
            @endif
        </div>
    </div>
</div>
@endif