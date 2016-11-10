<!DOCTYPE HTML>
<html lang="en">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>{{ trans('mail_password.Password Reset') }}</title>
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
                                        <p>{{ trans('mail_password.Click here to reset your password') }}: {{ url('reset/'. $token) }}</p>
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
