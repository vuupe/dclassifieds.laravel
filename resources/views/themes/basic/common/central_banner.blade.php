<div class="container centar_banner_728">
    <div class="row">
        <div class="col-md-12">
            @if(isset($centralBanner) && !empty($centralBanner))
                @if($centralBanner->banner_type == \App\Banner::BANNER_IMAGE)
                    <a href="{{ $centralBanner->banner_link }}"><img src="{{ asset('uf/banner/' . $centralBanner->banner_image) }}" class="center-block img-responsive"></a>
                @endif
                @if($centralBanner->banner_type == \App\Banner::BANNER_CODE)
                    <div style="text-align: center;">{!! $centralBanner->banner_code !!}</div>
                @endif
            @endif
        </div>
    </div>
</div>