<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\EstateHeatingType;

use Validator;
use Cache;

class EstateHeatingController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.estate_heating.estate_heating_list', ['modelData' => EstateHeatingType::all()]);
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
                $modelData = EstateHeatingType::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', 'Invalid Heating Type');
                return redirect(url('admin/estateheating'));
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
                'estate_heating_type_name' => 'required|max:255'
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
            if(!isset($modelData->estate_heating_type_id)){
                EstateHeatingType::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', 'Heating Type saved');
            return redirect(url('admin/estateheating'));
        }

        return view('admin.estate_heating.estate_heating_edit', ['modelData' => $modelData]);
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
            $data = $request->input('estate_heating_type_id');
        }

        //delete
        if(!empty($data)){
            EstateHeatingType::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', 'Heating Type deleted');
            return redirect(url('admin/estateheating'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', 'Nothing for deletion');
        return redirect(url('admin/estateheating'));
    }
}
