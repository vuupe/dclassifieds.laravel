<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdCondition;

use Validator;
use Cache;

class AdConditionController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.ad_condition.ad_condition_list', ['modelData' => AdCondition::all()]);
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
                $modelData = AdCondition::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', 'Invalid Ad Condition');
                return redirect(url('admin/adcondition'));
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
                'ad_condition_name' => 'required|max:255'
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
             * save or update
             */
            if(!isset($modelData->ad_condition_id)){
                AdCondition::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', 'Ad Condition saved');
            return redirect(url('admin/adcondition'));
        }

        return view('admin.ad_condition.ad_condition_edit', ['modelData' => $modelData]);
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
            $data = $request->input('ad_condition_id');
        }

        //delete
        if(!empty($data)){
            AdCondition::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', 'Ad Condition deleted');
            return redirect(url('admin/adcondition'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', 'Nothing for deletion');
        return redirect(url('admin/adcondition'));
    }
}
