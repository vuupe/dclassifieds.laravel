<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const COMMON_TYPE = 0; //common ads type 
    const REAL_ESATE_TYPE = 1; //real estate ads
    const AUTO_TYPE = 2; //autos ads
	
	protected $table = 'category';
    protected $primaryKey = 'category_id';
    public $timestamps = false;
    
    public function parents()
    {
    	return $this->belongsTo('App\Category', 'category_parent_id');
    }
    
    public function children()
    {
    	return $this->hasMany('App\Category', 'category_parent_id');
    }
    
    public function getAllHierarhy($_parent_id = null, $_level = 0)
    {
    	$ret = array();
    	$_level++;
    	$categoryCollection = $this->where('category_parent_id', $_parent_id)
    							->where('category_active', '=', 1)
    							->with('children')
    							->orderBy('category_ord', 'asc')
    							->get();
    	
    	if(!empty($categoryCollection)){
    		foreach ($categoryCollection as $k => $v){
    			$ret[$v->category_id] = array('cid' => $v->category_id, 'title' => $v->category_title, 'level' => $_level);
    			if($v->children->count() > 0){
    				$ret[$v->category_id]['c'] = $this->getAllHierarhy($v->category_id, $_level);
    			}
    		}
    	}
    	return $ret;
    }
    
    public function getOneLevel($_parent_id = null)
    {
    	$categoryCollection = $this->where('category_parent_id', $_parent_id)
    				->orderBy('category_ord', 'asc')
    				->get();
    	return $categoryCollection;
    }
    
    public function getIdBySlug($_slug)
    {
    	$ret = 0; 
    	$c_object = $this->select('category_id')
    					->where('category_slug', $_slug)
    					->first();
    	
    	if(!empty($c_object)){
    		$ret = $c_object->category_id;
    	}
    	return $ret;
    }
    
    public function getSlugById($_category_id)
    {
    	$ret = '';
    	$c_object = $this->select('category_slug')
    					->where('category_id', $_category_id)
    					->first();
    	 
    	if(!empty($c_object)){
    		$ret = $c_object->category_slug;
    	}
    	return $ret;
    }
    
    public function getParentsBySlug($_slug)
    {
    	$ret = array();
    	$categoryCollection = $this->where('category_slug', $_slug)
    							->with('parents')
    							->first();
    	
    	//get parents
    	if(!empty($categoryCollection)){
    		$ret[$categoryCollection->category_id] = $categoryCollection->attributes;
    		if(!empty($categoryCollection->parents)){
    			$ret[$categoryCollection->category_id]['parent'] = $this->getParentsBySlug($categoryCollection->parents->category_slug);
    		}
    	}
    	return $ret;
    }
    
    public function getParentsById($_category_id)
    {
    	$ret = array();
    	$categoryCollection = $this->where('category_id', $_category_id)
    							->with('parents')
    							->first();
    	 
    	//get parents
    	if(!empty($categoryCollection)){
    		$ret[$categoryCollection->category_id] = $categoryCollection->attributes;
    		if(!empty($categoryCollection->parents)){
    			$ret[$categoryCollection->category_id]['parent'] = $this->getParentsById($categoryCollection->parents->category_id);
    		}
    	}
    	return $ret;
    }
    
    public function getParentsBySlugFlat($_slug)
    {
    	$ret = array();
    	do{
    		$categoryCollection = $this->where('category_slug', $_slug)->with('parents')->first();
    		$ret[$categoryCollection->category_id] = $categoryCollection->attributes;
    		$ret[$categoryCollection->category_id]['category_full_path'] = $this->getCategoryFullPathById($_category_id);
    		if(!empty($categoryCollection->parents)){
    			$_slug = $categoryCollection->parents->category_slug;
    		}
    	} while ( !empty($categoryCollection) && !empty($categoryCollection->parents));
    	return $ret;
    }
    
    public function getParentsByIdFlat($_category_id)
    {
    	$ret = array();
    	do{
    		$categoryCollection = $this->where('category_id', $_category_id)->with('parents')->first();
    		if(!empty($categoryCollection)){
    			$ret[$categoryCollection->category_id] = $categoryCollection->attributes;
    		}
    		if(!empty($categoryCollection->parents)){
    			$_category_id = $categoryCollection->parents->category_id;
    		}
    	} while ( !empty($categoryCollection) && !empty($categoryCollection->parents));
    	return $ret;
    }
    
    public function getInfoBySlug($_slug)
    {
    	$ret = array();
    	$categoryCollection = $this->where('category_slug', $_slug)->first();
    	if(!empty($categoryCollection)){
    		$ret = $categoryCollection->attributes;
    	}
    	return $ret;
    }
    
    public function getInfoById($_category_id)
    {
    	$ret = array();
    	$categoryCollection = $this->where('category_id', $_category_id)->first();
    	if(!empty($categoryCollection)){
    		$ret = $categoryCollection->attributes;
    	}
    	return $ret;
    }
    
    public function getCategoryFullPathById($_category_id)
    {
    	$ret = '';
    	$parentCategories = $this->getParentsByIdFlat($_category_id);
    	if(!empty($parentCategories)){
	    	$parentCategories = array_reverse($parentCategories);
	    	$ret_array = array();
	    	foreach ($parentCategories as $k => $v){
	    		$ret_array[] = $v['category_slug'];
	    	}
	    	if(!empty($ret_array)){
	    		$ret = join('/', $ret_array);
	    	}
    	}
    	return $ret;
    }
    
    public function getCategoryIdByFullPath($_path)
    {
    	$ret = 0;
    	$path_parts_array = explode('/', trim($_path, ' /'));
    	if(is_array($path_parts_array)){
    		$last_category_slug = array_pop($path_parts_array);
    		$category_id = $this->getIdBySlug($last_category_slug);
    		if($category_id > 0){
    			$ret = $category_id;
    		}
    	}
    	return $ret;
    }
}
