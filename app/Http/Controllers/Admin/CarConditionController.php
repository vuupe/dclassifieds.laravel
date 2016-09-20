<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CarCondition;

use Validator;
use Cache;

class CarConditionController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.car_condition.car_condition_list', ['modelData' => CarCondition::all()]);
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
                $modelData = CarCondition::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', 'Invalid Car Condition');
                return redirect(url('admin/carcondition'));
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
                'car_condition_name' => 'required|max:255'
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
            if(!isset($modelData->car_condition_id)){
                CarCondition::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', 'Car Condition saved');
            return redirect(url('admin/carcondition'));
        }

        return view('admin.car_condition.car_condition_edit', ['modelData' => $modelData]);
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
            $data = $request->input('car_condition_id');
        }

        //delete
        if(!empty($data)){
            CarCondition::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', 'Car Condition deleted');
            return redirect(url('admin/carcondition'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', 'Nothing for deletion');
        return redirect(url('admin/carcondition'));
    }
}
