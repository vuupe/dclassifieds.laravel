<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ad;
use Cache;

class Location extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'location_id';
    public $timestamps = false;
    
    protected $fillable = ['location_parent_id', 'location_active', 'location_name', 'location_slug'];
    
    public function parents()
    {
    	return $this->belongsTo('App\Location', 'location_parent_id');
    }
    
    public function children()
    {
    	return $this->hasMany('App\Location', 'location_parent_id');
    }
    
    public function getAllHierarhy($_parent_id = null, $_level = 0, $_active = 1)
    {
    	$cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
    	$ret = Cache::get($cache_key, []);
    	if(empty($ret)){
	    	$_level++;
	    	
	    	$lquery = $this->where('location_parent_id', $_parent_id)
	    							->with('children')
	    							->orderBy('location_name', 'asc');
	    	
	    	if($_active){
	    		$lquery->where('location_active', '=', 1);	
	    	}
	    	
	    	$locationCollection = $lquery->get();
	    	
	    	if(!empty($locationCollection)){
	    		foreach ($locationCollection as $k => $v){
	    			$ret[$v->location_id] = array('lid' => $v->location_id, 
	    				'title' => $v->location_name,
	    				'slug' => $v->location_slug,
	    				'active' => $v->location_active, 
	    				'level' => $_level,
	    				'ad_count' => Ad::where('location_id', $v->location_id)->count()
	    			);
	    			if($v->children->count() > 0){
	    				$ret[$v->location_id]['c'] = $this->getAllHierarhy($v->location_id, $_level, $_active);
	    			}
	    		}
	    		Cache::put($cache_key, $ret, config('dc.cache_expire'));
	    	}
    	}
    	return $ret;
    }
    
    public function getOneLevel($_parent_id = null)
    {
    	return $this->where('location_parent_id', $_parent_id)
    	->orderBy('location_name', 'asc')
    	->get();
    }
    
    public function getIdBySlug($_slug)
    {
    	$ret = 0;
    	$l_object = $this->select('location_id')
    	->where('location_slug', $_slug)
    	->first();
    	 
    	if(!empty($l_object)){
    		$ret = $l_object->location_id;
    	}
    	return $ret;
    }
    
    public function getSlugById($_location_id)
    {
    	$ret = '';
    	$l_object = $this->select('location_slug')
    	->where('location_id', $_location_id)
    	->first();
    
    	if(!empty($l_object)){
    		$ret = $l_object->location_slug;
    	}
    	return $ret;
    }
    
    public function getParentsByIdFlat($_location_id)
    {
        $ret = array();
        do{
            $locationCollection = $this->where('location_id', $_location_id)->with('parents')->first();
            if(!empty($locationCollection)){
                $ret[$locationCollection->location_id] = $locationCollection->attributes;
            }
            if(!empty($locationCollection->parents)){
                $_location_id = $locationCollection->parents->location_id;
            }
        } while ( !empty($locationCollection) && !empty($locationCollection->parents));
        return $ret;
    }
}
