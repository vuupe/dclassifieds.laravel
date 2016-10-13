<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Dc\Util;

use App\Wallet;

use Validator;
use Cache;
use DB;

class WalletController extends Controller
{
    protected $wallet;

    public function __construct(Wallet $_wallet)
    {
        $this->wallet = $_wallet;
    }

    public function index(Request $request)
    {
        $params     = Input::all();
        $where      = [];
        $order      = ['wallet_id' => 'desc'];
        $limit      = 0;
        $orderRaw   = '';
        $whereIn    = [];
        $whereRaw   = [];
        $paginate   = config('dc.admin_list_num_items');
        $page       = 1;

        if(isset($params['wallet_id_search']) && !empty($params['wallet_id_search'])){
            $where['wallet_id'] = ['=', $params['wallet_id_search']];
        }

        if(isset($params['ad_id']) && !empty($params['ad_id'])){
            $where['ad_id'] = ['=', $params['ad_id']];
        }

        if(isset($params['user_id']) && !empty($params['user_id'])){
            $where['user_id'] = ['=', $params['user_id']];
        }

        if(isset($params['name']) && !empty($params['name'])){
            $where['name'] = ['like', $params['name'] . '%'];
        }

        if(isset($params['email']) && !empty($params['email'])){
            $where['email'] = ['like', $params['email'] . '%'];
        }

        if(isset($params['wallet_date']) && !empty($params['wallet_date'])){
            $whereRaw["DATE_FORMAT(wallet_date, '%Y-%m-%d') = ?"] = [$params['wallet_date']];
        }

        if(isset($params['sum']) && !empty($params['sum'])){
            $where['sum'] = ['=', $params['sum']];
        }

        if(isset($params['wallet_description']) && !empty($params['wallet_description'])){
            $where['wallet_description'] = ['like', '%' . $params['wallet_description'] . '%'];
        }

        if (isset($params['page']) && is_numeric($params['page'])) {
            $page = $params['page'];
        }

        $walletList = $this->wallet->getList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate, $page);
        return view('admin.wallet.wallet_list', ['walletList' => $walletList, 'params' => $params]);
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
                $modelData = Wallet::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', trans('admin_common.Invalid Wallet Item'));
                return redirect(url('admin/wallet'));
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
                'user_id' => 'required|integer|not_in:0',
                'ad_id' => 'integer|not_in:0',
                'sum' => 'required|numeric|not_in:0',
                'wallet_date' => 'required|max:255',
                'wallet_description' => 'required|max:255',
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

            if(empty($data['ad_id'])){
                unset($data['ad_id']);
            }

            /**
             * save or update
             */
            if(!isset($modelData->wallet_id)){
                Wallet::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.Wallet Item saved'));
            return redirect(url('admin/wallet'));
        }

        return view('admin.wallet.wallet_edit', ['modelData' => $modelData]);
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
            $data = $request->input('wallet_id');
        }

        //delete
        if(!empty($data)){
            Wallet::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.Wallet Item deleted'));
            return redirect(url('admin/wallet'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/wallet'));
    }
}
