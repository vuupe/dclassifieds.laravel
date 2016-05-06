<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdFav extends Model
{
    protected $table = 'ad_fav';
    protected $primaryKey = 'ad_fav_id';
    public $timestamps = false;
    
    public function getFavAds($_user_id)
    {
        $ret = array();
        $res = $this->where('user_id', $_user_id)->get();
        if(!$res->isEmpty()){
            foreach($res as $k => $v){
                $ret[$v->ad_id] = $v->ad_id;
            }
        }
        return $ret;
    }
}
