<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\AdRepository;
use App\Http\Dc\Util;
use App\Category;
use App\Location;
//use App\Http\Dc\Util;

class AdController extends Controller
{
	protected $category;
	protected $location;
	protected $ad;
	
	public function __construct(CategoryRepository $_category, LocationRepository $_location, AdRepository $_ad)
	{
		$this->category = $_category;
		$this->location = $_location;
		$this->ad = $_ad;
	}
	
    public function index(Request $request)
    {
    	//is there selected location
    	$lid = session()->get('lid', 0);
    	
    	//generate category url with location if selected
    	$clist = $this->category->getOneLevel();
    	if(!empty($clist)){
    		foreach ($clist as $k => &$v){
    			$category_url_params = array();
    			$category_url_params[] = $this->category->getCategoryFullPathById($v->category_id);
    			if(session()->has('location_slug')){
    				$category_url_params[] = 'l-' . session()->get('location_slug');
    			}
    			
    			if(!empty($category_url_params)){
    				$v->category_url = Util::buildUrl($category_url_params);	 
    			}	
    		}
    	}
    	
    	return view('ad.home', ['c' => $this->category->getAllHierarhy(),
    							'l' => $this->location->getAllHierarhy(),
    							'clist' => $clist,
    							'lid' => $lid]);
    }
    
    public function proxy(Request $request)
    {
    	//root url / base url
    	$root 			= $request->root();
    	
    	//generated url if no parameters redirect to home
    	$redirect_url 	= $root;
    	
    	//generated url parameters container
    	$url_params 	= array();
    	
    	//get incoming parameters
    	$params = Input::all();
    	
    	//check for category selection
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
    		session()->put('lid', $lid);
    		session()->put('location_slug', $location_slug);
    	} else {
    		if(session()->has('lid')){
    			session()->forget('lid');
    		}
    		
    		if(session()->has('location_slug')){
    			session()->forget('location_slug');
    		}
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
    	
    	//generate new url for redirection
    	if(!empty($url_params)){
    		$redirect_url = Util::buildUrl($url_params);
    	}
    	
    	//check if there are parameters for query string
    	$query_string = '';
    	if(!empty($params)){
    		$query_string = Util::getQueryStringFromArray($params);
    	}
    	
    	//add query string to generated url
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
    	echo 'search_text: ' . $request->search_text . '<br />';
    	
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
    	
    	//if category selected get childs and generate url and breadcrump
    	$clist = array();
    	if($cid > 0){
    		$clist = $this->category->getOneLevel($cid);
    		foreach ($clist as $k => &$v){
    			$category_url_params = array();
    			$category_url_params[] = $this->category->getCategoryFullPathById($v->category_id);
    			if(session()->has('location_slug')){
    				$category_url_params[] = 'l-' . session()->get('location_slug');
    			}
    			 
    			if(!empty($category_url_params)){
    				$v->category_url = Util::buildUrl($category_url_params);
    			}
    		}
    		
    		$breadcrump_data = $this->category->getParentsByIdFlat($cid);
    		if(!empty($breadcrump_data)){
	    		foreach ($breadcrump_data as $k => &$v){
	    			$category_url_params = array();
	    			$category_url_params[] = $this->category->getCategoryFullPathById($v['category_id']);
	    			if(session()->has('location_slug')){
	    				$category_url_params[] = 'l-' . session()->get('location_slug');
	    			}
	    			
	    			if(!empty($category_url_params)){
	    				$v['category_url'] = Util::buildUrl($category_url_params);
	    			}
	    		}
	    		//category part of breadcrump
	    		$breadcrump['c'] = array_reverse($breadcrump_data);
    		}
    	}
    	
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
    	if(isset($request->search_text)){
    		$search_text_tmp = Util::sanitize($request->search_text);
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
