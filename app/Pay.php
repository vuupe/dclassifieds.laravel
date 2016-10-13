<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cache;
use DB;

class Pay extends Model
{
    const PAY_TYPE_MOBIO = 1; //Mobio SMS Pay
    const PAY_TYPE_FORTUMO = 2; //Fortumo SMS Pay
    const PAY_TYPE_PAYPAL = 3; //Paypal Standard Pay
    const PAY_TYPE_STRIPE = 4; //Stripe

    protected $table        = 'pay';
    protected $primaryKey   = 'pay_id';
    protected $fillable     = ['pay_name', 'pay_active', 'pay_ord', 'pay_info_url', 'pay_sum', 'pay_promo_period',
        'pay_sms_prefix', 'pay_description', 'pay_allowed_ip', 'pay_number', 'pay_secret', 'pay_testmode',
        'pay_paypal_mail', 'pay_sum_to_charge', 'pay_currency', 'pay_locale', 'pay_log', 'pay_page_name',
        'pay_secret_key', 'pay_publish_key'
    ];
    public $timestamps      = false;
}
