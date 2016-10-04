<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Dc\Util;

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
use App\CarModification;
use App\AdPic;
use App\Category;
use App\Location;
use App\User;

use Validator;
use Cache;

class AdController extends Controller
{
    protected $ad;
    protected $category;
    protected $location;
    protected $user;

    public function __construct(Ad $_ad, Category $_category, Location $_location, User $_user)
    {
        $this->ad       = $_ad;
        $this->category = $_category;
        $this->location = $_location;
        $this->user     = $_user;
    }

    public function index(Request $request)
    {
        $params     = Input::all();
        $where      = [];
        $order      = ['ad_id' => 'desc'];
        $limit      = 0;
        $orderRaw   = '';
        $whereIn    = [];
        $whereRaw   = [];
        $paginate   = 2;
        $page       = 1;

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

        if(isset($params['ad_promo']) && is_numeric($params['ad_promo']) && ($params['ad_promo'] == 0 || $params['ad_promo'] == 1)){
            $where['ad_promo'] = ['=', $params['ad_promo']];
        }

        if(isset($params['ad_active']) && is_numeric($params['ad_active']) && ($params['ad_active'] == 0 || $params['ad_active'] == 1)){
            $where['ad_active'] = ['=', $params['ad_active']];
        }

        if(isset($params['ad_view']) && !empty($params['ad_view'])){
            $where['ad_view'] = ['=', $params['ad_view']];
        }

        if (isset($params['page']) && is_numeric($params['page'])) {
            $page = $params['page'];
        }

        $adList = $this->ad->getAdList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate, $page);
        return view('admin.ad.ad_list', ['adList' => $adList,
            'params' => $params,
            'yesnoselect' => ['_' => '', 0 => trans('admin_common.No'), 1 => trans('admin_common.Yes')]]);
    }

    public function edit(Request $request)
    {
        //get ad id
        $ad_id = $request->id;

        //get ad info
        $ad_detail = $this->ad->getAdDetail($ad_id, 0);
        $ad_detail->ad_price_type_1 = $ad_detail->ad_price_type_2 = $ad_detail->ad_price_type_3 = $ad_detail->ad_price;
        $ad_detail->condition_id_type_1 = $ad_detail->condition_id_type_3 = $ad_detail->condition_id;
        $ad_detail->ad_description = Util::br2nl($ad_detail->ad_description);

        //get ad pics
        $ad_pic = AdPic::where('ad_id', $ad_id)->get();

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

        $ad_detail->ad_category_info = $this->category->getParentsByIdFlat($ad_detail->category_id);
        $ad_detail->pics = AdPic::where('ad_id', $ad_detail->ad_id)->get();

        return view('admin.ad.ad_edit', [
            'ad_detail' => $ad_detail,
            'ad_pic' => $ad_pic,
            'c' => $this->category->getAllHierarhy(),
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
            'car_condition_id' => CarCondition::all(),
            'car_modification_id' => CarModification::all()
        ]);
    }

    public function save(Request $request)
    {
        $rules = [
            'ad_title' => 'required|max:255',
            'category_id' => 'required|integer|not_in:0',
            'ad_description' => 'required|min:50',
            'type_id' => 'required|integer|not_in:0',
            'location_id' => 'required|integer|not_in:0',
            'ad_puslisher_name' => 'required|string|max:255',
            'ad_email' => 'required|email|max:255'
        ];

        $validator = Validator::make($request->all(), $rules);

        /**
         * type 1 common ads validation
         */
        $validator->sometimes(['ad_price_type_1'], 'required|numeric|not_in:0', function($input){
            if($input->category_type == 1 && $input->price_radio == 1){
                return true;
            }
            return false;
        });
        $validator->sometimes(['condition_id_type_1'], 'required|integer|not_in:0', function($input){
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
        $validator->sometimes(['car_modification_id'], 'required|integer|not_in:0', function($input){
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
        $validator->sometimes(['condition_id_type_3'], 'required|integer|not_in:0', function($input){
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

        $ad_data = $request->all();

        //fill aditional fields
        $ad_data['ad_description'] = Util::nl2br(strip_tags($ad_data['ad_description']));
        if(!isset($ad_data['ad_active'])){
            $ad_data['ad_active'] = 0;
        } else {
            $ad_data['ad_active'] = 1;
        }
        if(!isset($ad_data['ad_promo'])){
            $ad_data['ad_promo'] = 0;
            $ad_data['ad_promo_until'] = NULL;
        } else {
            $ad_data['ad_promo'] = 1;
        }

        switch ($ad_data['category_type']){
            case 1:
                if($ad_data['price_radio'] == 1){
                    $ad_data['ad_price'] = $ad_data['ad_price_type_1'];
                    $ad_data['ad_free'] = 0;
                } else {
                    $ad_data['ad_price'] = 0;
                    $ad_data['ad_free'] = 1;
                }
                $ad_data['condition_id'] = $ad_data['condition_id_type_1'];
                break;
            case 2:
                $ad_data['ad_price'] = $ad_data['ad_price_type_2'];
                $ad_data['condition_id'] = $ad_data['condition_id_type_2'];
                break;
            case 3:
                $ad_data['ad_price'] = $ad_data['ad_price_type_3'];
                $ad_data['condition_id'] = $ad_data['condition_id_type_3'];
                break;
        }

        $ad_data['ad_description_hash'] = md5($ad_data['ad_description']);

        //save ad
        $ad = Ad::find($ad_data['ad_id']);
        $ad->update($ad_data);

        /**
         * clear cache, set message, redirect to list
         */
        Cache::flush();
        session()->flash('message', trans('admin_common.Ad saved'));
        return redirect(url('admin/ad'));
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
                }
            }
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.Ads deleted'));
            return redirect(url('admin/ad'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/ad'));
    }

    public function deletemainimg(Request $request)
    {
        $id = 0;

        if(isset($request->id)){
            $id = $request->id;
        }

        //delete
        if(!empty($id)){
            $ad = Ad::where('ad_id', $id)->first();
            if(!empty($ad)){
                //delete images
                if(!empty($ad->ad_pic)){
                    @unlink(public_path('uf/adata/') . '740_' . $ad->ad_pic);
                    @unlink(public_path('uf/adata/') . '1000_' . $ad->ad_pic);
                }
                $ad->ad_pic = '';
                $ad->save();
            }

            //clear cache, set message, redirect to list
            Cache::flush();
            return redirect(url('admin/ad/edit/' . $id));
        }

        return redirect(url('admin/ad/edit/' . $id));
    }

    public function deleteimg(Request $request)
    {
        $id = 0;
        $ad_id = 0;

        if(isset($request->id)){
            $id = $request->id;
        }

        if(isset($request->ad_id)){
            $ad_id = $request->ad_id;
        }

        //delete
        if(!empty($id) && !empty($ad_id)){

            $pic = AdPic::where('ad_id', $ad_id)->where('ad_pic_id', $id)->first();
            if($pic){
                @unlink(public_path('uf/adata/') . '740_' . $pic->ad_pic);
                @unlink(public_path('uf/adata/') . '1000_' . $pic->ad_pic);
                $pic->delete();
            }

            //clear cache, set message, redirect to list
            Cache::flush();
            return redirect(url('admin/ad/edit/' . $ad_id));
        }

        return redirect(url('admin/ad/edit/' . $ad_id));
    }
}
