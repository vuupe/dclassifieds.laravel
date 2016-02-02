<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Http\Dc\Util;
use App\Category;
//use App\Http\Dc\Util;

class AdController extends Controller
{
	protected $category;
	protected $location;
	
	public function __construct(CategoryRepository $_category, LocationRepository $_location)
	{
		$this->category = $_category;
		$this->location = $_location;
	}
	
    public function index(Request $request)
    {
    	return view('ad.home', ['c' => $this->category->getAllHierarhy(),
    							'l' => $this->location->getAllHierarhy(),
    							'clist' => $this->category->getOneLevel()]);
    }
    
    public function proxy(Request $request)
    {
    	echo 'proxy';
    	$params = Input::all();
    	print_r($params);
    	echo $request->slug;
    }
    
    public function search(Request $request)
    {
//     	echo $request->category_slug;
    	$breadcrump = array();
    	
    	//check if category selected
    	$category_slug = '';
    	if(isset($request->category_slug)){
    		$category_slug = Util::sanitize($request->category_slug);
    	}
    	
    	$cid = 0;
    	if(!empty($category_slug)){
    		$cid = $this->category->getCategoryIdByFullPath($category_slug);		
    	}
    	
    	//get selected category childs
    	$clist = array();
    	if($cid > 0){
    		$clist = $this->category->getOneLevel($cid);
    		$breadcrump_data = $this->category->getParentsByIdFlat($cid);
    		if(!empty($breadcrump_data)){
	    		foreach ($breadcrump_data as $k => &$v){
	    			$v['category_full_path'] = $this->category->getCategoryFullPathById($v['category_id']);
	    		}
	    		//category part of breadcrump
	    		$breadcrump['c'] = array_reverse($breadcrump_data);
    		}
//     		print_r($breadcrump_data);
    	}
    	
    	$params = Input::all();
		
    	//check for location selection
    	$lid = 0;
    	if(isset($params['lid']) && is_numeric($params['lid'])){
    		$lid = $params['lid'];
    	}
    	
    	//check for search text
    	$search_text = '';
    	if(isset($params['search_text'])){
    		$search_text_tmp = Util::sanitize($params['search_text']);
    		if(!empty($search_text_tmp) && mb_strlen($search_text_tmp, 'utf-8') > 3){
    			$search_text = $search_text_tmp;
    		}
    	}
    	
    	return view('ad.search', [	'c' => $this->category->getAllHierarhy(),
    						 		'l' => $this->location->getAllHierarhy(),
    								'cid' => $cid,
    								'lid' => $lid,
    								'search_text' => $search_text,
    								'clist' => $clist,
    								'breadcrump' => $breadcrump]);
    }
    
    public function detail(Request $request)
    {
    	return view('ad.detail');
    }
    
    public function publish(Request $request)
    {
    	return view('ad.publish');
    }
}
