<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'location_id';
    
    public function parent()
    {
    	return $this->belongsTo('App\Location', 'location_parent_id');
    }
    
    public function children()
    {
    	return $this->hasMany('App\Location', 'location_parent_id');
    }
    
    public function getAllHierarhy($_parent_id = null, $_level = 0)
    {
    	$ret = array();
    	$_level++;
    	$locationCollection = $this->where('location_parent_id', $_parent_id)
    							->where('location_active', '=', 1)
    							->with('children')
    							->orderBy('location_name', 'asc')
    							->get();
    	
    	if(!empty($locationCollection)){
    		foreach ($locationCollection as $k => $v){
    			$ret[$v->location_id] = array('lid' => $v->location_id, 'title' => $v->location_name, 'level' => $_level);
    			if($v->children->count() > 0){
    				$ret[$v->location_id]['c'] = $this->getAllHierarhy($v->location_id, $_level);
    			}
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
}
