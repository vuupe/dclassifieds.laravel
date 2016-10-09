<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;

use App\AdBanEmail;
use App\AdBanIp;

class BanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * check for ban by ip
         */
        $remote_ip  = $request->ip();
        $cache_key  = '_ban_ip_' . $remote_ip;
        $ban_info   = Cache::rememberForever($cache_key, function() use($remote_ip) {
            return AdBanIp::where('ban_ip', $remote_ip)->first();
        });
        if(!empty($ban_info) && !$request->is('ban')){
            return redirect('ban');
        }

        /**
         * check if user is banned my email
         */
        if (Auth()->check()) {
            $user_mail  = Auth()->user()->email;
            $cache_key  = '_ban_email_' . $user_mail;
            $ban_info   = Cache::rememberForever($cache_key, function() use($user_mail) {
                return AdBanEmail::where('ban_email', $user_mail)->first();
            });
            if(!empty($ban_info) && !$request->is('ban')){
                return redirect('ban');
            }
        }
        return $next($request);
    }
}
