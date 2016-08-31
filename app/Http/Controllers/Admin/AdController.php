<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ad;
use App\AdPic;

use Validator;
use Cache;

class AdController extends Controller
{
	protected $ad;
	
	public function __construct(Ad $_ad)
    {
    	$this->ad = $_ad;
    }
    
	public function index(Request $request)
    {
    	$params 	= Input::all();
    	$where 		= [];
    	$order 		= ['ad_id' => 'desc'];
    	$limit 		= 0;
    	$orderRaw 	= '';
    	$whereIn 	= [];
    	$whereRaw 	= [];
    	$paginate 	= 2;
    	$page 		= 1;
    	
    	if(isset($params['ad_id_search']) && !empty($params['ad_id_search'])){
    		$where['ad_id'] = ['=', $params['ad_id_search']];
    	}
    	
    	if(isset($params['ad_ip']) && !empty($params['ad_ip'])){
    		$where['ad_ip'] = ['like', $params['ad_ip'] . '%'];
    	}
    	
    	if(isset($params['location_name']) && !empty($params['location_name'])){
    		$where['location_name'] = ['like', $params['location_name'] . '%'];
    	}
    	if(isset($params['ad_title']) && !empty($params['ad_title'])){
    		$where['ad_title'] = ['like', $params['ad_title'] . '%'];
    	}
    	if(isset($params['user_id']) && !empty($params['user_id'])){
    		$where['user_id'] = ['=', $params['user_id']];
    	}
    	if(isset($params['ad_puslisher_name']) && !empty($params['ad_puslisher_name'])){
    		$where['ad_puslisher_name'] = ['like', $params['ad_puslisher_name'] . '%'];
    	}
    	if(isset($params['ad_email']) && !empty($params['ad_email'])){
    		$where['ad_email'] = ['like', $params['ad_email'] . '%'];
    	}
    	if(isset($params['ad_promo']) && !empty($params['ad_promo'])){
    		$where['ad_promo'] = ['=', $params['ad_promo']];
    	}
    	if(isset($params['ad_active']) && !empty($params['ad_active'])){
    		$where['ad_active'] = ['=', $params['ad_active']];
    	}
    	if(isset($params['ad_view']) && !empty($params['ad_view'])){
    		$where['ad_view'] = ['=', $params['ad_view']];
    	}
    	
    	if (isset($params['page']) && is_numeric($params['page'])) {
    		$page = $params['page'];
    	}
    	
    	$adList = $this->ad->getAdList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate, $page);
    	return view('admin.ad.ad_list', ['adList' => $adList, 'params' => $params]);
    }
    
    public function edit(Request $request)
    {
    	$allCategoryHierarhy = $this->category->getAllHierarhy(null, 0, 0);
    	$categoryType = [1 => 'Common Type', 2 => 'Real Estate Type', 3 => 'Cars Type'];
    	
    	$id = 0;
    	if(isset($request->id)){
    		$id = $request->id;
    	}
    	
    	$modelData = new \stdClass();
    	if($id > 0){
    		try{
    			$modelData = Category::findOrFail($id);
    		} catch (ModelNotFoundException $e){
    			session()->flash('message', 'Invalid Category');
    			return redirect(url('admin/category'));
    		}
    	}
    	
    	$cid = 0;
    	if(isset($modelData->category_parent_id) && $modelData->category_parent_id > 0){
    		$cid = $modelData->category_parent_id;
    	}
    	
    	/**
    	 * form is submitted check values and save if needed
    	 */
    	if ($request->isMethod('post')) {
    		
    		/**
    		 * validate data
    		 */
    		$rules = [
    			'category_title' => 'required|max:255',
    			'category_slug' => 'required|max:255|unique:category,category_slug',
    			'category_type' => 'required|integer',
    			'category_ord' => 'required|integer'
    		];
    		
    		if(isset($modelData->category_id)){
    			$rules['category_slug'] = 'required|max:255|unique:category,category_slug,' . $modelData->category_id  . ',category_id';
    		}
    		 
    		$validator = Validator::make($request->all(), $rules);
    		if ($validator->fails()) {
    			$this->throwValidationException(
    				$request, $validator
    			);
    		}
    		
    		/**
    		 * get data from form
    		 */
    		$data = $request->all();
    		
    		/**
    		 * check for uploaded icon
    		 */
    		$name = '';
    		if ($request->file('icon_file')->isValid()) {
    			$file = Input::file('icon_file');
    			$name = time() . '_cicon.' . $file->getClientOriginalExtension();
    			$file->move(public_path() . '/uf/cicons', $name);
    			$data['category_img'] = $name;
    		}
    		
    		/**
    		 * save data if validated
    		 */
    		if(isset($data['category_active'])){
    			$data['category_active'] = 1;
    		} else {
    			$data['category_active'] = 0;
    		}
    		if($data['category_parent_id'] == 0){
    			unset($data['category_parent_id']);
    		}
    		
    		/**
    		 * save or update
    		 */
    		if(!isset($modelData->category_id)){
    			Category::create($data);
    		} else {
    			if(!empty($name) && !empty($modelData->category_img)){
    				@unlink(public_path() . '/uf/cicons/' . $modelData->category_img);
    			}
    			$modelData->update($data);
    		}
    		
    		/**
    		 * clear cache, set message, redirect to list
    		 */
    		Cache::flush();
    		session()->flash('message', 'Category saved');
    		return redirect(url('admin/category'));
    	}
    	
    	return view('admin.category.category_edit', ['c' => $allCategoryHierarhy,
    		'modelData' => $modelData,
    		'cid' => $cid,
    		'categoryType' => $categoryType]);
    }
    
    public function delete(Request $request)
    {
    	//locations to be deleted
    	$data = [];
    	
    	//check for single delete
    	if(isset($request->id)){
    		$data[] = $request->id;
    	}
    	
    	//check for mass delete if no single delete
    	if(empty($data)){
    		$data = $request->input('ad_id');
    	}
    	
    	//delete
    	if(!empty($data)){
    		foreach ($data as $k => $v){
    			$ad = Ad::where('ad_id', $v)->first();
    			if(!empty($ad)){
    				//delete images
    				if(!empty($ad->ad_pic)){
    					@unlink(public_path('uf/adata/') . '740_' . $ad->ad_pic);
    					@unlink(public_path('uf/adata/') . '1000_' . $ad->ad_pic);
    				}
    			
    				$more_pics = AdPic::where('ad_id', $ad->ad_id)->get();
    				if(!$more_pics->isEmpty()){
    					foreach ($more_pics as $km => $vm){
    						@unlink(public_path('uf/adata/') . '740_' . $vm->ad_pic);
    						@unlink(public_path('uf/adata/') . '1000_' . $vm->ad_pic);
    						$vm->delete();
    					}
    				}
    			
    				$ad->delete();
    				$message = 'Your ad is deleted';
    			} else {
    				$message = 'Ups something is wrong.';
    			}	
    		}
    		//clear cache, set message, redirect to list
    		Cache::flush();
    		session()->flash('message', 'Ads deleted');
    		return redirect(url('admin/ad'));
    	}
    	
    	//nothing for deletion set message and redirect
    	session()->flash('message', 'Nothing for deletion');
    	return redirect(url('admin/ad'));
    }
}
