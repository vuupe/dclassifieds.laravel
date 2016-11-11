<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
use App\CarModification;
use App\ClothesSize;
use App\ShoesSize;
use App\AdPic;
use App\User;
use App\UserMail;
use App\UserMailStatus;
use App\AdReport;
use App\AdFav;
use App\Pay;
use App\MagicKeywords;
use App\Wallet;

use Image;
use Validator;
use Mail;
use DB;
use Auth;
use Cookie;
use Cache;


class AdController extends Controller
{
    protected $category;
    protected $location;
    protected $ad;
    protected $user;
    protected $mail;

    public function __construct(Category $_category, Location $_location, Ad $_ad, User $_user, UserMail $_mail)
    {
        $this->category = $_category;
        $this->location = $_location;
        $this->ad = $_ad;
        $this->user = $_user;
        $this->mail = $_mail;
    }

    public function index(Request $request)
    {
        //is there selected location
        $lid = session()->get('lid', 0);

        //generate category url with location if selected
        $first_level_childs = $this->category->getOneLevel();
        if(!empty($first_level_childs)){
            foreach ($first_level_childs as $k => &$v){
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

        //get home page promo ads
        $where = ['ad_promo' => 1, 'ad_active' => 1];
        if($lid > 0){
            $where['ad.location_id'] = $lid;
        }
        $order = ['ad_publish_date' => 'desc'];
        $limit = config('dc.num_promo_ads_home_page');
        $promo_ad_list = $this->ad->getAdList($where, $order, $limit);

        if($promo_ad_list->count() < config('dc.num_promo_ads_home_page')){
            $where['ad_promo'] = 0;
            $limit = config('dc.num_promo_ads_home_page') - $promo_ad_list->count();
            $promo_ad_list = $promo_ad_list->merge($this->ad->getAdList($where, $order, $limit));
        }

        //if enable latest ads on home page get some new ads
        $latest_ad_list = new Collection();
        if(config('dc.enable_new_ads_on_homepage')){
            $where['ad_promo'] = 0;
            $limit = config('dc.num_latest_ads_home_page');
            $latest_ad_list = $this->ad->getAdList($where, $order, $limit);
        }

        /**
         * get ad count by category and selected filter
         */
        $all_location_childs = [];
        if($lid > 0) {
            $alc = $this->location->getAllHierarhyFlat($lid);
            if (!empty($alc)) {
                foreach ($alc as $ak => $av) {
                    $all_location_childs[] = $av['lid'];
                }
            }
            $all_location_childs[] = $lid;
        }
        if(!$first_level_childs->isEmpty()){
            unset($where['ad_promo']);
            if($lid > 0){
                $whereIn['ad.location_id'] = $all_location_childs;
            }

            foreach($first_level_childs as $k => &$v){

                $this_category_childs = [];
                //get this category childs
                $acc = $this->category->getAllHierarhyFlat($v->category_id);
                if(!empty($acc)){
                    foreach($acc as $ak => $av){
                        $this_category_childs[] = $av['cid'];
                    }
                }
                $this_category_childs[] = $v->category_id;
                $whereIn['category_id'] = $this_category_childs;
                $v->ad_count = $this->ad->getAdCount($where, $whereIn);
            }
        }

        /**
         * magic keywords
         */
        $magic_keywords = new Collection();
        if(config('dc.enable_magic_keywords')){
            $order = ['keyword_count' => 'DESC'];
            $limit = config('dc.num_magic_keywords_to_show');
            $mkModel = new MagicKeywords();
            $magic_keywords = $mkModel->getList($order, $limit);
        }

        return view('ad.home',[
            'c'                 => $this->category->getAllHierarhy(),
            'l'                 => $this->location->getAllHierarhy(),
            'first_level_childs'=> $first_level_childs,
            'lid'               => $lid,
            'promo_ad_list'     => $promo_ad_list,
            'latest_ad_list'    => $latest_ad_list,
            'magic_keywords'    => $magic_keywords
        ]);

    }
    
    public function proxy(Request $request)
    {
        //root url / base url
        $root = $request->root();

        //generated url if no parameters redirect to search
        $redirect_url = url('search');

        //generated url parameters container
        $url_params = array();

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

        //check if there are parameters for query string if other category selected do not add
        $query_string = '';
        if(session('old_cid') == $cid) {
            if (!empty($params)) {
                //clear token var if exist
                if (isset($params['_token'])) {
                    unset($params['_token']);
                }
                $query_string = Util::getQueryStringFromArray($params);
            }
        }

        //add query string to generated url
        if(!empty($query_string)){
            $redirect_url .= '?' . $query_string;
        }

        //save the selected category
        if($cid > 0){
            session(['old_cid' => $cid]);
        }

        return redirect($redirect_url);
    }
    
    public function search(Request $request)
    {
        //get incoming params
        $params = Input::all();

        //Flash the input for the current request to the session.
        $request->flash();

        //page title container
        $title = [config('dc.site_domain')];

        //check if there is car brand selected
        $car_model = array();
        if(old('car_brand_id')){
            if(is_numeric(old('car_brand_id')) && old('car_brand_id') > 0){

                $carModel   = new CarModel();
                $select     = ['car_model_id', 'car_model_name'];
                $where      = ['car_brand_id' => old('car_brand_id'), 'car_model_active' => 1];
                $order      = ['car_model_name' => 'asc'];
                $car_models = $carModel->getListSimple($select, $where, $order);

                if(!$car_models->isEmpty()){
                    $car_model = [0 => trans('search.Select Car Model')];
                    foreach ($car_models as $k => $v){
                        $car_model[$v->car_model_id] = $v->car_model_name;
                    }
                }
            }
        }

        //breadcrump container
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

        //if category selected get info, get childs and generate url and breadcrump
        $first_level_childs = new Collection();
        $all_category_childs = [];
        if($cid > 0){
            $params['cid'] = $cid;
            $selected_category_info = Category::where('category_id', $cid)->first();

            //get first childs info and generate links
            $first_level_childs = $this->category->getOneLevel($cid);
            foreach ($first_level_childs as $k => &$v){

                $category_url_params = [];
                $category_url_params[] = $this->category->getCategoryFullPathById($v->category_id);
                if(session()->has('location_slug')){
                    $category_url_params[] = 'l-' . session()->get('location_slug');
                }

                if(!empty($category_url_params)){
                    $v->category_url = Util::buildUrl($category_url_params);
                }
            }

            //generate breadcrump info
            $breadcrump_data = $this->category->getParentsByIdFlat($cid);
            if(!empty($breadcrump_data)){
                $category_title_array = [];
                foreach ($breadcrump_data as $k => &$v){

                    $category_url_params = [];
                    $category_url_params[] = $this->category->getCategoryFullPathById($v['category_id']);
                    if(session()->has('location_slug')){
                        $category_url_params[] = 'l-' . session()->get('location_slug');
                    }

                    if(!empty($category_url_params)){
                        $v['category_url'] = Util::buildUrl($category_url_params);
                    }

                    $category_title_array[] = $v['category_title'];
                }

                //category part of breadcrump
                $breadcrump['c'] = array_reverse($breadcrump_data);

                //category part of page title
                $title[] = join(' / ', array_reverse($category_title_array));
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
            $params['lid'] = $lid;

            //get info for title
            $location_info = $this->location->getLocationInfo($lid);
            if(!empty($location_info)){
                $title[] = $location_info->location_name;
            }
        }

        //if location selected get all child locations
        $all_location_childs = [];
        if($lid > 0) {
            $alc = $this->location->getAllHierarhyFlat($lid);
            if (!empty($alc)) {
                foreach ($alc as $ak => $av) {
                    $all_location_childs[] = $av['lid'];
                }
            }
            $all_location_childs[] = $lid;
        }

        //check for search text
        $search_text = '';
        $search_text_tmp = '';
        if(isset($request->search_text)){
            $search_text_tmp = Util::sanitize($request->search_text);
        }

        if(!empty($search_text_tmp) && mb_strlen($search_text_tmp, 'utf-8') > 3){
            $search_text = preg_replace('/-/', ' ', $search_text_tmp);
            $params['search_text'] = $search_text;
            $title[] = $search_text;
        }

        /*
         * init where vars
         */
        $where      = [];
        $order      = [];
        $limit      = 0;
        $orderRaw   = '';
        $whereIn    = [];
        $whereRaw   = [];
        $paginate   = 0;
        $page       = 1;

        /*
         * check common filters and set them in where array
         */
        if(isset($params['condition_id']) && !empty($params['condition_id']) && is_array($params['condition_id'])){
            $whereIn['condition_id'] = $params['condition_id'];
        }

        if(isset($params['type_id']) && !empty($params['type_id']) && is_array($params['type_id'])){
            $whereIn['type_id'] = $params['type_id'];
        }

        if(isset($params['price_from']) && is_numeric($params['price_from']) && $params['price_from'] > 0){
            $where['ad_price'] = ['>=', $params['price_from']];
        }

        if(isset($params['price_to']) && is_numeric($params['price_to']) && $params['price_to'] > 0){
            $where['ad_price'] = ['<=', $params['price_to']];
        }

        if(isset($params['price_free']) && is_numeric($params['price_free']) && $params['price_free'] > 0){
            $where['ad_free'] = ['=', 1];
        }

        //type 2 filters - real estates
        if(isset($params['estate_type_id']) && !empty($params['estate_type_id']) && is_array($params['estate_type_id'])){
            $whereIn['estate_type_id'] = $params['estate_type_id'];
        }

        if(isset($params['estate_sq_m_from']) && is_numeric($params['estate_sq_m_from']) && $params['estate_sq_m_from'] > 0){
            $where['estate_sq_m'] = ['>=', $params['estate_sq_m_from']];
        }

        if(isset($params['estate_sq_m_to']) && is_numeric($params['estate_sq_m_to']) && $params['estate_sq_m_to'] > 0){
            $where['estate_sq_m'] = ['<=', $params['estate_sq_m_to']];
        }

        if(isset($params['estate_year_from']) && is_numeric($params['estate_year_from']) && $params['estate_year_from'] > 0){
            $where['estate_year'] = ['>=', $params['estate_year_from']];
        }

        if(isset($params['estate_year_to']) && is_numeric($params['estate_year_to']) && $params['estate_year_to'] > 0){
            $where['estate_year'] = ['<=', $params['estate_year_to']];
        }

        if(isset($params['estate_construction_type_id']) && !empty($params['estate_construction_type_id']) && is_array($params['estate_construction_type_id'])){
            $whereIn['estate_construction_type_id'] = $params['estate_construction_type_id'];
        }

        if(isset($params['estate_heating_type_id']) && !empty($params['estate_heating_type_id']) && is_array($params['estate_heating_type_id'])){
            $whereIn['estate_heating_type_id'] = $params['estate_heating_type_id'];
        }

        if(isset($params['estate_floor_from']) && is_numeric($params['estate_floor_from']) && $params['estate_floor_from'] > 0){
            $where['estate_floor'] = ['>=', $params['estate_floor_from']];
        }

        if(isset($params['estate_floor_to']) && is_numeric($params['estate_floor_to']) && $params['estate_floor_to'] > 0){
            $where['estate_floor'] = ['<=', $params['estate_floor_to']];
        }

        if(isset($params['estate_num_floors_in_building']) && is_numeric($params['estate_num_floors_in_building']) && $params['estate_num_floors_in_building'] > 0){
            $where['estate_num_floors_in_building'] = $params['estate_num_floors_in_building'];
        }

        if(isset($params['estate_furnishing_type_id']) && !empty($params['estate_furnishing_type_id']) && is_array($params['estate_furnishing_type_id'])){
            $whereIn['estate_furnishing_type_id'] = $params['estate_furnishing_type_id'];
        }

        //type 3 filters - cars
        if(isset($params['car_engine_id']) && !empty($params['car_engine_id']) && is_array($params['car_engine_id'])){
            $whereIn['car_engine_id'] = $params['car_engine_id'];
        }

        if(isset($params['car_brand_id']) && is_numeric($params['car_brand_id']) && $params['car_brand_id'] > 0){
            $where['car_brand_id'] = $params['car_brand_id'];
        }

        if(isset($params['car_model_id']) && is_numeric($params['car_model_id']) && $params['car_model_id'] > 0){
            $where['car_model_id'] = $params['car_model_id'];
        }

        if(isset($params['car_transmission_id']) && !empty($params['car_transmission_id']) && is_array($params['car_transmission_id'])){
            $whereIn['car_transmission_id'] = $params['car_transmission_id'];
        }

        if(isset($params['car_modification_id']) && !empty($params['car_modification_id']) && is_array($params['car_modification_id'])){
            $whereIn['car_modification_id'] = $params['car_modification_id'];
        }

        if(isset($params['car_year_from']) && is_numeric($params['car_year_from']) && $params['car_year_from'] > 0){
            $where['car_year'] = ['>=', $params['car_year_from']];
        }

        if(isset($params['car_year_to']) && is_numeric($params['car_year_to']) && $params['car_year_to'] > 0){
            $where['car_year'] = ['<=', $params['car_year_to']];
        }

        if(isset($params['car_kilometeres_from']) && is_numeric($params['car_kilometeres_from']) && $params['car_kilometeres_from'] > 0){
            $where['car_kilometeres'] = ['>=', $params['car_kilometeres_from']];
        }

        if(isset($params['car_kilometeres_to']) && is_numeric($params['car_kilometeres_to']) && $params['car_kilometeres_to'] > 0){
            $where['car_kilometeres'] = ['<=', $params['car_kilometeres_to']];
        }

        if(isset($params['car_condition_id']) && !empty($params['car_condition_id']) && is_array($params['car_condition_id'])){
            $whereIn['car_condition_id'] = $params['car_condition_id'];
        }

        //type 5 filters - clothes
        if(isset($params['clothes_size_id']) && !empty($params['clothes_size_id']) && is_array($params['clothes_size_id'])){
            $whereIn['clothes_size_id'] = $params['clothes_size_id'];
        }

        //type 6 filters - shoes
        if(isset($params['shoes_size_id']) && !empty($params['shoes_size_id']) && is_array($params['shoes_size_id'])){
            $whereIn['shoes_size_id'] = $params['shoes_size_id'];
        }

        $show_only_promo = 0;
        if(isset($params['promo_ads']) && !empty($params['promo_ads'])){
            $where['ad_promo'] = 1;
            $show_only_promo = 1;
        }

        /*
         * get promo ads
         */
        $where['ad_promo'] = 1;
        $where['ad_active'] = 1;
        if($lid > 0){
            $whereIn['ad.location_id'] = $all_location_childs;
        }
        if($cid > 0){
            $whereIn['category_id'] = $all_category_childs;
        }
        if(!empty($search_text)){
            $whereRaw['match(ad_title, ad_description) against(?)'] = [$search_text];
        }
        $orderRaw = 'rand()';
        $limit = config('dc.num_promo_ads_list');
        $promo_ad_list = $this->ad->getAdList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate);

        /*
         * get normal ads
         */
        if(!$show_only_promo) {
            $where['ad_promo'] = 0;
        }
        $limit      = 0;
        $orderRaw   = '';
        $order      = ['ad_publish_date' => 'desc'];
        $paginate   = config('dc.num_ads_list');
        if (isset($params['page']) && is_numeric($params['page'])) {
            $page = $params['page'];
        }
        $title[] = trans('search.Page:') . ' ' . $page;

        $ad_list = $this->ad->getAdList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate, $page);

        /**
         * magic keywords
         */
        if(!empty($search_text) && config('dc.enable_magic_keywords')){
            unset($where['ad_promo']);
            $ad_count = $this->ad->getAdCount($where, $whereIn, $whereRaw);
            if($ad_count >= config('dc.minimum_results_to_save_magic_keyword')){
                $mkModel = new MagicKeywords();
                $mkCount = $mkModel->where('keyword', $search_text)->count();
                if($mkCount == 0){
                    $mkModel->keyword = $search_text;
                    $mkModel->save();
                } else {
                    $mkModel->where('keyword', $search_text)->increment('keyword_count', 1);
                }
            }
        }

        /**
         * get ad count by category and selected filter
         */
        if(!$first_level_childs->isEmpty()){
            unset($where['ad_promo']);

            foreach($first_level_childs as $k => &$v){

                $this_category_childs = [];
                //get this category childs
                $acc = $this->category->getAllHierarhyFlat($v->category_id);
                if(!empty($acc)){
                    foreach($acc as $ak => $av){
                        $this_category_childs[] = $av['cid'];
                    }
                }
                $this_category_childs[] = $v->category_id;
                $whereIn['category_id'] = $this_category_childs;
                $v->ad_count = $this->ad->getAdCount($where, $whereIn, $whereRaw);
            }
        }

        /**
         * put all view vars in array
         */
        $view_params = [
            'c'                 => $this->category->getAllHierarhy(), //all categories hierarhy
            'l'                 => $this->location->getAllHierarhy(), //all location hierarhy
            'params'            => $params, //incoming search params
            'cid'               => $cid, //selected category
            'lid'               => $lid, //selected location
            'search_text'       => $search_text, //search text
            'first_level_childs'=> $first_level_childs, //selected category one level childs
            'breadcrump'        => $breadcrump, //breadcrump data
            'promo_ad_list'     => $promo_ad_list, //promo ads
            'ad_list'           => $ad_list, //standard ads
            'show_only_promo'   => $show_only_promo, //show only promo ads
            'title'             => $title, //generated page title array

            //filter vars
            'at'                        => AdType::allCached('ad_type_name'),
            'ac'                        => AdCondition::allCached('ad_condition_name'),
            'estate_construction_type'  => EstateConstructionType::allCached('estate_construction_type_name'),
            'estate_furnishing_type'    => EstateFurnishingType::allCached('estate_furnishing_type_name'),
            'estate_heating_type'       => EstateHeatingType::allCached('estate_heating_type_name'),
            'estate_type'               => EstateType::allCached('estate_type_name'),
            'car_brand'                 => CarBrand::allCached('car_brand_name'),
            'car_model'                 => $car_model,
            'car_engine'                => CarEngine::allCached('car_engine_name'),
            'car_transmission'          => CarTransmission::allCached('car_transmission_name'),
            'car_condition'             => CarCondition::allCached('car_condition_name'),
            'car_modification'          => CarModification::allCached('car_modification_name'),
            'clothes_sizes'             => ClothesSize::allCached('clothes_size_ord'),
            'shoes_sizes'               => ShoesSize::allCached('shoes_size_ord')
        ];

        if($cid > 0){
            $view_params['selected_category_info'] = $selected_category_info;
        }

        return view('ad.search', $view_params);
    }
    
    public function detail(Request $request)
    {
        //get ad id
        $ad_id = $request->ad_id;
        
        //get ad info and increment num views
        $ad_detail = $this->ad->getAdDetail($ad_id);
        $ad_detail->increment('ad_view', 1);
        
        if(!empty($ad_detail->ad_video)){
            $ad_detail->ad_video_fixed = Util::getVideoReady($ad_detail->ad_video);
        }
        
        //get ad pics
        $adPicModel = new AdPic();
        $where = [];
        $order = [];
        $where['ad_id'] = $ad_id;
        $order['ad_pic_id'] = 'ASC';
        $ad_pic = $adPicModel->getAdPics($where, $order);
        
        //get this user other ads
        $where = [];
        $order = [];
        $where['ad_active'] = 1;
        $where['ad_id'] = ['!=', $ad_detail->ad_id];
        $order['ad_publish_date'] = 'desc';
        $limit = config('dc.num_addition_ads_from_user');
        $other_ads = $this->ad->getAdList($where, $order, $limit);
        
        //save ad for last view
        $last_view_ad = [
            'ad_id'         => $ad_detail->ad_id,
            'ad_title'      => $ad_detail->ad_title,
            'location_name' => $ad_detail->location_name,
            'ad_price'      => $ad_detail->ad_price,
            'ad_pic'        => $ad_detail->ad_pic,
            'ad_promo'      => $ad_detail->ad_promo
        ];

        if(session()->has('last_view')){
            $last_view_array = session('last_view');
            $add_to_last_view = 1;

            //check if this ad is in last view
            foreach($last_view_array as $k => $v){
                if($v['ad_id'] == $last_view_ad['ad_id']){
                    $add_to_last_view = 0;
                    break;
                }
            }

            if($add_to_last_view) {
                $last_view_array[] = $last_view_ad;
                if (count($last_view_array) > config('dc.num_last_viewed_ads')) {
                    //reindex the array
                    $last_view_array = array_values($last_view_array);
                    //remove oldest ad
                    unset($last_view_array[0]);
                }
                session()->put('last_view', $last_view_array);
            }
        } else {
            $last_view_array = [];
            $last_view_array[] = $last_view_ad;
            session()->put('last_view', $last_view_array);
        }

        //generate breadcrump
        $breadcrump = array();
        $breadcrump_data = $this->category->getParentsByIdFlat($ad_detail->category_id);
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
        
        //check if ad is in favorites
        $ad_fav = 0;
        $fav_ads_info = [];
        //is there user
        if(Auth::check()){
            $adFavModel = new AdFav();
            $fav_ads_info = $adFavModel->getFavAds($request->user()->user_id);
        } else if(Cookie::has('__' . md5(config('dc.site_domain')) . '_fav_ads')) {
            //no user check cookie
            $fav_ads_info = $request->cookie('__' . md5(config('dc.site_domain')) . '_fav_ads', array());
        }
        if(isset($fav_ads_info[$ad_id])){
            $ad_fav = 1;
        }

        //generate title
        $title = [config('dc.site_domain')];
        $title[] = $ad_detail->ad_title;
        $title[] = trans('detail.Ad Id') . ': ' . $ad_detail->ad_id;
        
        return view('ad.detail', [
            'ad_detail'     => $ad_detail,
            'ad_pic'        => $ad_pic,
            'other_ads'     => $other_ads,
            'breadcrump'    => $breadcrump,
            'ad_fav'        => $ad_fav,
            'title'         => $title
        ]);
    }
    
    public function getPublish()
    {
        $car_model = [];
        if(old('car_brand_id')){
            if(is_numeric(old('car_brand_id')) && old('car_brand_id') > 0){

                $carModel   = new CarModel();
                $select     = ['car_model_id', 'car_model_name'];
                $where      = ['car_brand_id' => old('car_brand_id'), 'car_model_active' => 1];
                $order      = ['car_model_name' => 'asc'];
                $car_models = $carModel->getListSimple($select, $where, $order);

                if(!$car_models->isEmpty()){
                    $car_model = [0 => trans('search.Select Car Model')];
                    foreach ($car_models as $k => $v){
                        $car_model[$v->car_model_id] = $v->car_model_name;
                    }
                }
            }
        }

        //get current user or make empty class
        $user = new \stdClass();
        if(Auth::check()){
            $user = Auth::user();
        }

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('publish_edit.Post an ad');

        //check if promo ads are enabled
        $payment_methods = new Collection();
        if(config('dc.enable_promo_ads')){
            $where['pay_active']    = 1;
            $order['pay_ord']       = 'ASC';
            $payModel               = new Pay();
            $payment_methods        = $payModel->getList($where, $order);
        }

        //check if promo ads are enabled, check if there is logged user
        //check if there are enough money in the wallet
        $enable_pay_from_wallet = 0;
        if(config('dc.enable_promo_ads') && Auth::check()){
            //no caching for the wallet :)
            $wallet_total = Wallet::where('user_id', Auth::user()->user_id)->sum('sum');
            if(number_format($wallet_total, 2, '.', '') >= number_format(config('dc.wallet_promo_ad_price'), 2, '.', '')){
                $enable_pay_from_wallet = 1;
            }
        }

        $first_level_childs = $this->category->getOneLevel();
        $location_first_level_childs = $this->location->getOneLevel();

        /**
         * put all view vars in array
         */
        $view_params = [
            'c'     => $this->category->getAllHierarhy(), //all categories hierarhy
            'l'     => $this->location->getAllHierarhy(), //all location hierarhy
            'user'  => $user, //user object or empty class,
            'title' => $title, //set the page title
            'payment_methods' => $payment_methods, //get payment methods
            'enable_pay_from_wallet' => $enable_pay_from_wallet, //enable/disable wallet promo ad pay
            'first_level_childs' => $first_level_childs, //first level categories
            'location_first_level_childs' => $location_first_level_childs, //first level locations

            //filter vars
            'at'                        => AdType::allCached('ad_type_name'),
            'ac'                        => AdCondition::allCached('ad_condition_name'),
            'estate_construction_type'  => EstateConstructionType::allCached('estate_construction_type_name'),
            'estate_furnishing_type'    => EstateFurnishingType::allCached('estate_furnishing_type_name'),
            'estate_heating_type'       => EstateHeatingType::allCached('estate_heating_type_name'),
            'estate_type'               => EstateType::allCached('estate_type_name'),
            'car_brand'                 => CarBrand::allCached('car_brand_name'),
            'car_model'                 => $car_model,
            'car_engine'                => CarEngine::allCached('car_engine_name'),
            'car_transmission'          => CarTransmission::allCached('car_transmission_name'),
            'car_condition'             => CarCondition::allCached('car_condition_name'),
            'car_modification'          => CarModification::allCached('car_modification_name'),
            'clothes_sizes'             => ClothesSize::allCached('clothes_size_ord'),
            'shoes_sizes'               => ShoesSize::allCached('shoes_size_ord')
        ];
        
        return view('ad.publish', $view_params);
    }
    
    public function postPublish(Request $request)
    {
        //common validation rules
        $rules = [
            'ad_title'          => 'required|max:255',
            'category_id'       => 'required|integer|not_in:0',
            'ad_description'    => 'required|min:' . config('dc.ad_description_min_lenght'),
            'type_id'           => 'required|integer|not_in:0',
            'ad_image.*'        => 'mimes:jpeg,bmp,png|max:' . config('dc.ad_image_max_size'),
            'location_id'       => 'required|integer|not_in:0',
            'ad_puslisher_name' => 'required|string|max:255',
            'ad_email'          => 'required|email|max:255',
            'policy_agree'      => 'required',
        ];

        if(config('dc.require_ad_image')){
            $rules['ad_image'] = 'require_one_of_array';
        }

        if(config('dc.enable_recaptcha_publish')){
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        $messages = [
            'require_one_of_array' => trans('publish_edit.You need to upload at least one ad pic.'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        /**
         * type 1 common ads validation
         */
        $validator->sometimes(['ad_price_type_1'], 'required|numeric|not_in:0', function($input){
            if(($input->category_type == 1 && $input->price_radio == 1) || ($input->category_type == 1 && !isset($input->price_radio))){
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

        /**
         * type 4 services validation
         */
        $validator->sometimes(['ad_price_type_4'], 'required|numeric|not_in:0', function($input){
            if(($input->category_type == 4 && $input->price_radio_type_4 == 1) || ($input->category_type == 4 && !isset($input->price_radio_type_4))){
                return true;
            }
            return false;
        });

        /**
         * type 5 clothes validation
         */
        $validator->sometimes(['ad_price_type_5'], 'required|numeric|not_in:0', function($input){
            if(($input->category_type == 5 && $input->price_radio_type_5 == 1) || ($input->category_type == 5 && !isset($input->price_radio_type_5))){
                return true;
            }
            return false;
        });
        $validator->sometimes(['clothes_size_id'], 'required|integer|not_in:0', function($input){
            return $input->category_type == 5 ? 1 : 0;
        });

        /**
         * type 6 shoes validation
         */
        $validator->sometimes(['ad_price_type_6'], 'required|numeric|not_in:0', function($input){
            if(($input->category_type == 6 && $input->price_radio_type_6 == 1) || ($input->category_type == 6 && !isset($input->price_radio_type_6))){
                return true;
            }
            return false;
        });
        $validator->sometimes(['shoes_size_id'], 'required|integer|not_in:0', function($input){
            return $input->category_type == 6 ? 1 : 0;
        });

        /**
         * type 7 real estate land validation
         */
        $validator->sometimes(['ad_price_type_7'], 'required|numeric|not_in:0', function($input){
            if($input->category_type == 7){
                return true;
            }
            return false;
        });
        $validator->sometimes(['estate_sq_m_type_7'], 'required|numeric|not_in:0', function($input){
            return $input->category_type == 7 ? 1 : 0;
        });

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        $ad_data = $request->all();

        //get user info by ad email or create new user
        $current_user_id = 0;
        if(Auth::check()){
            $current_user_id = Auth::user()->user_id;
            $user = Auth::user();
        } else {
            //check this mail for registered user
            try{
                $user = User::where('email', $ad_data['ad_email'])->firstOrFail();
            } catch (\Exception $e) {
                //no user create one
                //generate password
                $password = str_random(10);

                $user                   = new User();
                $user->name             = $ad_data['ad_puslisher_name'];
                $user->email            = $ad_data['ad_email'];
                $user->user_phone       = $ad_data['ad_phone'];
                $user->user_skype       = $ad_data['ad_skype'];
                $user->user_site        = $ad_data['ad_link'];
                $user->user_location_id = $ad_data['location_id'];
                $user->user_address     = $ad_data['ad_address'];
                $user->user_lat_lng     = $ad_data['ad_lat_lng'];
                $user->password         = bcrypt($password);
                $user->user_activation_token = str_random(30);
                $user->save();

                //send activation mail
                Mail::send('emails.activation', ['user' => $user, 'password' => $password], function ($m) use ($user) {
                    $m->from(config('dc.site_contact_mail'), config('dc.site_domain'));
                    $m->to($user->email)->subject(trans('publish_edit.Activate your account!'));
                });
            }
            $current_user_id = $user->user_id;
        }

        //fill additional fields
        $ad_data['user_id']             = $current_user_id;
        $ad_data['ad_publish_date']     = date('Y-m-d H:i:s');
        $ad_data['ad_valid_until']      = date('Y-m-d', mktime(null, null, null, date('m'), date('d')+config('dc.ad_valid_period_in_days'), date('Y')));
        $ad_data['ad_ip']               = Util::getRemoteAddress();
        $ad_data['ad_description']      = Util::nl2br(strip_tags($ad_data['ad_description']));

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
            case 4:
                if($ad_data['price_radio_type_4'] == 1){
                    $ad_data['ad_price'] = $ad_data['ad_price_type_4'];
                    $ad_data['ad_free'] = 0;
                } else {
                    $ad_data['ad_price'] = 0;
                    $ad_data['ad_free'] = 1;
                }
                break;
            case 5:
                if($ad_data['price_radio_type_5'] == 1){
                    $ad_data['ad_price'] = $ad_data['ad_price_type_5'];
                    $ad_data['ad_free'] = 0;
                } else {
                    $ad_data['ad_price'] = 0;
                    $ad_data['ad_free'] = 1;
                }
                break;
            case 6:
                if($ad_data['price_radio_type_6'] == 1){
                    $ad_data['ad_price'] = $ad_data['ad_price_type_6'];
                    $ad_data['ad_free'] = 0;
                } else {
                    $ad_data['ad_price'] = 0;
                    $ad_data['ad_free'] = 1;
                }
                break;
            case 7:
                $ad_data['ad_price'] = $ad_data['ad_price_type_7'];
                $ad_data['estate_sq_m'] = $ad_data['estate_sq_m_type_7'];
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

                $img    = Image::make($destination_path . $file_name);
                $width  = $img->width();
                $height = $img->height();

                if($width > 1000 || $height > 1000) {
                    if ($width == $height) {
                        $img->resize(1000, 1000);
                        if(config('dc.watermark')){
                            $img->insert(public_path('uf/settings/') . config('dc.watermark'), config('dc.watermark_position'));
                        }
                        $img->save($destination_path . '1000_' . $file_name);
                    } elseif ($width > $height) {
                        $img->resize(1000, null, function($constraint){
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        if(config('dc.watermark')){
                            $img->insert(public_path('uf/settings/') . config('dc.watermark'), config('dc.watermark_position'));
                        }
                        $img->save($destination_path . '1000_' . $file_name);
                    } elseif ($width < $height) {
                        $img->resize(null, 1000, function($constraint){
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        if(config('dc.watermark')){
                            $img->insert(public_path('uf/settings/') . config('dc.watermark'), config('dc.watermark_position'));
                        }
                        $img->save($destination_path . '1000_' . $file_name);
                    }
                } else {
                    if(config('dc.watermark')){
                        $img->insert(public_path('uf/settings/') . config('dc.watermark'), config('dc.watermark_position'));
                        $img->save($destination_path . '1000_' . $file_name);
                    } else {
                        $img->save($destination_path . '1000_' . $file_name);
                    }
                }

                if(!$first_image_uploaded){
                    if($width >= 720 || $height >= 720) {
                        $img->fit(720, 720);
                        $img->save($destination_path . '740_' . $file_name);
                    } else {
                        $img->resizeCanvas(720, 720, 'top');
                        $img->save($destination_path . '740_' . $file_name);
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

        $ad->ad_category_info   = $this->category->getParentsByIdFlat($ad->category_id);
        $ad->ad_location_info   = $this->location->getParentsByIdFlat($ad->location_id);
        $ad->pics               = AdPic::where('ad_id', $ad->ad_id)->get();
        $ad->same_ads           = Ad::where([['ad_description_hash', $ad->ad_description_hash], ['ad_id', '<>', $ad->ad_id]])->get();

        //send info and activation mail
        Mail::send('emails.ad_activation', ['user' => $user, 'ad' => $ad], function ($m) use ($user){
            $m->from(config('dc.site_contact_mail'), config('dc.site_domain'));
            $m->to($user->email)->subject(trans('publish_edit.Activate your ad!'));
        });

        //send control mail
        if(config('dc.enable_control_mails')) {
            Mail::send('emails.control_ad_activation', ['user' => $user, 'ad' => $ad], function ($m) {
                $m->from(config('dc.site_contact_mail'), config('dc.site_domain'));
                $m->to(config('dc.control_mail'))->subject(config('dc.control_mail_subject'));
            });
        }

        //if promo ads are enable check witch option is selected
        if(isset($ad_data['ad_type_pay'])){

            //wallet pay
            if($ad_data['ad_type_pay'] == 1000){
                //no caching for the wallet :)
                $wallet_total = Wallet::where('user_id', Auth::user()->user_id)->sum('sum');
                if(number_format($wallet_total, 2, '.', '') >= number_format(config('dc.wallet_promo_ad_price'), 2, '.', '')){
                    //calc promo period
                    $promoUntilDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+config('dc.wallet_promo_ad_period'), date('Y')));

                    //unset some ad fields
                    unset($ad->ad_category_info);
                    unset($ad->ad_location_info);
                    unset($ad->pics);
                    unset($ad->same_ads);

                    //make ad promo and activate it
                    $ad->ad_promo = 1;
                    $ad->ad_promo_until = $promoUntilDate;
                    $ad->ad_active = 1;
                    $ad->save();

                    //subtract money from wallet
                    $wallet_data = ['user_id' => $ad->user_id,
                        'ad_id' => $ad->ad_id,
                        'sum' => -number_format(config('dc.wallet_promo_ad_price'), 2, '.', ''),
                        'wallet_date' => date('Y-m-d H:i:s'),
                        'wallet_description' => trans('payment_fortumo.Your ad #:ad_id is Promo Until :date.', ['ad_id' => $ad->ad_id, 'date' => $promoUntilDate])
                    ];
                    Wallet::create($wallet_data);
                    Cache::flush();

                    $message[] = trans('payment_fortumo.Your ad #:ad_id is Promo Until :date.', ['ad_id' => $ad->ad_id, 'date' => $promoUntilDate]);
                    $message[] = trans('publish_edit.Your ad is activated');
                    $message[] = trans('publish_edit.Click here to publish new ad', ['link' => route('publish')]);
                }
            } else {
                $where['pay_active'] = 1;
                $order['pay_ord'] = 'ASC';
                $payModel = new Pay();
                $payment_methods = $payModel->getList($where, $order);
                if (!$payment_methods->isEmpty()) {
                    foreach ($payment_methods as $k => $v) {
                        if($v->pay_id == $ad_data['ad_type_pay']){
                            if(empty($v->pay_page_name)){
                                $message[] = trans('publish_edit.Your ad will be activated automatically when you pay.');
                                $message[] = trans('publish_edit.Send sms and make your ad promo', [
                                    'number' => $v->pay_number,
                                    'text' => $v->pay_sms_prefix . ' a' . $ad->ad_id,
                                    'period' => $v->pay_promo_period,
                                    'sum' => number_format($v->pay_sum, 2, '.', ''),
                                    'cur' => config('dc.site_price_sign')
                                ]);
                            } else {
                                $message[] = trans('publish_edit.Your ad will be activated automatically when you pay.');
                                $message[] = trans('publish_edit.Click the button to pay for promo', [
                                    'pay' => $v->pay_name,
                                    'period' => $v->pay_promo_period,
                                    'sum' => number_format($v->pay_sum, 2, '.', ''),
                                    'cur' => config('dc.site_price_sign')
                                ]);
                                session()->flash('message', $message);
                                return redirect(url($v->pay_page_name . '/a' . $ad->ad_id));
                            }
                        }
                    }
                }
            }
        }

        if(!isset($message) || empty($message)){
            $message[] = trans('publish_edit.Your ad is in moderation mode, please activate it.');
            $message[] = trans('publish_edit.If you dont receive mail from us, please check your spam folder or contact us.');
            $message[] = trans('publish_edit.Click here to publish new ad', ['link' => route('publish')]);
        }

        //set flash message and go to info page
        session()->flash('message', $message);
        return redirect(route('info'));
    }
    
    public function activate(Request $request)
    {
        $code = $request->token;
        if(!empty($code)){
            $ad = Ad::where('code', $code)->first();
            if(!empty($ad)){

                $message[] = trans('publish_edit.Your ad is active now');

                //if enabled add bonus to wallet
                if(config('dc.enable_bonus_on_ad_activation') && $ad->bonus_added == 0 && config('dc.bonus_sum_on_ad_activation') > 0){
                    //add money to wallet
                    $wallet_data = ['user_id' => $ad->user_id,
                        'ad_id' => $ad->ad_id,
                        'sum' => config('dc.bonus_sum_on_ad_activation'),
                        'wallet_date' => date('Y-m-d H:i:s'),
                        'wallet_description' => trans('publish_edit.Ad Activation Bonus')
                    ];
                    Wallet::create($wallet_data);
                    $ad->bonus_added = 1;
                    $message[] = trans('publish_edit.We have added to your wallet for ad activation.', ['sum' => config('dc.bonus_sum_on_ad_activation'), 'sign' => config('dc.site_price_sign')]);
                }

                $ad->ad_active = 1;
                $ad->save();

                Cache::flush();
            }
        }

        if(!isset($message) || empty($message)){
            $message = trans('publish_edit.Ups something is wrong. Please contact us.');
        }

        $message[] = trans('publish_edit.Click here to publish new ad', ['link' => route('publish')]);

        session()->flash('message', $message);
        return redirect(route('info'));
    }
    
    public function delete(Request $request)
    {
        $code = $request->token;
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
                $message[] = trans('publish_edit.Your ad is deleted');
            }
        }

        if(!isset($message) || empty($message)){
            $message[] = trans('publish_edit.Ups something is wrong. Please contact us.');
        }
        $message[] = trans('publish_edit.Click here to publish new ad', ['link' => route('publish')]);

        session()->flash('message', $message);
        return redirect(route('info'));
    }
    
    public function getAdContact(Request $request)
    {
        //get ad id
        $ad_id = $request->ad_id;
        
        //get ad info
        $ad_detail = $this->ad->getAdDetail($ad_id);

        //generate breadcrump
        $breadcrump = [];
        $breadcrump_data = $this->category->getParentsByIdFlat($ad_detail->category_id);
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

        //generate title
        $title      = [config('dc.site_domain')];
        $title[]    = $ad_detail->ad_title;
        $title[]    = trans('detail.Ad Id') . ': ' . $ad_detail->ad_id;
        $title[]    = trans('contact.Send Message');
        
        return view('ad.contact', ['ad_detail' => $ad_detail, 'breadcrump' => $breadcrump, 'title' => $title]);
    }
    
    public function postAdContact(Request $request)
    {
        //get ad id
        $ad_id = $request->ad_id;
    
        //get ad info
        $ad_detail = Ad::where('ad_active', 1)->findOrFail($ad_id);
        
        //validate form
        $rules = [
            'contact_message' => 'required|min:' . config('dc.ad_contact_min_words')
        ];

        if(config('dc.enable_recaptcha_ad_contact')){
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }
         
        $validator = Validator::make($request->all(), $rules);
        $validator->sometimes(['contact_name'], 'required|string|max:255', function($request){
            if(Auth::check()){
                return false;
            }
            return true;
        });
        $validator->sometimes(['contact_mail'], 'required|email|max:255', function($request){
            if(Auth::check()){
                return false;
            }
            return true;
        });
        
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        $current_user_id = 0;
        if(Auth::check()){
            $current_user_id = $request->user()->user_id;    
        } else {
            //check this mail for registered user
            try{
                $user = User::where('email', $request->contact_mail)->firstOrFail();
            } catch (\Exception $e) { 
                //no user create one
                //generate password
                $password = str_random(10);
                $user = new User();
                $user->name = $request->contact_name;
                $user->email = $request->contact_mail;
                $user->password = bcrypt($password);
                $user->user_activation_token = str_random(30);
                $user->save();
                
                //send activation mail
                Mail::send('emails.activation', ['user' => $user, 'password' => $password], function ($m) use ($user) {
                    $m->from(config('dc.site_contact_mail'), config('dc.site_domain'));
                    $m->to($user->email)->subject(trans('publish_edit.Activate your account!'));
                });
            }
            $current_user_id = $user->user_id;
        }
        
        //if user save message
        if($current_user_id > 0){
            //save in db and send mail
            $this->mail->saveMailToDbAndSendMail($current_user_id, $ad_detail->user_id, $ad_id, $request->contact_message, $ad_detail->ad_email);
            
            //set flash message and return
            session()->flash('message', trans('contact.Your message was send.'));
        } else {
            //set error flash message and return
            session()->flash('message', trans('contact.Ups something is wrong, please try again later or contact our team.'));
        }
        return redirect()->back();
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

    public function axgetcategory(Request $request)
    {
        $ret = array('code' => 400);
        $category_id = (int)$request->category_id;
        if(is_numeric($category_id)){
            if($category_id == 0) {
                $first_level_childs = $this->category->getOneLevel();
            } else {
                $first_level_childs = $this->category->getOneLevel($category_id);
                $breadcrump_data = $this->category->getParentsByIdFlat($category_id);
            }
            if(!$first_level_childs->isEmpty()){
                foreach ($first_level_childs as $k => $v){
                    $info[$v->category_id] = $v->category_title;
                }
                if(!empty($breadcrump_data)){
                    foreach($breadcrump_data as $k => $v){
                        $binfo[$v['category_id']] = $v['category_title'];
                    }

                }
                if(!empty($info)){
                    if(empty($binfo)){
                        $binfo = [];
                    }
                    $ret['code'] = 200;
                    $ret['info'] = $info;
                    $ret['binfo'] = $binfo;
                }
            } else {
                $ret['code'] = 300;
                $ret['info'] = $category_id;
            }
        }
        echo json_encode($ret);
    }

    public function axgetlocation(Request $request)
    {
        $ret = array('code' => 400);
        $location_id = (int)$request->location_id;
        if(is_numeric($location_id)){
            if($location_id == 0) {
                $first_level_childs = $this->location->getOneLevel();
            } else {
                $first_level_childs = $this->location->getOneLevel($location_id);
                $breadcrump_data = $this->location->getParentsByIdFlat($location_id);
            }
            if(!$first_level_childs->isEmpty()){
                foreach ($first_level_childs as $k => $v){
                    $info[$v->location_id] = $v->location_name;
                }
                if(!empty($breadcrump_data)){
                    foreach($breadcrump_data as $k => $v){
                        $binfo[$v['location_id']] = $v['location_name'];
                    }

                }
                if(!empty($info)){
                    if(empty($binfo)){
                        $binfo = [];
                    }
                    $ret['code'] = 200;
                    $ret['info'] = $info;
                    $ret['binfo'] = $binfo;
                }
            } else {
                $ret['code'] = 300;
                $ret['info'] = $location_id;
            }
        }
        echo json_encode($ret);
    }
    
    public function axreportad(Request $request)
    {
        $ret = array('code' => 400);
        parse_str($request->form_data, $form_data);
        if(isset($form_data['report_ad_id']) && is_numeric($form_data['report_ad_id']) && isset($form_data['report_radio']) && is_numeric($form_data['report_radio'])){
            $ad_report = new AdReport();
            $ad_report->report_ad_id = $form_data['report_ad_id'];
            $ad_report->report_type_id = $form_data['report_radio'];
            $ad_report->report_info = nl2br($form_data['report_more_info']);
            $ad_report->report_date = date('Y-m-d H:i:s');
            if(Auth::check()){
                $ad_report->report_user_id = $request->user()->user_id;
            }
            try{
                $ad_report->save();
                $ret['code'] = 200;
                $ret['message'] = trans('publish_edit.Thanks, The report is send.');
            } catch (\Exception $e){
                $ret['message'] = trans('publish_edit.Ups, something is wrong, please try again.');
            }
        } else {
            $ret['message'] = trans('publish_edit.Ups, something is wrong, please try again.');
        }
        echo json_encode($ret);
    }
    
    public function axsavetofav(Request $request)
    {
        $ret = array('code' => 400);
        $ad_id = $request->ad_id;
        
        if(isset($ad_id) && is_numeric($ad_id)){
            $fav_ads_info = $request->cookie('__' . md5(config('dc.site_domain')) . '_fav_ads', array());
            if(Auth::check()){
                //registered user save/remove to/from db
                $adFavModel = new AdFav();
                $user_id = $request->user()->user_id;
                $fav_ads_db = $adFavModel->getFavAds($user_id);
                if(isset($fav_ads_db[$ad_id])){
                    //remove from db
                    $adFavModel->where('ad_id', $ad_id)->where('user_id', $user_id)->delete();
                    $ret['code'] = 201;
                } else {
                    //remove all favs from db for this user
                    $adFavModel->where('user_id', $user_id)->delete();
                    
                    $fav_ads_info[$ad_id] = $ad_id;
                    $fav_to_save = array_replace($fav_ads_info, $fav_ads_db);
                    
                    //save to db, if there is cookie info save it too
                    foreach ($fav_to_save as $k){
                        $adFavModel = new AdFav();
                        $adFavModel->ad_id = $k;
                        $adFavModel->user_id = $user_id;
                        $adFavModel->save();
                    }
                    $ret['code'] = 200;
                }
                
                //remove cookie, data is saved to db
                $fav_ads_info = array();
            } else {
                //not registered user save/remove ad to/from cookie
                if(isset($fav_ads_info[$ad_id])){
                    unset($fav_ads_info[$ad_id]);
                    $ret['code'] = 201;
                } else {
                    $fav_ads_info[$ad_id] = $ad_id;
                    $ret['code'] = 200;
                }
            }
            $cookie = Cookie::forever('__' . md5(config('dc.site_domain')) . '_fav_ads', $fav_ads_info);
            Cookie::queue($cookie);
        }
        
        return response()->json($ret);
    }
    
    public function myads(Request $request)
    {
        $params     = $request->all();
        $limit      = 0;
        $orderRaw   = '';
        $whereIn    = [];
        $whereRaw   = [];
        $page       = 1;
        $paginate   = config('dc.num_ads_on_myads');
        if (isset($params['page']) && is_numeric($params['page'])) {
            $page = $params['page'];
        }

        $where = ['user_id' => Auth::user()->user_id];
        $order = ['ad_publish_date' => 'desc'];
        $my_ad_list = $this->ad->getAdList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate, $page);

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('myads.My Classifieds');
        $title[] = trans('myads.Page:') . ' ' . $page;

        return view('ad.myads', ['my_ad_list' => $my_ad_list, 'title' => $title, 'params' => $params]);
    }
    
    public function republish(Request $request)
    {
        $code = $request->token;
        if(!empty($code)){
            $ad = Ad::where('code', $code)->first();
            if(!empty($ad)){
                $ad->ad_publish_date = date('Y-m-d H:i:s');
                $ad->ad_valid_until = date('Y-m-d', mktime(null, null, null, date('m'), date('d')+config('dc.ad_valid_period_in_days'), date('Y')));
                $ad->expire_warning_mail_send = 0;
                $ad->save();
                Cache::flush();
            } 
        }
        return redirect(url('myads'));
    }
    
    public function getAdEdit(Request $request)
    {
        //get ad id
        $ad_id = $request->ad_id;
    
        //get ad info
        $ad_detail = $this->ad->getAdDetail($ad_id, 0);
        
        if($ad_detail->user_id != Auth::user()->user_id){
            return redirect(route('myads'));
        }
        
        $ad_detail->ad_price_type_1     = $ad_detail->ad_price_type_2 = $ad_detail->ad_price_type_3 = $ad_detail->ad_price_type_4 = $ad_detail->ad_price;
        $ad_detail->ad_price_type_5     = $ad_detail->ad_price_type_6 = $ad_detail->ad_price_type_7 = $ad_detail->ad_price;

        if($ad_detail->ad_price > 0){
            $ad_detail->price_radio = $ad_detail->price_radio_type_4 = $ad_detail->price_radio_type_5 = $ad_detail->price_radio_type_6 = 1;
        } elseif ($ad_detail->ad_free){
            $ad_detail->price_radio = $ad_detail->price_radio_type_4 = $ad_detail->price_radio_type_5 = $ad_detail->price_radio_type_6 = 2;
        }

        $ad_detail->condition_id_type_1 = $ad_detail->condition_id_type_3 = $ad_detail->condition_id;
        $ad_detail->estate_sq_m_type_7  = $ad_detail->estate_sq_m;
        $ad_detail->ad_description      = Util::br2nl($ad_detail->ad_description);
        
        //get ad pics
        $ad_pic = AdPic::where('ad_id', $ad_id)->get();
        
        $car_model = [];
        if(old('car_brand_id')){
            if(is_numeric(old('car_brand_id')) && old('car_brand_id') > 0){

                $carModel   = new CarModel();
                $select     = ['car_model_id', 'car_model_name'];
                $where      = ['car_brand_id' => old('car_brand_id'), 'car_model_active' => 1];
                $order      = ['car_model_name' => 'asc'];
                $car_models = $carModel->getListSimple($select, $where, $order);

                if(!$car_models->isEmpty()){
                    $car_model = [0 => trans('search.Select Car Model')];
                    foreach ($car_models as $k => $v){
                        $car_model[$v->car_model_id] = $v->car_model_name;
                    }
                }
            }
        }
        
        $ad_detail->ad_category_info = $this->category->getParentsByIdFlat($ad_detail->category_id);

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('publish_edit.Edit Ad');

        $location_first_level_childs = $this->location->getOneLevel();
        
        return view('ad.edit', [
            'c'     => $this->category->getAllHierarhy(), //all categories hierarhy
            'l'     => $this->location->getAllHierarhy(), //all location hierarhy
            'ad_detail' => $ad_detail,
            'ad_pic'    => $ad_pic,
            'title'     => $title,
            'location_first_level_childs' => $location_first_level_childs,

            //filter vars
            'at'                        => AdType::allCached('ad_type_name'),
            'ac'                        => AdCondition::allCached('ad_condition_name'),
            'estate_construction_type'  => EstateConstructionType::allCached('estate_construction_type_name'),
            'estate_furnishing_type'    => EstateFurnishingType::allCached('estate_furnishing_type_name'),
            'estate_heating_type'       => EstateHeatingType::allCached('estate_heating_type_name'),
            'estate_type'               => EstateType::allCached('estate_type_name'),
            'car_brand'                 => CarBrand::allCached('car_brand_name'),
            'car_model'                 => $car_model,
            'car_engine'                => CarEngine::allCached('car_engine_name'),
            'car_transmission'          => CarTransmission::allCached('car_transmission_name'),
            'car_condition'             => CarCondition::allCached('car_condition_name'),
            'car_modification'          => CarModification::allCached('car_modification_name'),
            'clothes_sizes'             => ClothesSize::allCached('clothes_size_ord'),
            'shoes_sizes'               => ShoesSize::allCached('shoes_size_ord')
        ]);
    }
    
    public function postAdEdit(Request $request)
    {
        //common validation rules
        $rules = [
            'ad_title'          => 'required|max:255',
            'category_id'       => 'required|integer|not_in:0',
            'ad_description'    => 'required|min:' . config('dc.ad_description_min_lenght'),
            'type_id'           => 'required|integer|not_in:0',
            'ad_image.*'        => 'mimes:jpeg,bmp,png|max:' . config('dc.ad_image_max_size'),
            'location_id'       => 'required|integer|not_in:0',
            'ad_puslisher_name' => 'required|string|max:255',
            'ad_email'          => 'required|email|max:255',
            'policy_agree'      => 'required',
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

        /**
         * type 4 services validation
         */
        $validator->sometimes(['ad_price_type_4'], 'required|numeric|not_in:0', function($input){
            if(($input->category_type == 4 && $input->price_radio_type_4 == 1) || ($input->category_type == 4 && !isset($input->price_radio_type_4))){
                return true;
            }
            return false;
        });

        /**
         * type 5 clothes validation
         */
        $validator->sometimes(['ad_price_type_5'], 'required|numeric|not_in:0', function($input){
            if(($input->category_type == 5 && $input->price_radio_type_5 == 1) || ($input->category_type == 5 && !isset($input->price_radio_type_5))){
                return true;
            }
            return false;
        });
        $validator->sometimes(['clothes_size_id'], 'required|integer|not_in:0', function($input){
            return $input->category_type == 5 ? 1 : 0;
        });

        /**
         * type 6 shoes validation
         */
        $validator->sometimes(['ad_price_type_6'], 'required|numeric|not_in:0', function($input){
            if(($input->category_type == 6 && $input->price_radio_type_6 == 1) || ($input->category_type == 6 && !isset($input->price_radio_type_6))){
                return true;
            }
            return false;
        });
        $validator->sometimes(['shoes_size_id'], 'required|integer|not_in:0', function($input){
            return $input->category_type == 6 ? 1 : 0;
        });

        /**
         * type 7 real estate land validation
         */
        $validator->sometimes(['ad_price_type_7'], 'required|numeric|not_in:0', function($input){
            if($input->category_type == 7){
                return true;
            }
            return false;
        });
        $validator->sometimes(['estate_sq_m_type_7'], 'required|numeric|not_in:0', function($input){
            return $input->category_type == 7 ? 1 : 0;
        });
                     
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $ad_data = $request->all();
         
        //fill additional fields
        $ad_data['user_id']         = Auth::user()->user_id;
        $ad_data['ad_publish_date'] = date('Y-m-d H:i:s');
        $ad_data['ad_valid_until']  = date('Y-m-d', mktime(null, null, null, date('m'), date('d')+config('dc.ad_valid_period_in_days'), date('Y')));
        $ad_data['expire_warning_mail_send'] = 0;
        $ad_data['ad_ip']           = Util::getRemoteAddress();
        $ad_data['ad_description']  = Util::nl2br(strip_tags($ad_data['ad_description']));
         
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
            case 4:
                if($ad_data['price_radio_type_4'] == 1){
                    $ad_data['ad_price'] = $ad_data['ad_price_type_4'];
                    $ad_data['ad_free'] = 0;
                } else {
                    $ad_data['ad_price'] = 0;
                    $ad_data['ad_free'] = 1;
                }
                break;
            case 5:
                if($ad_data['price_radio_type_5'] == 1){
                    $ad_data['ad_price'] = $ad_data['ad_price_type_5'];
                    $ad_data['ad_free'] = 0;
                } else {
                    $ad_data['ad_price'] = 0;
                    $ad_data['ad_free'] = 1;
                }
                break;
            case 6:
                if($ad_data['price_radio_type_6'] == 1){
                    $ad_data['ad_price'] = $ad_data['ad_price_type_6'];
                    $ad_data['ad_free'] = 0;
                } else {
                    $ad_data['ad_price'] = 0;
                    $ad_data['ad_free'] = 1;
                }
                break;
            case 7:
                $ad_data['ad_price'] = $ad_data['ad_price_type_7'];
                $ad_data['estate_sq_m'] = $ad_data['estate_sq_m_type_7'];
                break;
        }
         
        $ad_data['ad_description_hash'] = md5($ad_data['ad_description']);

        //save ad
        $ad = Ad::find($ad_data['ad_id']);
        $ad->update($ad_data);
         
        //upload and fix ad images
        $ad_image = Input::file('ad_image');
        if(!empty(array_filter($ad_image))){
            
            //delete current image
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
            
            //save new images
            $destination_path = public_path('uf/adata/');
            $first_image_uploaded = 0;
            foreach ($ad_image as $k){
                if(!empty($k) && $k->isValid()){
                    $file_name = $ad->ad_id . '_' .md5(time() + rand(0,9999)) . '.' . $k->getClientOriginalExtension();
                    $k->move($destination_path, $file_name);

                    $img    = Image::make($destination_path . $file_name);
                    $width  = $img->width();
                    $height = $img->height();

                    if($width > 1000 || $height > 1000) {
                        if ($width == $height) {
                            $img->resize(1000, 1000);
                            if(config('dc.watermark')){
                                $img->insert(public_path('uf/settings/') . config('dc.watermark'), config('dc.watermark_position'));
                            }
                            $img->save($destination_path . '1000_' . $file_name);
                        } elseif ($width > $height) {
                            $img->resize(1000, null, function($constraint){
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                            if(config('dc.watermark')){
                                $img->insert(public_path('uf/settings/') . config('dc.watermark'), config('dc.watermark_position'));
                            }
                            $img->save($destination_path . '1000_' . $file_name);
                        } elseif ($width < $height) {
                            $img->resize(null, 1000, function($constraint){
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                            if(config('dc.watermark')){
                                $img->insert(public_path('uf/settings/') . config('dc.watermark'), config('dc.watermark_position'));
                            }
                            $img->save($destination_path . '1000_' . $file_name);
                        }
                    } else {
                        if(config('dc.watermark')){
                            $img->insert(public_path('uf/settings/') . config('dc.watermark'), config('dc.watermark_position'));
                            $img->save($destination_path . '1000_' . $file_name);
                        } else {
                            $img->save($destination_path . '1000_' . $file_name);
                        }
                    }

                    if(!$first_image_uploaded){
                        if($width >= 720 || $height >= 720) {
                            $img->fit(720, 720)->save($destination_path . '740_' . $file_name);
                        } else {
                            $img->resizeCanvas(720, 720, 'top')->save($destination_path . '740_' . $file_name);
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
        }
         
        $ad->ad_category_info   = $this->category->getParentsByIdFlat($ad->category_id);
        $ad->ad_location_info   = $this->location->getParentsByIdFlat($ad->location_id);
        $ad->pics               = AdPic::where('ad_id', $ad->ad_id)->get();
        $ad->same_ads           = Ad::where([['ad_description_hash', $ad->ad_description_hash], ['ad_id', '<>', $ad->ad_id]])->get();
         
        //send info mail
        Mail::send('emails.ad_edit', ['user' => Auth::user(), 'ad' => $ad], function ($m) use ($request){
            $m->from(config('dc.site_contact_mail'), config('dc.site_domain'));
            $m->to($request->user()->email)->subject(trans('publish_edit.Your ad is edited!'));
        });

        //send control mail
        if(config('dc.enable_control_mails')) {
            Mail::send('emails.control_ad_activation', ['user' => Auth::user(), 'ad' => $ad], function ($m) {
                $m->from(config('dc.site_contact_mail'), config('dc.site_domain'));
                $m->to(config('dc.control_mail'))->subject(config('dc.control_mail_edit_subject'));
            });
        }

        Cache::flush();

        $message[] = trans('publish_edit.Your ad is saved.');
        $message[] = trans('publish_edit.Click here to return to my ads', ['link' => route('myads')]);
        $message[] = trans('publish_edit.Click here to publish new ad', ['link' => route('publish')]);

        //set flash message and go to info page
        session()->flash('message', $message);
        return redirect(route('info'));
    }
    
    public function userads(Request $request)
    {
        $params     = $request->all();
        $limit      = 0;
        $orderRaw   = '';
        $whereIn    = [];
        $whereRaw   = [];
        $page       = 1;
        $paginate   = config('dc.num_ads_user_list');
        if (isset($params['page']) && is_numeric($params['page'])) {
            $page = $params['page'];
        }

        $user = $this->user->getUserById($request->user_id);
        $where = ['user_id' => $user->user_id, 'ad_active' => 1];
        $order = ['ad_publish_date' => 'desc'];
        $user_ad_list = $this->ad->getAdList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate, $page);

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('user.Ad List');
        $title[] = trans('user.Ad List User', ['name' => $user->name]);
        $title[] = trans('myads.Page:') . ' ' . $page;

        return view('ad.user', ['user' => $user, 'user_ad_list' => $user_ad_list, 'title' => $title, 'params' => $params]);
    }

    public function makepromo(Request $request)
    {
        //get ad info
        $ad_id = $request->ad_id;
        $ad_detail = $this->ad->getAdDetail($ad_id);

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('makepromo.Make promo Ad Id') . ' #' . $ad_detail->ad_id;

        $payment_methods = new Collection();
        if(config('dc.enable_promo_ads')){
            $where['pay_active']    = 1;
            $order['pay_ord']       = 'ASC';
            $payModel               = new Pay();
            $payment_methods        = $payModel->getList($where, $order);
        }

        $enable_pay_from_wallet = 0;
        if(config('dc.enable_promo_ads') && Auth::check()){
            //no caching for the wallet :)
            $wallet_total = Wallet::where('user_id', Auth::user()->user_id)->sum('sum');
            if(number_format($wallet_total, 2, '.', '') >= number_format(config('dc.wallet_promo_ad_price'), 2, '.', '')){
                $enable_pay_from_wallet = 1;
            }
        }

        return view('ad.makepromo', ['title' => $title,
            'payment_methods' => $payment_methods,
            'ad_detail' => $ad_detail,
            'enable_pay_from_wallet' => $enable_pay_from_wallet
        ]);
    }

    public function postmakepromo(Request $request)
    {
        //get ad info
        $ad_id = $request->ad_id;
        $ad_detail = $this->ad->getAdDetail($ad_id);

        $rules = [
            'ad_type_pay' => 'required|integer|not_in:0'
        ];

        $messages = [
            'required' => trans('addtowallet.Please select payment method.'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $params = $request->all();

        //if promo ads are enable check witch option is selected
        if(isset($params['ad_type_pay'])){

            //wallet pay
            if($params['ad_type_pay'] == 1000){
                //no caching for the wallet :)
                $wallet_total = Wallet::where('user_id', Auth::user()->user_id)->sum('sum');
                if(number_format($wallet_total, 2, '.', '') >= number_format(config('dc.wallet_promo_ad_price'), 2, '.', '')){
                    //calc promo period
                    $promoUntilDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+config('dc.wallet_promo_ad_period'), date('Y')));

                    //make ad promo and activate it
                    $ad_detail->ad_promo = 1;
                    $ad_detail->ad_promo_until = $promoUntilDate;
                    $ad_detail->ad_active = 1;
                    $ad_detail->save();

                    //subtract money from wallet
                    $wallet_data = ['user_id' => $ad_detail->user_id,
                        'ad_id' => $ad_detail->ad_id,
                        'sum' => -number_format(config('dc.wallet_promo_ad_price'), 2, '.', ''),
                        'wallet_date' => date('Y-m-d H:i:s'),
                        'wallet_description' => trans('payment_fortumo.Your ad #:ad_id is Promo Until :date.', ['ad_id' => $ad_detail->ad_id, 'date' => $promoUntilDate])
                    ];
                    Wallet::create($wallet_data);
                    Cache::flush();

                    $message[] = trans('payment_fortumo.Your ad #:ad_id is Promo Until :date.', ['ad_id' => $ad_detail->ad_id, 'date' => $promoUntilDate]);
                    $message[] = trans('publish_edit.Click here to publish new ad', ['link' => route('publish')]);
                }
            } else {
                $where['pay_active'] = 1;
                $order['pay_ord'] = 'ASC';
                $payModel = new Pay();
                $payment_methods = $payModel->getList($where, $order);
                if (!$payment_methods->isEmpty()) {
                    foreach ($payment_methods as $k => $v) {
                        if($v->pay_id == $params['ad_type_pay']){
                            if(empty($v->pay_page_name)){
                                $message[] = trans('publish_edit.Send sms and make your ad promo', [
                                    'number' => $v->pay_number,
                                    'text' => $v->pay_sms_prefix . ' a' . $ad_detail->ad_id,
                                    'period' => $v->pay_promo_period,
                                    'sum' => number_format($v->pay_sum, 2, '.', ''),
                                    'cur' => config('dc.site_price_sign')
                                ]);
                            } else {
                                $message[] = trans('publish_edit.Click the button to pay for promo', [
                                    'pay' => $v->pay_name,
                                    'period' => $v->pay_promo_period,
                                    'sum' => number_format($v->pay_sum, 2, '.', ''),
                                    'cur' => config('dc.site_price_sign')
                                ]);
                                session()->flash('message', $message);
                                return redirect(url($v->pay_page_name . '/a' . $ad_detail->ad_id));
                            }
                        }
                    }
                }
            }
        }

        //set flash message and go to info page
        session()->flash('message', $message);
        return redirect(route('info'));
    }
}
