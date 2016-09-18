<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\EstateFurnishingType;

use Validator;
use Cache;

class EstateFurnishingController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.estate_furnishing.estate_furnishing_list', ['modelData' => EstateFurnishingType::all()]);
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
                $modelData = EstateFurnishingType::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', 'Invalid Furnishing Type');
                return redirect(url('admin/estatefurnishing'));
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
                'estate_furnishing_type_name' => 'required|max:255'
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
            if(!isset($modelData->estate_furnishing_type_id)){
                EstateFurnishingType::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', 'Furnishing Type saved');
            return redirect(url('admin/estatefurnishing'));
        }

        return view('admin.estate_furnishing.estate_furnishing_edit', ['modelData' => $modelData]);
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
            $data = $request->input('estate_furnishing_type_id');
        }

        //delete
        if(!empty($data)){
            EstateFurnishingType::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', 'Furnishing Type deleted');
            return redirect(url('admin/estatefurnishing'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', 'Nothing for deletion');
        return redirect(url('admin/estatefurnishing'));
    }
}
