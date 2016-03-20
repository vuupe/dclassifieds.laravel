<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ad';
    protected $primaryKey = 'ad_id';
    
    protected $fillable = ['ad_id', 'user_id', 'category_id', 'location_id', 'type_id', 'condition_id', 'ad_email', 
    'ad_publish_date', 'ad_valid_until', 'ad_active', 'ad_ip', 'ad_price', 'ad_free', 'ad_phone', 'ad_title', 
    'ad_description', 'ad_description_hash', 'ad_puslisher_name', 'code', 'ad_promo', 'ad_promo_until', 'ad_link', 
    'ad_video', 'ad_lat_lng', 'ad_skype', 'ad_address', 'ad_pic', 'estate_type_id', 'estate_sq_m', 'estate_year', 
    'estate_construction_type_id', 'estate_floor', 'estate_num_floors_in_building', 'estate_heating_type_id', 
    'estate_furnishing_type_id', 'car_brand_id', 'car_model_id', 'car_engine_id', 'car_year', 'car_kilometeres', 
    'created_at', 'updated_at', 'ad_id', 'user_id', 'category_id', 'location_id', 'type_id', 'condition_id', 'ad_email', 
    'ad_publish_date', 'ad_valid_until', 'ad_active', 'ad_ip', 'ad_price', 'ad_free', 'ad_phone', 'ad_title', 'ad_description', 
    'ad_description_hash', 'ad_puslisher_name', 'code', 'ad_promo', 'ad_promo_until', 'ad_link', 'ad_video', 'ad_lat_lng', 
    'ad_skype', 'ad_address', 'ad_pic', 'estate_type_id', 'estate_sq_m', 'estate_year', 'estate_construction_type_id', 
    'estate_floor', 'estate_num_floors_in_building', 'estate_heating_type_id', 'estate_furnishing_type_id', 'car_brand_id', 
    'car_model_id', 'car_engine_id', 'car_year', 'car_kilometeres', 'created_at', 'updated_at'];
    
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
}
