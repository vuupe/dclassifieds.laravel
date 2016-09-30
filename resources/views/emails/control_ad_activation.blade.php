<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('mail_control_ad.[CONTROL] Ad') }} #{{ $ad->ad_id }}</title>
</head>
<body>
    <strong>#{{ $ad->ad_id }}</strong><br />
    <strong>{{ $ad->ad_title }}</strong><br />
    {{ $ad->ad_description }}<br />
    {{ $ad->ad_publish_date }}<br />
    {{ $ad->ad_email }}<br />
    {{ $ad->ad_ip }}<br />
    <a href="{{ url('/viewbyuser/' . $ad->user_id) }}">{{ trans('mail_control_ad.View all ads from') }} {{ $ad->ad_puslisher_name }}</a><br /><br />
    
    <?
    $ad->ad_category_info = array_reverse($ad->ad_category_info);
    $category_array = array();
    $slug = '';
    foreach ($ad->ad_category_info as $k => $v){
        $slug .= $v['category_slug'] . '/';
        $link_tpl = '<a href="%s">%s</a>';
        $category_array[] = sprintf($link_tpl, url($slug), $v['category_title']);
    }//end of foreach
    echo join(' / ', $category_array);
    ?>
    <br />
    <?
    $ad->ad_location_info = array_reverse($ad->ad_location_info);
    $location_array = array();
    $slug = '';
    foreach ($ad->ad_location_info as $k => $v){
        $slug = 'l-' . $v['location_slug'];
        $link_tpl = '<a href="%s">%s</a>';
        $location_array[] = sprintf($link_tpl, url($slug), $v['location_name']);
    }//end of foreach
    echo join(' / ', $location_array);
    ?>
    
    
    <br /><br />
    
    @if(isset($ad->ad_pic) && !empty($ad->ad_pic)){?>
        <a href="{{ asset('uf/adata/1000_' . $ad->ad_pic) }}" target="_blank"><img src="{{ asset('uf/adata/740_' . $ad->ad_pic) }}" width="400"/></a><br />
    @endif
    
    @if(isset($ad->pics) && !$ad->pics->isEmpty())
        @foreach($ad->pics as $k => $v)
            <a href="{{ asset('uf/adata/1000_' . $v->ad_pic) }}" target="_blank"><img src="{{ asset('uf/adata/1000_' . $v->ad_pic) }}" width="400"/></a><br />
        @endforeach
    @endif
    
    
    <br /><br />
    <a href="{{ url('/delete/' . $ad->code) }}">{{ trans('mail_control_ad.Delete this ad') }}</a>
    <br /><br />
    
    @if(!$ad->same_ads->isEmpty())
        {{ trans('mail_control_ad.Same Ads') }}:<br/>
        @foreach($ad->same_ads as $k => $v)
            <a href="{{ url(str_slug($v->ad_title) . '-' . 'ad' . $v->ad_id . '.html') }}">{{ $v->ad_title }}</a> | <a href="{{ url('/delete/' . $v->code) }}">{{ trans('mail_control_ad.Delete this ad') }} #{{ $v->ad_id }}</a><br />
        @endforeach
    @endif
    <br /><br />
</body>
</html>

