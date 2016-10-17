<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cache;
use DB;

class CarModel extends Model
{
    protected $table        = 'car_model';
    protected $primaryKey   = 'car_model_id';
    protected $fillable     = ['car_brand_id', 'car_model_name', 'car_model_active'];
    public $timestamps      = false;

    public function brand()
    {
        return $this->belongsTo('App\CarBrand', 'car_brand_id', 'car_brand_id');
    }

    public function getList($_where = [], $_order = [], $_limit = 0, $_orderRaw = '', $_whereIn = [], $_whereRaw = [], $_paginate = 0, $_page = 1)
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, new Collection());
        if($ret->isEmpty()){
            $q = $this->newQuery();

            $q->select('car_model.*', 'CB.car_brand_name');

            if(!empty($_where)){
                foreach ($_where as $k => $v){
                    if(is_array($v)){
                        $q->where($k, $v[0], $v[1]);
                    } else {
                        $q->where($k, $v);
                    }
                }
            }

            if(!empty($_whereIn)){
                foreach ($_whereIn as $k => $v){
                    if(is_array($v)){
                        $q->whereIn($k, $v);
                    }
                }
            }

            if(!empty($_whereRaw)){
                foreach ($_whereRaw as $k => $v){
                    if(is_array($v)){
                        $q->whereRaw($k, $v);
                    }
                }
            }

            if(!empty($_order)){
                foreach($_order as $k => $v){
                    $q->orderBy($k, $v);
                }
            }

            if(!empty($_orderRaw)){
                $q->orderByRaw($_orderRaw);
            }

            if($_limit > 0){
                $q->take($_limit);
            }

            $q->leftJoin('car_brand AS CB', 'CB.car_brand_id' , '=', 'car_model.car_brand_id');

            if($_paginate > 0){
                $res = $q->paginate($_paginate);
            } else {
                $res = $q->get();
            }
            if(!$res->isEmpty()){
                $ret = $res;
                Cache::put($cache_key, $ret, config('dc.cache_expire'));
            }
        }
        return $ret;
    }

    public function getListSimple($_select, $_where = [], $_order = [])
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        $res = Cache::rememberForever($cache_key, function() use ($_select, $_where, $_order) {
            $q = $this->select($_select);
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
            return $q->get();
        });
        return $res;
    }
}
