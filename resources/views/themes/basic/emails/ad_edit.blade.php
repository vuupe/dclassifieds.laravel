<!DOCTYPE HTML>
<html lang="en">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>{{ trans('mail_ad_edit.ad_edited', ['ad_id' => $ad->ad_id]) }}</title>
<style type="text/css">
a { border: none; }
img { border: none; }
p { margin: 10px 0px; font-size: 14px; }
</style>
</head>
<body style="margin: 0; padding: 0; background-color: #eeeeee" bgcolor="#eeeeee">
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
        <tr>
            <td align="center" style="padding: 37px 0; background-color: #eeeeee;" bgcolor="#eeeeee">

                <!-- #nl_container -->
                <table cellpadding="0" cellspacing="0" border="0" style="margin: 0; border: 1px solid #dddddd; color: #444444; font-family: arial; font-size: 12px; border-color: #dddddd; background-color: #ffffff; " width="600">
                    <tr>
                        <td>

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="border-bottom: 1px solid #dddddd; text-align: left; padding: 10px;">
                                        <a class="navbar-brand" href="{{ route('home') }}">
                                            @if( !empty( config('dc.site_logo_img') ) )
                                                <img src="{{ asset('uf/settings/' . config('dc.site_logo_img')) }}" style="height: 50px;" alt="{{ config('dc.site_logo_alt') }}">
                                            @else
                                                {{ config('dc.site_logo_name') }}
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            </table>


                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 10px;">
                                        <h1 style="font-size: 22px;">{{ trans('mail_ad_edit.ad_edited_title', ['ad_title' => $ad->ad_title]) }}</h1>
                                        <p><a href="{{ url(str_slug($ad->ad_title) . '-' . 'ad' . $ad->ad_id . '.html') }}">{{ trans('mail_ad_edit.Click here to view your ad.') }}</a></p>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0">
                                @if(config('dc.enable_promo_ads'))
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #dddddd; text-align: center;">{{ trans('cron.Make Your Ad Promo') }}</td>
                                    <td style="padding: 10px; border-bottom: 1px solid #dddddd; text-align: center;">
                                        <a href="{{ route('makepromo', ['ad_id' => $ad->ad_id]) }}" style="display: block; width: 100%; color: #fff; background-color: #f0ad4e; padding: 10px 0px; text-decoration: none;">{{ trans('cron.Make Promo') }}</a>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td width="50%" style="padding: 10px; border-bottom: 1px solid #dddddd; text-align: center;">{{ trans('cron.Republish Your Ad') }}</td>
                                    <td width="50%" style="padding: 10px; border-bottom: 1px solid #dddddd; text-align: center;">
                                        <a href="{{ route('republish', ['token' => $ad->code]) }}" style="display: block; width: 100%; color: #fff; background-color: #5cb85c; padding: 10px 0px; text-decoration: none;">{{ trans('cron.Republish') }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" style="padding: 10px; border-bottom: 1px solid #dddddd; text-align: center;">{{ trans('cron.Edit') }}</td>
                                    <td width="50%" style="padding: 10px; border-bottom: 1px solid #dddddd; text-align: center;">
                                        <a href="{{ route('adedit', array('id' => $ad->ad_id)) }}" style="display: block; width: 100%; color: #fff; background-color: #337ab7; padding: 10px 0px; text-decoration: none;">{{ trans('cron.Edit') }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; text-align: center;">{{ trans('cron.Delete Your Ad') }}</td>
                                    <td style="padding: 10px; text-align: center;">
                                        <a href="{{ route('delete', ['token' => $ad->code]) }}" style="display: block; width: 100%; color: #fff; background-color: #d9534f; padding: 10px 0px; text-decoration: none;">{{ trans('cron.Delete') }}</a>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="border-top: 1px solid #dddddd; text-align: center; padding: 20px;">
                                        <p style="margin: 0px;">{{ trans('index_layout.copyright') }} &copy; {{ date('Y') }} <a href="{{ config('dc.site_url') }}">{{ config('dc.site_copyright_name') }}</a> {{ trans('index_layout.All rights reserved.') }}</p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>

