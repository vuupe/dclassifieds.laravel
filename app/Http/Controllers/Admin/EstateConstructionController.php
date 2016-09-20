<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\EstateConstructionType;

use Validator;
use Cache;

class EstateConstructionController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.estate_construction.estate_construction_list', ['modelData' => EstateConstructionType::all()]);
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
                $modelData = EstateConstructionType::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', 'Invalid Construction Type');
                return redirect(url('admin/estateconstruction'));
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
                'estate_construction_type_name' => 'required|max:255'
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
            if(!isset($modelData->estate_construction_type_id)){
                EstateConstructionType::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', 'Construction Type saved');
            return redirect(url('admin/estateconstruction'));
        }

        return view('admin.estate_construction.estate_construction_edit', ['modelData' => $modelData]);
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
            $data = $request->input('estate_construction_type_id');
        }

        //delete
        if(!empty($data)){
            EstateConstructionType::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', 'Construction Type deleted');
            return redirect(url('admin/estateconstruction'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', 'Nothing for deletion');
        return redirect(url('admin/estateconstruction'));
    }
}
