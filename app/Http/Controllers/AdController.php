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
//     	print_r(Input::all());
    	$params = Input::all();
		
    	//check for category selection
    	$cid = 0;
    	if(isset($params['cid']) && is_numeric($params['cid'])){
    		$cid = $params['cid'];
    	}
    	
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
    								'search_text' => $search_text]);
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
