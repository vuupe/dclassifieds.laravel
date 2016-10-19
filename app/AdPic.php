<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cache;

class AdPic extends Model
{
    protected $table        = 'ad_pic';
    protected $primaryKey   = 'ad_pic_id';
    public $timestamps      = false;
    
    public function ad()
    {
        return $this->belongsTo('App\Ad', 'ad_id', 'ad_id');
    }

    public function getAdPics($_where = [], $_order = [])
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
