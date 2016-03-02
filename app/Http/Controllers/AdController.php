<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\AdRepository;
use App\Http\Dc\Util;
use App\Category;
use App\Location;
use App\Ad;


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
    
    public function getPublish()
    {
    	return view('ad.publish', ['c' => $this->category->getAllHierarhy(),
    							   'l' => $this->location->getAllHierarhy(),]);
    }
    
    public function postPublish(Request $request)
    {
    	$rules = [
    		'ad_title' => 'required|max:255',
    		'category_id' => 'required|integer|not_in:0',
    		'ad_description' => 'required|min:50',
    		//'ad_image' => 'require_one_of_array',
    		'ad_image.*' => 'mimes:jpeg,bmp,png|max:300',
    		'location_id' => 'required|integer|not_in:0',
    		'ad_puslisher_name' => 'required|string|max:255',
    		'ad_email' => 'required|email|max:255',
    		'policy_agree' => 'required',
    	];
    	
    	$messages = [
    		'require_one_of_array' => 'You need to upload at least one ad pic.',
    	];
    	
    	$validator = Validator::make($request->all(), $rules, $messages);
    	
    	if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
    	
    	$ad_data = $request->all();
    	
    	//generate ad unique key
    	$ad_data['code'] = str_random(40);
    	
    	//fill aditional fields
    	$ad_data['user_id'] = $request->user()->user_id;
    	$ad_data['ad_publish_date'] = date('Y-m-d');
    	
    	//create ad
    	$ad = Ad::create($ad_data);
    	
    	//upload and fix ad images
    	$ad_image = Input::file('ad_image');
    	$destination_path = public_path('uf/adata/');
    	$first_image_uploaded = 0;
    	foreach ($ad_image as $k){
    		if(!empty($k) && $k->isValid()){
    			$file_name = $ad->ad_id . '_' .md5(time() + rand(0,9999)) . '.' . $k->getClientOriginalExtension();
    			$k->move($destination_path, $file_name);
    			if(!$first_image_uploaded){
    				$first_image_uploaded = 1;
    				$ad->ad_pic = $file_name;
    				$ad->save();
    			}
    		}
    	}
//     	exit;
    	
    	//send info and activation mail
//     	Mail::send('emails.activation', ['user' => $user], function ($m) use ($user) {
//     		$m->from('test@mylove.bg', 'dclasssifieds activation');
//     		$m->to($user->email)->subject('Activate your account!');
//     	});

    	//send control mail
    	
    	//set flash message and return
    	session()->flash('message', 'Your ad is in moderation mode, please activate it.');
    	return redirect()->back();
    }
}
