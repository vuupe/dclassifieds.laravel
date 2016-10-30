<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Pay;
use App\User;
use App\Ad;
use App\Wallet;

use Cache;


class MobioPayController extends Controller
{
    public function index(Request $request)
    {
        //get info for this payment
        $payTypeInfo = Pay::find(Pay::PAY_TYPE_MOBIO);

        //calc promo period
        $promoUntilDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+$payTypeInfo->pay_promo_period, date('Y')));

        //get incoming params
        $message    = isset($request->message) ? $request->message : null;
        $item       = isset($request->item) ?  $request->item : null;
        $fromnum    = isset($request->fromnum) ?  $request->fromnum : null;
        $extid      = isset($request->extid) ? $request->extid : null;
        $servID     = isset($request->servID) ? $request->servID : null;

        //check if ping is comming from allowed ips
        $mobio_remote_address = explode(',', $payTypeInfo->pay_allowed_ip);

        if(in_array($request->ip(), $mobio_remote_address)) {
            $sms_reply = trans('payment_mobio.There is error, please contact us.');
            $item = trim($item);

            if(!empty($item)){
                try {
                    $pay_type = mb_strtolower(mb_substr($item, 0, 1));

                    //make ad vip
                    if ($pay_type == 'a') {
                        $ad_id = mb_substr($item, 1);
                        $adInfo = Ad::find($ad_id);
                        if (!empty($adInfo)) {
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
                                'wallet_description' => trans('payment_mobio.Payment via Mobio SMS')
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

                            $sms_reply = trans('payment_mobio.Your ad #:ad_id is Promo Until :date.', ['ad_id' => $ad_id, 'date' => $promoUntilDate]);
                            Cache::flush();
                        }
                    }

                    //add money to wallet
                    if ($pay_type == 'w') {
                        $user_id = mb_substr($item, 1);
                        $userInfo = User::find($user_id);
                        if (!empty($userInfo)) {
                            //save money to wallet
                            $wallet_data = ['user_id' => $userInfo->user_id,
                                'sum' => $payTypeInfo->pay_sum,
                                'wallet_date' => date('Y-m-d H:i:s'),
                                'wallet_description' => trans('payment_mobio.Add Money to Wallet via Mobio SMS')
                            ];
                            Wallet::create($wallet_data);
                            $sms_reply = trans('payment_mobio.You have added :money to your wallet.', ['money' => number_format($payTypeInfo->pay_sum, 2) . config('dc.site_price_sign')]);
                            Cache::flush();
                        }
                    }
                } catch (\Exception $e){}
            }

            file_get_contents("http://mobio.bg/paynotify/pnsendsms.php?servID=$servID&tonum=$fromnum&extid=$extid&message=" . urlencode($sms_reply));
        }
    }
}
