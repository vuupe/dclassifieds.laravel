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
use App\Location;
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
    	$root = $request->root();
    	$url_params = array();
    	
    	$params = Input::all();
//     	print_r($params);
    	
    	//check for selected category
    	$cid = 0;
    	if(isset($params['cid']) && $params['cid'] > 0){
    		$cid = $params['cid'];
    		$category_slug = $this->category->getCategoryFullPathById($cid);
    		$url_params[] = $category_slug;
    		unset($params['cid']);
    	}
    	
    	//check for location selection
    	$lid = 0;
    	if(isset($params['lid']) && $params['lid'] > 0){
    		$lid = $params['lid'];
    		$location_slug = $this->location->getSlugById($lid);
    		$url_params[] = 'l-' . $location_slug;
    		unset($params['lid']);
    	}
    	
    	//check for search text
    	$search_text = '';
    	if(isset($params['search_text'])){
    		$search_text_tmp = Util::sanitize($params['search_text']);
    		if(!empty($search_text_tmp) && mb_strlen($search_text_tmp, 'utf-8') > 3){
    			$search_text = $search_text_tmp;
    			$search_text = preg_replace('/\s+/', '-', $search_text);
    			$url_params[] = 'q-' . $search_text;
    		}
    		unset($params['search_text']);
    	}
    	
    	if(!empty($url_params)){
    		$redirect_url = $root . '/' . join('/', $url_params);
    	}
    	
    	$query_string = '';
    	if(!empty($params)){
    		$query_string = Util::getQueryStringFromArray($params);
    	}
    	
    	if(!empty($query_string)){
    		$redirect_url .= '?' . $query_string;
    	}
    	
    	return redirect($redirect_url);
    	
    }
    
    public function search(Request $request)
    {
    	$params = Input::all();
    	print_r($params);
    	
    	echo 'category_slug: ' . $request->category_slug . '<br />';
    	echo 'location_slug: ' . $request->location_slug . '<br />';
    	echo 'search_slug: ' . $request->search_slug . '<br />';
    	
    	
    	
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
    	
//     	$params = Input::all();
		
    	//check for location selection
    	$location_slug = '';
    	if(isset($request->location_slug)){
    		$location_slug = Util::sanitize($request->location_slug);
    	}
    	
    	$lid = 0;
    	if(!empty($location_slug)){
    		$lid = $this->location->getIdBySlug($location_slug);		
    	}
    	
    	//check for search text
    	$search_text = '';
    	$search_text_tmp = '';
    	if(isset($request->search_slug)){
    		$search_text_tmp = Util::sanitize($request->search_slug);
    	}
    	
    	if(!empty($search_text_tmp) && mb_strlen($search_text_tmp, 'utf-8') > 3){
    		$search_text = preg_replace('/-/', ' ', $search_text_tmp);
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
