<?php
/**
 * Thanks to Damir Miladinov
 *
 * https://blog.damirmiladinov.com/laravel/laravel-5.2-socialite-facebook-login.html#.WBn2o8mYI88
 * https://blog.damirmiladinov.com/laravel/laravel-5.2-socialite-twitter-login.html#.WB20WcmYI88
 * https://blog.damirmiladinov.com/laravel/laravel-5.2-socialite-google-login.html#.WB3EdcmYI88
 */
namespace App;

//use Laravel\Socialite\Contracts\User as ProviderUser;
use Laravel\Socialite\Contracts\Provider;

class SocialAccountService
{
    public function createOrGetUser(Provider $provider)
    {
        $providerUser = $provider->user();
        $providerName = class_basename($provider);

        $account = UserSocialAccount::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new UserSocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'user_activated' => 1
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}