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
use App\AdType;
use App\AdCondition;
use App\EstateConstructionType;
use App\EstateFurnishingType;
use App\EstateHeatingType;
use App\EstateType;
use App\CarBrand;
use App\CarModel;
use App\CarEngine;
use App\CarTransmission;
use App\CarCondition;
use Image;
use App\AdPic;
use Mail;
use DB;

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
    	
    	//get home page ads
    	$ad = DB::table('ad');
    	$ad->where('ad_promo', 1);
    	$ad->where('ad_active', 1);
    	if($lid > 0){
    	    $ad->where('location_id', $lid);
    	}
    	
    	$ad->orderBy('ad_publish_date', 'desc');
    	$promo_ad_list = $ad->get();
    	
    	return view('ad.home', ['c' => $this->category->getAllHierarhy(),
    							'l' => $this->location->getAllHierarhy(),
    							'clist' => $clist,
    							'lid' => $lid,
    	                        'promo_ad_list' => $promo_ad_list]);
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
    		if (empty($cid)) {
    		    abort(404);
    		}		
    	}
    	
    	//if category selected get childs and generate url and breadcrump
    	$clist = array();
    	$all_category_childs = array();
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
    		
    		$acc = $this->category->getAllHierarhyFlat($cid);
    		if(!empty($acc)){
    		    foreach($acc as $ak => $av){
    		        $all_category_childs[] = $av['cid'];
    		    }    
    		} 
    		$all_category_childs[] = $cid;
    	}
    	
    	//check for location selection
    	$location_slug = '';
    	if(isset($request->location_slug)){
    		$location_slug = Util::sanitize($request->location_slug);
    	}
    	
    	$lid = 0;
    	if(!empty($location_slug)){
    		$lid = $this->location->getIdBySlug($location_slug);
    		if (empty($lid)) {
    		    abort(404);
    		}		
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
    	
    	//get promo ads
    	$ad = DB::table('ad');
    	$ad->where('ad_promo', 1);
    	$ad->where('ad_active', 1);
    	if($lid > 0){
    	    $ad->where('location_id', $lid);
    	}
    	if($cid > 0){
    	    $ad->whereIn('category_id', $all_category_childs);
    	}
    	if(!empty($search_text)){
    	    $ad->whereRaw('match(ad_title, ad_description) against(?)', [$search_text]);
    	}
    	 
    	$ad->take(4);
    	$ad->orderByRaw('rand()');
    	$promo_ad_list = $ad->get();
    	
    	//get normal ads
    	$ad = DB::table('ad');
    	$ad->where('ad_active', 1);
    	if($lid > 0){
    	    $ad->where('location_id', $lid);
    	}
    	if($cid > 0){
    	    $ad->whereIn('category_id', $all_category_childs);
//     	    $ad->where('category_id', 500);
    	}
    	if(!empty($search_text)){
    	    $ad->whereRaw('match(ad_title, ad_description) against(?)', [$search_text]);
    	}
    	
    	$ad->orderBy('ad_publish_date', 'desc');
    	$ad_list = $ad->paginate(2);
    	//echo count($ad_list);
    	//print_r($ad_list);
    	//exit;
    	
    	
//     	$query = DB::getQueryLog();
//     	print_r($query);
//     	exit;
    	
    	
    	return view('ad.search', [	'c' => $this->category->getAllHierarhy(),
    						 		'l' => $this->location->getAllHierarhy(),
    								'cid' => $cid,
    								'lid' => $lid,
    								'search_text' => $search_text,
    								'clist' => $clist,
    								'breadcrump' => $breadcrump,
    	                            'promo_ad_list' => $promo_ad_list,
    	                            'ad_list' => $ad_list]);
    }
    
    public function detail(Request $request)
    {
    	//get ad id
        $ad_id = $request->ad_id;
        
        //get ad info
        $ad_detail = Ad::select('ad.*', 'C.category_title', 'L.location_name', 'L.location_slug', 'AC.ad_condition_name', 'AT.ad_type_name',
                'ET.estate_type_name', 'ECT.estate_construction_type_name', 'EHT.estate_heating_type_name', 'EFT.estate_furnishing_type_name',
                'CB.car_brand_name', 'CM.car_model_name', 'CE.car_engine_name', 'CT.car_transmission_name', 'CC.car_condition_name')
        
            ->leftJoin('category AS C', 'C.category_id' , '=', 'ad.category_id')
            ->leftJoin('location AS L', 'L.location_id' , '=', 'ad.location_id')
            ->leftJoin('ad_condition AS AC', 'AC.ad_condition_id' , '=', 'ad.condition_id')
            ->leftJoin('ad_type AS AT', 'AT.ad_type_id' , '=', 'ad.type_id')
            
            ->leftJoin('estate_type AS ET', 'ET.estate_type_id' , '=', 'ad.estate_type_id')
            ->leftJoin('estate_construction_type AS ECT', 'ECT.estate_construction_type_id' , '=', 'ad.estate_construction_type_id')
            ->leftJoin('estate_heating_type AS EHT', 'EHT.estate_heating_type_id' , '=', 'ad.estate_heating_type_id')
            ->leftJoin('estate_furnishing_type AS EFT', 'EFT.estate_furnishing_type_id' , '=', 'ad.estate_furnishing_type_id')
            
            ->leftJoin('car_brand AS CB', 'CB.car_brand_id' , '=', 'ad.car_brand_id')
            ->leftJoin('car_model AS CM', 'CM.car_model_id' , '=', 'ad.car_model_id')
            ->leftJoin('car_engine AS CE', 'CE.car_engine_id' , '=', 'ad.car_engine_id')
            ->leftJoin('car_transmission AS CT', 'CT.car_transmission_id' , '=', 'ad.car_transmission_id')
            ->leftJoin('car_condition AS CC', 'CC.car_condition_id' , '=', 'ad.car_condition_id')
            
            ->where('ad_active', 1)
            ->findOrFail($ad_id);
        
//         print_r($ad_detail);
       
        
        //get ad pics
        $ad_pic = AdPic::where('ad_id', $ad_id)->get();
        
        
        return view('ad.detail', ['ad_detail' => $ad_detail, 'ad_pic' => $ad_pic]);
    }
    
    public function getPublish()
    {
        $car_model_id = array();
        if(old('car_brand_id')){
            if(is_numeric(old('car_brand_id')) && old('car_brand_id') > 0){
                $car_models = CarModel::where('car_brand_id', old('car_brand_id'))->orderBy('car_model_name', 'asc')->get();
                if(!$car_models->isEmpty()){
                    $car_model_id = array(0 => 'Select Car Model');
                    foreach ($car_models as $k => $v){
                        $car_model_id[$v->car_model_id] = $v->car_model_name;
                    }
                }
            }
        }
        
    	return view('ad.publish', [	'c' => $this->category->getAllHierarhy(),
    							   	'l' => $this->location->getAllHierarhy(),
    							   	'at' => AdType::all(),
    							   	'ac' => AdCondition::all(),
    							   	'estate_construction_type' => EstateConstructionType::all(),
    								'estate_furnishing_type' => EstateFurnishingType::all(),
    								'estate_heating_type' => EstateHeatingType::all(),
    								'estate_type' => EstateType::all(),
    								'car_brand_id' => CarBrand::all(),
    	                            'car_model_id' => $car_model_id,
    								'car_engine_id' => CarEngine::all(),
    								'car_transmission_id' => CarTransmission::all(),
    								'car_condition_id' => CarCondition::all(),]);
    }
    
    public function postPublish(Request $request)
    {
    	$rules = [
    		'ad_title' => 'required|max:255',
    		'category_id' => 'required|integer|not_in:0',
    		'ad_description' => 'required|min:50',
    		'type_id' => 'required|integer|not_in:0',
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
    	
    	/**
    	 * type 1 common ads validation 
    	 */
    	$validator->sometimes(['ad_price_type_1'], 'required|numeric|not_in:0', function($input){
    		if($input->category_type == 1 && $input->price_radio == 1){
    			return true;
    		}
    		return false; 
    	});
    	$validator->sometimes(['condition_id'], 'required|integer|not_in:0', function($input){
	    	return $input->category_type == 1 ? 1 : 0;
    	});
    	
    	/**
    	 * type 2 estate ads validation
    	 */
    	$validator->sometimes(['ad_price_type_2'], 'required|numeric|not_in:0', function($input){
	    	if($input->category_type == 2){
	    		return true;
	    	}
	    	return false;
    	});
    	$validator->sometimes(['estate_type_id'], 'required|integer|not_in:0', function($input){
    		return $input->category_type == 2 ? 1 : 0;
    	});    			
    	$validator->sometimes(['estate_sq_m'], 'required|numeric|not_in:0', function($input){
    		return $input->category_type == 2 ? 1 : 0;
    	});
    				
    	/**
    	 * type 3 cars ads validation 
    	 */
		$validator->sometimes(['car_brand_id'], 'required|integer|not_in:0', function($input){
			return $input->category_type == 3 ? 1 : 0;
		});
		$validator->sometimes(['car_model_id'], 'required|integer|not_in:0', function($input){
			return $input->category_type == 3 ? 1 : 0;
		});
		$validator->sometimes(['car_engine_id'], 'required|integer|not_in:0', function($input){
			return $input->category_type == 3 ? 1 : 0;
		});
		$validator->sometimes(['car_transmission_id'], 'required|integer|not_in:0', function($input){
			return $input->category_type == 3 ? 1 : 0;
		});
		$validator->sometimes(['car_year'], 'required|integer|not_in:0', function($input){
			return $input->category_type == 3 ? 1 : 0;
		});
		$validator->sometimes(['car_kilometeres'], 'required|integer|not_in:0', function($input){
			return $input->category_type == 3 ? 1 : 0;
		});
		$validator->sometimes(['car_condition_id'], 'required|integer|not_in:0', function($input){
			return $input->category_type == 3 ? 1 : 0;
		});
    	$validator->sometimes(['ad_price_type_3'], 'required|numeric|not_in:0', function($input){
    		return $input->category_type == 3 ? 1 : 0;
    	});
    	
    	if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
//      exit;
    	
    	$ad_data = $request->all();
    	
    	//fill aditional fields
    	$ad_data['user_id'] = $request->user()->user_id;
    	$ad_data['ad_publish_date'] = date('Y-m-d H:i:s');
    	$ad_data['ad_valid_until'] = date('Y-m-d', mktime(null, null, null, date('m')+1, date('d'), date('Y')));
    	$ad_data['ad_ip'] = Util::getRemoteAddress();
    	$ad_data['ad_description'] = strip_tags($ad_data['ad_description']);
    	
    	switch ($ad_data['category_type']){
    	    case 1:
    	        if($ad_data['price_radio'] == 1){
    	            $ad_data['ad_price'] = $ad_data['ad_price_type_1'];
    	            $ad_data['ad_free'] = 0;
    	        } else {
    	            $ad_data['ad_price'] = 0;
    	            $ad_data['ad_free'] = 1;
    	        }
    	        break;
    	    case 2:
    	        $ad_data['ad_price'] = $ad_data['ad_price_type_2'];
    	        break;
    	    case 3:
    	        $ad_data['ad_price'] = $ad_data['ad_price_type_3'];
    	        break; 
    	}
    	
    	$ad_data['ad_description_hash'] = md5($ad_data['ad_description']);
    	
    	
    	//generate ad unique code
    	do{
    		$ad_data['code'] = str_random(30);
    	} while (Ad::where('code', $ad_data['code'])->first());
    	
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
    			
    			$img = Image::make($destination_path . $file_name);
    			$img->widen(1000, function ($constraint) {
                    $constraint->upsize();
                })->save($destination_path . '1000_' . $file_name);
    			
    			if(!$first_image_uploaded){
    			    if($img->width() > 740){
    				    $img->fit(740)->save($destination_path . '740_' . $file_name);
    			    } else {
    			        $img->resizeCanvas(740, 740, 'center')->save($destination_path . '740_' . $file_name);
    			    }
    				$ad->ad_pic = $file_name;
    				$ad->save();
    				$first_image_uploaded = 1;
    			} else {
        			$adPic = new AdPic();
        			$adPic->ad_id = $ad->ad_id;
        			$adPic->ad_pic = $file_name;
        			$adPic->save();
    			}
    			
    			@unlink($destination_path . $file_name);
    		}
    	}
    	
    	$ad->ad_category_info = $this->category->getParentsByIdFlat($ad->category_id);
    	$ad->ad_location_info = $this->location->getParentsByIdFlat($ad->location_id);
    	$ad->pics = AdPic::where('ad_id', $ad->ad_id)->get();
    	$ad->same_ads = Ad::where([['ad_description_hash', $ad->ad_description_hash], ['ad_id', '<>', $ad->ad_id]])->get();
//     	echo view('emails.control_ad_activation', ['ad' => $ad]);
//     	exit;
    	
    	//send info and activation mail
    	Mail::send('emails.ad_activation', ['user' => $request->user(), 'ad' => $ad], function ($m) use ($request){
    		$m->from('test@mylove.bg', 'dclassifieds ad activation');
    		$m->to($request->user()->email)->subject('Activate your ad!');
    	});

    	//send control mail
        Mail::send('emails.control_ad_activation', ['user' => $request->user(), 'ad' => $ad], function ($m) use ($request){
            $m->from('test@mylove.bg', '[CONTROL] dclasssifieds');
            $m->to('webmaster@dclassifieds.eu')->to('dinko359@gmail.com')->subject('[CONTROL] dclasssifieds new ad');
        });
//         exit;
    	
    	//set flash message and return
    	session()->flash('message', 'Your ad is in moderation mode, please activate it.');
    	return redirect()->back();
    }
    
    public function activate(Request $request)
    {
        $code = $request->token;
        $message = '';
        if(!empty($code)){
            $ad = Ad::where('code', $code)->first();
            if(!empty($ad)){
                $ad->ad_active = 1;
                $ad->save();
                $message = 'Your ad is active now';
            } else {
                $message = 'Ups something is wrong.';
            }
        } else {
            $message = 'Ups something is wrong.';
        }
        session()->flash('message', $message);
        return view('common.info_page');
    }
    
    public function delete(Request $request)
    {
        $code = $request->token;
        $message = '';
        if(!empty($code)){
            $ad = Ad::where('code', $code)->first();
            if(!empty($ad)){
                //delete images
                if(!empty($ad->ad_pic)){
                    @unlink(public_path('uf/adata/') . '740_' . $ad->ad_pic);
                    @unlink(public_path('uf/adata/') . '1000_' . $ad->ad_pic);
                }
                
                $more_pics = AdPic::where('ad_id', $ad->ad_id)->get();
                if(!$more_pics->isEmpty()){
                    foreach ($more_pics as $k => $v){
                        @unlink(public_path('uf/adata/') . '740_' . $v->ad_pic);
                        @unlink(public_path('uf/adata/') . '1000_' . $v->ad_pic);
                        $v->delete();
                    }
                }
                
                $ad->delete();
                $message = 'Your ad is deleted';
            } else {
                $message = 'Ups something is wrong.';
            }
        } else {
            $message = 'Ups something is wrong.';
        }
        session()->flash('message', $message);
        return view('common.info_page');
    }
    
    public function axgetcarmodels(Request $request)
    {
    	$ret = array('code' => 400);
    	$car_brand_id = (int)$request->car_brand_id;
    	if(is_numeric($car_brand_id) && $car_brand_id > 0){
    		$car_models = CarModel::where('car_brand_id', $car_brand_id)->orderBy('car_model_name', 'asc')->get();
    		if(!$car_models->isEmpty()){
    			$info = array(0 => 'Select Car Model');
    			foreach ($car_models as $k => $v){
    				$info[$v->car_model_id] = $v->car_model_name;
    			}
    			if(!empty($info)){
    				$ret['code'] = 200;
    				$ret['info'] = $info;
    			}
    		} 	
    	}
    	echo json_encode($ret);	
    }
}
