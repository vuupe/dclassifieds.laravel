<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Auth;
use Cache;

use App\AdBanEmail;
use App\AdBanIp;

class BanController extends Controller
{
    public function index(Request $request)
    {
        //message to show the user
        $message = trans('ban.You are banned.');

        /**
         * check for ban by ip
         */
        $remote_ip  = $request->ip();
        $cache_key  = '_ban_ip_' . $remote_ip;
        $ban_info   = Cache::rememberForever($cache_key, function() use ($remote_ip) {
            return AdBanIp::where('ban_ip', $remote_ip)->first();
        });

        /**
         * check if user is banned my email
         */
        if (Auth()->check()) {
            $user_mail  = Auth()->user()->email;
            $cache_key  = '_ban_email_' . $user_mail;
            $ban_info   = Cache::rememberForever($cache_key, function() use($user_mail) {
                return AdBanEmail::where('ban_email', $user_mail)->first();
            });
        }

        //show ban reason
        if(!empty($ban_info)){
            $message = $ban_info->ban_reason;
        }

        return view('errors.ban', ['message' => $message]);
    }
}
