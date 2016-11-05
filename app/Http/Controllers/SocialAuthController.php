<?php
/**
 * Thanks to Damir Miladinov
 *
 * https://blog.damirmiladinov.com/laravel/laravel-5.2-socialite-facebook-login.html#.WBn2o8mYI88
 * https://blog.damirmiladinov.com/laravel/laravel-5.2-socialite-twitter-login.html#.WB20WcmYI88
 * https://blog.damirmiladinov.com/laravel/laravel-5.2-socialite-google-login.html#.WB3EdcmYI88
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(SocialAccountService $service, $provider)
    {
        try {
            $user = $service->createOrGetUser(Socialite::driver($provider));
        } catch (\Exception $e) {
            Log::info('SOCIAL LOGIN :: PROVIDER : ' . $provider . ' MESSAGE: ' . $e->getMessage());
            return redirect(url('login'));
        }

        auth()->login($user);

        return redirect(url('myprofile'));
    }
}
