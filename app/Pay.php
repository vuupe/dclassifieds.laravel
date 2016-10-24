<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cache;
use DB;

class Pay extends Model
{
    const PAY_TYPE_MOBIO    = 1; //Mobio SMS Pay
    const PAY_TYPE_FORTUMO  = 2; //Fortumo SMS Pay
    const PAY_TYPE_PAYPAL   = 3; //Paypal Standard Pay
    const PAY_TYPE_STRIPE   = 4; //Stripe

    protected $table        = 'pay';
    protected $primaryKey   = 'pay_id';
    protected $fillable     = ['pay_name', 'pay_active', 'pay_ord', 'pay_info_url', 'pay_sum', 'pay_promo_period',
        'pay_sms_prefix', 'pay_description', 'pay_allowed_ip', 'pay_number', 'pay_secret', 'pay_testmode',
        'pay_paypal_mail', 'pay_sum_to_charge', 'pay_currency', 'pay_locale', 'pay_log', 'pay_page_name',
        'pay_secret_key', 'pay_publish_key'
    ];
    public $timestamps      = false;

    public function getList($_where = [], $_order = [])
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, new Collection());
        if($ret->isEmpty()) {
            $q = $this->newQuery();

            if(!empty($_where)){
                foreach ($_where as $k => $v){
                    if(is_array($v)){
                        $q->where($k, $v[0], $v[1]);
                    } else {
                        $q->where($k, $v);
                    }
                }
            }

            if(!empty($_order)){
                foreach($_order as $k => $v){
                    $q->orderBy($k, $v);
                }
            }

            $res = $q->get();
            if(!$res->isEmpty()){
                $ret = $res;
                Cache::put($cache_key, $ret, config('dc.cache_expire'));
            }
        }
        return $ret;
    }
}
