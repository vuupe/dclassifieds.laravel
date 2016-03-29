<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';
    protected $primaryKey = 'location_id';
    public $timestamps = false;
    
    public function parents()
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
