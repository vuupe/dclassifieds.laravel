<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ad;
use App\User;

use Validator;
use Cache;

class UserController extends Controller
{
	protected $ad;
	protected $user;
	
	public function __construct(Ad $_ad, User $_user)
	{
		$this->ad = $_ad;
		$this->user = $_user;
	}

	public function index(Request $request)
	{
		$params 	= Input::all();
		$where 		= [];
		$order 		= ['user_id' => 'desc'];
		$limit 		= 0;
		$orderRaw 	= '';
		$whereIn 	= [];
		$whereRaw 	= [];
		$paginate 	= 2;
		$page 		= 1;

        if(isset($params['user_id_search']) && !empty($params['user_id_search'])){
            $where['user_id'] = ['=', $params['user_id_search']];
        }

        if(isset($params['name']) && !empty($params['name'])){
            $where['name'] = ['like', $params['name'] . '%'];
        }

        if(isset($params['email']) && !empty($params['email'])){
            $where['email'] = ['like', $params['email'] . '%'];
        }

        if(isset($params['user_activated']) && is_numeric($params['user_activated']) && ($params['user_activated'] == 0 || $params['user_activated'] == 1)){
            $where['user_activated'] = ['=', $params['user_activated']];
        }

        if(isset($params['location_name']) && !empty($params['location_name'])){
            $where['location_name'] = ['like', $params['location_name'] . '%'];
        }

        if (isset($params['page']) && is_numeric($params['page'])) {
            $page = $params['page'];
        }

		$userList = $this->user->getUserList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate, $page);
		return view('admin.user.user_list', ['userList' => $userList, 'params' => $params, 'yesnoselect' => ['_' => '', 0 => 'No', 1 => 'Yes']]);
	}
}
