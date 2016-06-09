<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cache;

class Ad extends Model
{
    protected $table = 'ad';
    protected $primaryKey = 'ad_id';
    
    protected $fillable = ['ad_id', 'user_id', 'category_id', 'location_id', 'type_id', 'condition_id', 'ad_email', 
    'ad_publish_date', 'ad_valid_until', 'ad_active', 'ad_ip', 'ad_price', 'ad_free', 'ad_phone', 'ad_title', 'ad_description', 
    'ad_description_hash', 'ad_puslisher_name', 'code', 'ad_promo', 'ad_promo_until', 'ad_link', 'ad_video', 'ad_lat_lng', 
    'ad_skype', 'ad_address', 'ad_pic', 'ad_view', 'estate_type_id', 'estate_sq_m', 'estate_year', 'estate_construction_type_id', 
    'estate_floor', 'estate_num_floors_in_building', 'estate_heating_type_id', 'estate_furnishing_type_id', 'car_brand_id', 
    'car_model_id', 'car_engine_id', 'car_transmission_id', 'car_modification_id', 'car_condition_id', 'car_year', 'car_kilometeres', 'created_at', 'updated_at'];
    
    //used for $fillable generation
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /*
     * get the user for this ad
     */
    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
    
    public function pics()
    {
        return $this->hasMany('App\AdPic', 'ad_id', 'ad_id');
    }
    
    public function getAdList($_where = [], $_order = [], $_limit = 0, $_orderRaw = '', $_whereIn = [], $_whereRaw = [], $_paginate = 0, $_page = 1)
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_name') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, new Collection());
        if($ret->isEmpty()){
            $q = $this->newQuery();
            
            $q->select('ad.ad_id', 'ad.ad_title', 'ad.ad_pic', 'ad.ad_price', 'ad.ad_free', 'ad.ad_promo', 
                    'ad.ad_publish_date', 'ad.ad_valid_until', 'ad.ad_active', 'ad.code', 'L.location_name');
            
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
            
            
            
            $q->leftJoin('location AS L', 'L.location_id' , '=', 'ad.location_id');
            
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
    
    public function getAdDetail($_ad_id)
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_name') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, '');
        if(empty($ret)){
            $ret = Ad::select('ad.*', 'U.*', 'C.category_title', 'C.category_type', 'L.location_name', 'L.location_slug', 'AC.ad_condition_name', 'AT.ad_type_name',
                    'ET.estate_type_name', 'ECT.estate_construction_type_name', 'EHT.estate_heating_type_name', 'EFT.estate_furnishing_type_name',
                    'CB.car_brand_name', 'CM.car_model_name', 'CE.car_engine_name', 'CT.car_transmission_name', 'CC.car_condition_name', 'CMM.car_modification_name')
            
                    ->leftJoin('user AS U', 'U.user_id' , '=', 'ad.user_id')
                    ->leftJoin('category AS C', 'C.category_id' , '=', 'ad.category_id')
                    ->leftJoin('location AS L', 'L.location_id' , '=', 'ad.location_id')
                    ->leftJoin('ad_condition AS AC', 'AC.ad_condition_id' , '=', 'ad.condition_id')
                    ->leftJoin('ad_type AS AT', 'AT.ad_type_id' , '=', 'ad.type_id')
            
                    ->leftJoin('estate_type AS ET', 'ET.estate_type_id' , '=', 'ad.estate_type_id')
                    ->leftJoin('estate_construction_type AS ECT', 'ECT.estate_construction_type_id' , '=', 'ad.estate_construction_type_id')
                    ->leftJoin('estate_heating_type AS EHT', 'EHT.estate_heating_type_id' , '=', 'ad.estate_heating_type_id')
                    ->leftJoin('estate_furnishing_type AS EFT', 'EFT.estate_furnishing_type_id' , '=', 'ad.estate_furnishing_type_id')
            
                    ->leftJoin('car_brand AS CB', 'CB.car_brand_id' , '=', 'ad.car_brand_id')
                    ->leftJoin('car_model AS CM', 'CM.car_model_id' , '=', 'ad.car_model_id')
                    ->leftJoin('car_engine AS CE', 'CE.car_engine_id' , '=', 'ad.car_engine_id')
                    ->leftJoin('car_transmission AS CT', 'CT.car_transmission_id' , '=', 'ad.car_transmission_id')
                    ->leftJoin('car_condition AS CC', 'CC.car_condition_id' , '=', 'ad.car_condition_id')
                    ->leftJoin('car_modification AS CMM', 'CMM.car_modification_id' , '=', 'ad.car_modification_id')
            
                    ->where('ad_active', 1)
                    ->findOrFail($_ad_id);
            Cache::put($cache_key, $ret, config('dc.cache_expire'));
        }
        return $ret;
    }
}
