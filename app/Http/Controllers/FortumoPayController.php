<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Pay;
use App\User;
use App\Ad;
use App\Wallet;

use Cache;

class FortumoPayController extends Controller
{
    public function index(Request $request)
    {
        $sms_reply = trans('payment_fortumo.There is error, please contact us.');
        //get info for this payment
        $payTypeInfo = Pay::find(Pay::PAY_TYPE_FORTUMO);

        //calc promo period
        $promoUntilDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+$payTypeInfo->pay_promo_period, date('Y')));

        //get incoming params
        $message = isset($request->message) ?  $request->message : null;
        $status = isset($request->status) ?  $request->status : null;
        $billing_type = isset($request->billing_type) ?  $request->billing_type : null;

        //check if ping is comming from allowed ips
        $fortumo_remote_address = explode(',', $payTypeInfo->pay_allowed_ip);

        if(in_array($request->ip(), $fortumo_remote_address) && $this->check_signature($request->all(), $payTypeInfo->pay_secret)) {

            $message = trim($message);

            if(!empty($message) && ( preg_match("/OK/i", $status) || (preg_match("/MO/i", $billing_type) && preg_match("/pending/i", $status)) )){
                try {
                    $pay_type = mb_strtolower(mb_substr($message, 0, 1));

                    //make ad promo
                    if ($pay_type == 'a') {
                        $ad_id = mb_substr($message, 1);
                        $adInfo = Ad::find($ad_id);
                        if (!empty($adInfo)) {
                            //update ad
                            $adInfo->ad_promo = 1;
                            $adInfo->ad_promo_until = $promoUntilDate;
                            $adInfo->ad_active = 1;
                            $adInfo->promo_expire_warning_mail_send = 0;
                            $adInfo->save();

                            //add money to wallet
                            $wallet_data = ['user_id' => $adInfo->user_id,
                                'ad_id' => $ad_id,
                                'sum' => $payTypeInfo->pay_sum,
                                'wallet_date' => date('Y-m-d H:i:s'),
                                'wallet_description' => trans('payment_fortumo.Payment via Fortumo SMS')
                            ];
                            Wallet::create($wallet_data);

                            //subtract money from wallet
                            $wallet_data = ['user_id' => $adInfo->user_id,
                                'ad_id' => $ad_id,
                                'sum' => -$payTypeInfo->pay_sum,
                                'wallet_date' => date('Y-m-d H:i:s'),
                                'wallet_description' => trans('payment_fortumo.Your ad #:ad_id is Promo Until :date.', ['ad_id' => $ad_id, 'date' => $promoUntilDate])
                            ];
                            Wallet::create($wallet_data);

                            $sms_reply = trans('payment_fortumo.Your ad #:ad_id is Promo Until :date.', ['ad_id' => $ad_id, 'date' => $promoUntilDate]);
                            Cache::flush();
                        }
                    }

                    //add money to wallet
                    if ($pay_type == 'w') {
                        $user_id = mb_substr($message, 1);
                        $userInfo = User::find($user_id);
                        if (!empty($userInfo)) {
                            //save money to wallet
                            $wallet_data = ['user_id' => $userInfo->user_id,
                                'sum' => $payTypeInfo->pay_sum,
                                'wallet_date' => date('Y-m-d H:i:s'),
                                'wallet_description' => trans('payment_fortumo.Add Money to Wallet via Fortumo SMS')
                            ];
                            Wallet::create($wallet_data);
                            $sms_reply = trans('payment_fortumo.You have added :money to your wallet.', ['money' => number_format($payTypeInfo->pay_sum, 2) . config('dc.site_price_sign')]);
                            Cache::flush();
                        }
                    }
                } catch (\Exception $e){}
            }
        }
        echo $sms_reply;
    }

    public function check_signature($params_array, $secret)
    {
        ksort($params_array);
        $str = '';
        foreach ($params_array as $k=>$v) {
            if($k != 'sig') {
                $str .= "$k=$v";
            }
        }
        $str .= $secret;
        $signature = md5($str);
        return ($params_array['sig'] == $signature);
  }
}
