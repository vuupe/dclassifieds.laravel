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

class PaypalPayController extends Controller
{
    public function index(Request $request)
    {
        //get peytype
        $paytype = $request->paytype;

        //get info for this payment
        $payTypeInfo = Pay::find(Pay::PAY_TYPE_PAYPAL);

        $paypalData = ['testmode' => $payTypeInfo->pay_testmode,
            'action' => 'https://www.paypal.com/cgi-bin/webscr',
            'business' => $payTypeInfo->pay_paypal_mail,
            'paytype' => $paytype,
            'sum_to_charge' => $payTypeInfo->pay_sum_to_charge,
            'pay_currency' => $payTypeInfo->pay_currency,
            'pay_locale' => $payTypeInfo->pay_locale
        ];

        //if sandbox set sandbox url
        if($paypalData['testmode']){
            $paypalData['action'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('payment_paypal.Payment via Paypal');

        return view('pay.paypal', ['paypalData' => $paypalData, 'title' => $title]);
    }

    public function paypalcallback(Request $request)
    {
        $params = Input::all();

        //get info for this payment
        $payTypeInfo = Pay::find(Pay::PAY_TYPE_PAYPAL);

        if($payTypeInfo->pay_log) {
            Log::info('PP_STANDARD :: INCOMING PARAMS: ' . json_encode($params));
        }

        $order_type_info = '';
        if (isset($params['custom'])) {
            $order_type_info = $params['custom'];
        }

        $order_type_info = trim($order_type_info);
        if(!empty($order_type_info)){

            $request = 'cmd=_notify-validate';

            foreach ($params as $key => $value) {
                $request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
            }

            if ($payTypeInfo->pay_testmode) {
                $curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
            } else {
                $curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
            }

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: dclassifieds'));

            $response = curl_exec($curl);

            if (!$response && $payTypeInfo->pay_log) {
                Log::info('PP_STANDARD :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
            }

            if ($payTypeInfo->pay_log) {
                Log::info('PP_STANDARD :: IPN REQUEST: ' . json_encode($request));
                Log::info('PP_STANDARD :: IPN RESPONSE: ' . json_encode($response));
            }

            if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($params['payment_status'])) {
                switch($params['payment_status']) {
                    case 'Completed':
                        $total_paid_match = ((float)$params['mc_gross'] == number_format($payTypeInfo->pay_sum_to_charge, 2, '.', ''));

                        if ($total_paid_match) {
                            $pay_type = mb_strtolower(mb_substr($order_type_info, 0, 1));

                            //make ad promo
                            if ($pay_type == 'a') {
                                $ad_id = mb_substr($order_type_info, 1);
                                $adInfo = Ad::find($ad_id);
                                if (!empty($adInfo)) {

                                    //calc promo period
                                    $promoUntilDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+$payTypeInfo->pay_promo_period, date('Y')));

                                    //check if ad is promo and extend promo period
                                    if(!empty($adInfo->ad_promo_until) && $adInfo->ad_promo == 1){
                                        $current_promo_period_timestamp = strtotime($adInfo->ad_promo_until);
                                        if($current_promo_period_timestamp) {
                                            $promoUntilDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d', $current_promo_period_timestamp) + $payTypeInfo->pay_promo_period, date('Y')));
                                        }
                                    }

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
                                        'wallet_description' => trans('payment_paypal.Payment via Paypal')
                                    ];
                                    Wallet::create($wallet_data);

                                    //subtract money from wallet
                                    $wallet_data = ['user_id' => $adInfo->user_id,
                                        'ad_id' => $ad_id,
                                        'sum' => -$payTypeInfo->pay_sum,
                                        'wallet_date' => date('Y-m-d H:i:s'),
                                        'wallet_description' => trans('payment_paypal.Your ad #:ad_id is Promo Until :date.', ['ad_id' => $ad_id, 'date' => $promoUntilDate])
                                    ];
                                    Wallet::create($wallet_data);
                                }
                            }

                            //add money to wallet
                            if ($pay_type == 'w') {
                                $user_id = mb_substr($order_type_info, 1);
                                $userInfo = User::find($user_id);
                                if (!empty($userInfo)) {
                                    //save money to wallet
                                    $wallet_data = ['user_id' => $userInfo->user_id,
                                        'sum' => $payTypeInfo->pay_sum,
                                        'wallet_date' => date('Y-m-d H:i:s'),
                                        'wallet_description' => trans('payment_paypal.Add Money to Wallet via Paypal')
                                    ];
                                    Wallet::create($wallet_data);
                                }
                            }
                        }

                        if (!$total_paid_match && $payTypeInfo->pay_log) {
                            Log::info('PP_STANDARD :: TOTAL PAID MISMATCH! ' . $params['mc_gross']);
                        }
                        break;
                    case 'Canceled_Reversal':
                    case 'Denied':
                    case 'Expired':
                    case 'Failed':
                    case 'Pending':
                    case 'Processed':
                    case 'Refunded':
                    case 'Reversed':
                    case 'Voided':
                        Log::info('PP_STANDARD :: Wrong Status ' . $order_type_info);
                        break;
                }
                Cache::flush();
            } else {

            }
        }
    }

    public function paypalsuccess(Request $request)
    {
        $a = $request->a;
        $message = trans('payment_paypal.Thank you for your payment');
        if($a == 0){
            $message = trans('payment_paypal.We a sorry for your cancellation');
        }
        session()->flash('message', $message);
        return view('common.info_page');
    }
}
