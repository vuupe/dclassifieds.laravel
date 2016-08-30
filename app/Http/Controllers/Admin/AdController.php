<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ad;

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
    	return view('admin.ad.ad_list');
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
    		$data = $request->input('category_id');
    	}
    	
    	//delete
    	if(!empty($data)){
    		foreach ($data as $k => $v){
    			$c = Category::find($v);
    			if(!empty($c->category_img)){
    				@unlink(public_path() . '/uf/cicons/' . $c->category_img);
    			}
    			$c->delete();
    		}
    		//clear cache, set message, redirect to list
    		Cache::flush();
    		session()->flash('message', 'Category deleted');
    		return redirect(url('admin/category'));
    	}
    	
    	//nothing for deletion set message and redirect
    	session()->flash('message', 'Nothing for deletion');
    	return redirect(url('admin/category'));
    }
    
    public function axlist(Request $request)
    {
    	$ret = ['data' => []];
    	$draw = 1;
    	if(isset($request->draw)){
    		$draw = (int)$request->draw;
    	}
    	$start = 1;
    	if(isset($request->start)){
    		$start = (int)$request->start;
    	}
    	$length = 10;
    	if(isset($request->length)){
    		$length = (int)$request->length;
    	}
    	$page = $start / $length;
    	if($page < 0){
    		$page = 0;
    	}
    	$page++;
    	$request->request->add(['page' => $page]); 
    	
    	$adList = $this->ad->getAdList([], ['ad_id' => 'desc'], 0, '', [], [], $length, $page);
    	if(!$adList->isEmpty()){
    		$ret['draw'] = (int)$request->draw;
    		$ret['recordsTotal'] = $this->ad->count();
    		$ret['recordsFiltered'] = $this->ad->count();
    		
    		foreach ($adList as $k => $v){
    			$active = '<span class="fa fa-close" aria-hidden="true" style="color:red;"></span>';
    			if($v->ad_active == 1){
    				$active = '<span class="fa fa-check" aria-hidden="true" style="color:green;"></span>';
    			}
    			$ret['data'][] = [
    				'<input type="checkbox" name="ad_id[]" value="' . $v->ad_id . '">',
    				$v->ad_id,
    				$v->location_name,
    				$v->ad_title,
    				$v->ad_promo,
    				$v->ad_publish_date,
    				$active,
    				$v->ad_view,
    				'<a href="' . url('admin/ad/edit/' . $v->ad_id) . '"><i class="fa fa-edit"></i> Edit',
    				'<a href="' . url('admin/ad/delete/' . $v->ad_id) . '" class="text-danger need_confirm"><i class="fa fa-trash"></i> Delete</a>'
    			];
    		}
    	}
    	echo json_encode($ret);
    }
}
