<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ShoesSize;

use Validator;
use Cache;

class ShoesController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.shoes.shoes_list', ['modelData' => ShoesSize::all()]);
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
                $modelData = ShoesSize::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', trans('admin_common.Invalid Shoes Size'));
                return redirect(url('admin/shoes'));
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
                'shoes_size_name' => 'required|max:255',
                'shoes_size_ord' => 'required|numeric'
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
            if(!isset($modelData->shoes_size_id)){
                ShoesSize::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.Shoes Size saved'));
            return redirect(url('admin/shoes'));
        }

        return view('admin.shoes.shoes_edit', ['modelData' => $modelData]);
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
            $data = $request->input('shoes_size_id');
        }

        //delete
        if(!empty($data)){
            ShoesSize::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.Shoes Size deleted'));
            return redirect(url('admin/shoes'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/shoes'));
    }
}
