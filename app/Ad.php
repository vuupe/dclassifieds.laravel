<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = 'ad';
    protected $primaryKey = 'ad_id';
    
    protected $fillable = [	'user_id', 'ad_title', 'category_id', 
    						'ad_description', 'location_id', 'ad_puslisher_name', 
    						'ad_email', 'ad_phone', 'ad_skype', 'code', 'ad_publish_date', 'ad_pic',
    						'ad_price', 'ad_free', 'type_id', 'condition_id'];
    
    /*
     * get the user for this ad
     */
    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}
