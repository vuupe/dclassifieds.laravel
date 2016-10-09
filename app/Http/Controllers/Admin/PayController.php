<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pay;

use Validator;
use Cache;

class PayController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pay.pay_list', ['modelData' => Pay::all()]);
    }

    public function edit(Request $request)
    {
        $id = 0;
        if(isset($request->id)){
            $id = $request->id;
        }

        try{
            $modelData = Pay::findOrFail($id);
        } catch (ModelNotFoundException $e){
            session()->flash('message', trans('admin_common.Invalid Payment Option'));
            return redirect(url('admin/pay'));
        }

        /**
         * form is submitted check values and save if needed
         */
        if ($request->isMethod('post')) {

            /**
             * validate data
             */
            $rules = [
                'pay_name' => 'required|max:255',
                'pay_sum' => 'required|numeric|not_in:0',
                'pay_promo_period' => 'required|numeric|not_in:0',
                'pay_info_url' => 'required|max:255',
                'pay_sms_prefix' => 'max:255',
                'pay_description' => 'required',
                'pay_ord' => 'required|numeric',
                'pay_allowed_ip' => 'max:255'
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

            if(isset($data['pay_active'])){
                $data['pay_active'] = 1;
            } else {
                $data['pay_active'] = 0;
            }

            /**
             * save or update
             */
            $modelData->update($data);

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.Payment Option saved'));
            return redirect(url('admin/pay'));
        }

        return view('admin.pay.pay_edit', ['modelData' => $modelData]);
    }
}
