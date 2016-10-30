<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


use App\Pay;
use App\User;
use App\Ad;
use App\Wallet;

use Cache;
use Log;
use Input;
use Stripe\Stripe;

class StripePayController extends Controller
{
    public function index(Request $request)
    {
        //get peytype
        $paytype = $request->paytype;

        //get info for this payment
        $payTypeInfo = Pay::find(Pay::PAY_TYPE_STRIPE);

        $stripeData = ['paytype' => $paytype,
            'sum_to_charge' => $payTypeInfo->pay_sum_to_charge,
            'pay_currency' => $payTypeInfo->pay_currency,
            'publish_key' => $payTypeInfo->pay_publish_key
        ];

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('payment_stripe.Payment via Stripe');

        return view('pay.stripe', ['stripeData' => $stripeData, 'title' => $title]);
    }

    public function stripe(Request $request)
    {
        //get post params
        $params = Input::all();

        //get get params
        $paytype = $request->paytype;
        $paytype = trim($paytype);

        //get info for this payment
        $payTypeInfo = Pay::find(Pay::PAY_TYPE_STRIPE);

        // See your keys here: https://dashboard.stripe.com/account/apikeys
        Stripe::setApiKey($payTypeInfo->pay_secret_key);

        // Get the credit card details submitted by the form
        $token = '';
        if (isset($params['stripeToken']) && !empty($params['stripeToken'])) {
            $token = $params['stripeToken'];
        }

        if (!empty($token) && !empty($paytype)) {
            // Create a charge: this will charge the user's card
            try {
                $charge = \Stripe\Charge::create([
                    'amount' => $payTypeInfo->pay_sum_to_charge * 100,
                    'currency' => $payTypeInfo->pay_currency,
                    'source' => $token,
                    'description' => config('dc.site_domain') . '-' . trans('payment_stripe.Promo Option')
                ]);
            } catch (\Exception $e) {
                // The card has been declined
                Log::info('STRIPE :: ERROR ' . $e->getMessage() . ' Action: ' . $paytype);
                session()->flash('message', trans('payment_stripe.There is error, please contact us.'));
                return view('common.info_page');
            }

            $pay_type = mb_strtolower(mb_substr($paytype, 0, 1));

            //make ad vip
            if ($pay_type == 'a') {
                $ad_id = mb_substr($paytype, 1);
                $adInfo = Ad::find($ad_id);
                if (!empty($adInfo)) {

                    //calc promo period
                    $promoUntilDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+$payTypeInfo->pay_promo_period, date('Y')));

                    //update ad
                    $adInfo->ad_promo = 1;
                    $adInfo->ad_promo_until = $promoUntilDate;
                    $adInfo->ad_active = 1;
                    $adInfo->save();

                    //add money to wallet
                    $wallet_data = ['user_id' => $adInfo->user_id,
                        'ad_id' => $ad_id,
                        'sum' => $payTypeInfo->pay_sum,
                        'wallet_date' => date('Y-m-d H:i:s'),
                        'wallet_description' => trans('payment_stripe.Payment via Stripe')
                    ];
                    Wallet::create($wallet_data);

                    //subtract money from wallet
                    $wallet_data = ['user_id' => $adInfo->user_id,
                        'ad_id' => $ad_id,
                        'sum' => -$payTypeInfo->pay_sum,
                        'wallet_date' => date('Y-m-d H:i:s'),
                        'wallet_description' => trans('payment_stripe.Your ad #:ad_id is Promo Until :date.', ['ad_id' => $ad_id, 'date' => $promoUntilDate])
                    ];
                    Wallet::create($wallet_data);
                }
            }

            //add money to wallet
            if ($pay_type == 'w') {
                $user_id = mb_substr($paytype, 1);
                $userInfo = User::find($user_id);
                if (!empty($userInfo)) {
                    //save money to wallet
                    $wallet_data = ['user_id' => $userInfo->user_id,
                        'sum' => $payTypeInfo->pay_sum,
                        'wallet_date' => date('Y-m-d H:i:s'),
                        'wallet_description' => trans('payment_stripe.Add Money to Wallet via Stripe')
                    ];
                    Wallet::create($wallet_data);
                }
            }

            Cache::flush();
            session()->flash('message', trans('payment_stripe.Thank you for your payment'));
            return view('common.info_page');

        } else {
            Log::info('STRIPE :: ERROR TOKEN MISSING Action: ' . $paytype);
            session()->flash('message', trans('payment_stripe.There is error, please contact us.'));
            return view('common.info_page');
        }
    }
}
