<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cache;
use DB;

class Pay extends Model
{
    const PAY_TYPE_MOBIO = 1; //Mobio SMS Pay
    const PAY_TYPE_FORTUMO = 1; //Fortumo SMS Pay

    protected $table        = 'pay';
    protected $primaryKey   = 'pay_id';
    protected $fillable     = ['pay_name', 'pay_active', 'pay_ord', 'pay_info_url', 'pay_sum', 'pay_promo_period',
        'pay_sms_prefix', 'pay_description', 'pay_allowed_ip', 'pay_number', 'pay_secret'];
    public $timestamps      = false;
}
