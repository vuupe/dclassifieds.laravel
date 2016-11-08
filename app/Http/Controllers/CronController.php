<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ad;

use Cache;
use Mail;


class CronController extends Controller
{
    public function deactivate(Request $request)
    {
        $today = date('Y-m-d');
        Ad::where('ad_valid_until' , '<', $today)->update(['ad_active' => 0]);
    }

    public function sendmaildeactivatesoon(Request $request)
    {
        $expire_date = date('Y-m-d', mktime(null, null, null, date('m'), date('d')+config('dc.send_warning_mail_ad_expire'), date('Y')));
        $expire_soon_ads = Ad::where('ad_valid_until', '=', $expire_date)
            ->where('expire_warning_mail_send', 0)
            ->take(config('dc.num_mails_to_send_ad_once'))
            ->get();
        if(!$expire_soon_ads->isEmpty()){
            foreach($expire_soon_ads as $k => $v){
                $v->expire_warning_mail_send = 1;
                $v->save();

                //send activation mail
                Mail::send('emails.ad_expire_warning', ['ad' => $v], function ($m) use ($v) {
                    $m->from(config('dc.site_contact_mail'), config('dc.site_domain'));
                    $m->to($v->ad_email)->subject(trans('cron.Your Ad Will Expire Soon') . $v->ad_title);
                });
            }
        }
    }
}
