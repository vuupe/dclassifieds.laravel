<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ad;
use App\User;
use App\AdPic;
use App\Location;

use Validator;
use Cache;

class UserController extends Controller
{
    protected $ad;
    protected $user;
    protected $location;

    public function __construct(Ad $_ad, User $_user, Location $_location)
    {
        $this->ad = $_ad;
        $this->user = $_user;
        $this->location = $_location;
    }

    public function index(Request $request)
    {
        $params     = Input::all();
        $where      = [];
        $order      = ['user_id' => 'desc'];
        $limit      = 0;
        $orderRaw   = '';
        $whereIn    = [];
        $whereRaw   = [];
        $paginate   = 2;
        $page       = 1;

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
        return view('admin.user.user_list', ['userList' => $userList, 'params' => $params, 'yesnoselect' => ['_' => '', 0 => trans('admin_common.No'), 1 => trans('admin_common.Yes')]]);
    }

    public function edit(Request $request)
    {
        $id = 0;
        if(isset($request->id)){
            $id = $request->id;
        }

        $modelData = new \stdClass();
        if($id > 0){
            try{
                $modelData = User::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', trans('admin_common.Invalid User'));
                return redirect(url('admin/user'));
            }
        }

        /**
         * form is submitted check values and save if needed
         */
        if ($request->isMethod('post')) {

            /**
             * validate data
             */
            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|max:255|unique:user,email,' . $modelData->user_id  . ',user_id'
            ];

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
             * save data if validated
             */
            if(isset($data['user_activated'])){
                $data['user_activated'] = 1;
            } else {
                $data['user_activated'] = 0;
            }

            if(isset($data['is_admin'])){
                $data['is_admin'] = 1;
            } else {
                $data['is_admin'] = 0;
            }

            /**
             * save or update
             */
            if(!isset($modelData->user_id)){
                User::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.User saved'));
            return redirect(url('admin/user'));
        }

        return view('admin.user.user_edit', ['modelData' => $modelData,
            'l' => $this->location->getAllHierarhy(null, 0, 0),
            'lid' => $modelData->user_location_id]);
    }

    public function delete(Request $request)
    {
        //users to be deleted
        $data = [];

        //check for single delete
        if(isset($request->id)){
            $data[] = $request->id;
        }

        //check for mass delete if no single delete
        if(empty($data)){
            $data = $request->input('user_id');
        }

        //delete
        if(!empty($data)){
            foreach ($data as $k => $v){
                $u = User::find($v);
                //get all user ads
                $userAds = Ad::where('user_id', $u->user_id)->get();
                if(!$userAds->isEmpty()){
                    foreach($userAds as $ka => $va){
                        //delete ads images
                        $more_pics = AdPic::where('ad_id', $va->ad_id)->get();
                        if(!$more_pics->isEmpty()){
                            foreach ($more_pics as $km => $vm){
                                @unlink(public_path('uf/adata/') . '740_' . $vm->ad_pic);
                                @unlink(public_path('uf/adata/') . '1000_' . $vm->ad_pic);
                                $vm->delete();
                            }
                        }

                        if(!empty($va->ad_pic)){
                            @unlink(public_path('uf/adata/') . '740_' . $va->ad_pic);
                            @unlink(public_path('uf/adata/') . '1000_' . $va->ad_pic);
                        }
                        $va->delete();
                    }
                }

                //check for avatar and delete if any
                if(!empty($u->avatar)){
                    @unlink(public_path('uf/udata/') . '100_' . $u->avatar);
                }
                $u->delete();
            }
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.User and All User Ads Deleted'));
            return redirect(url('admin/user'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/user'));
    }

    public function deleteavatar(Request $request)
    {
        $id = 0;
        if(isset($request->id)){
            $id = $request->id;
        }
        $u = User::findOrFail($id);
        if(!empty($u->avatar)){
            @unlink(public_path('uf/udata/') . '100_' . $u->avatar);
            $u->avatar = null;
            $u->save();
        }
        return redirect(url('admin/user/edit/' . $id));
    }
}
