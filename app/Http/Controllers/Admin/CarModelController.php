<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CarBrand;
use App\CarModel;

use Validator;
use Cache;

class CarModelController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.car_model.car_model_list', ['modelData' => CarModel::with('brand')->get()]);
    }

    public function edit(Request $request)
    {
        $car_brand_id = CarBrand::all();

        $id = 0;
        if(isset($request->id)){
            $id = $request->id;
        }

        $modelData = new \stdClass();
        if($id > 0){
            try{
                $modelData = CarModel::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', 'Invalid Car Model');
                return redirect(url('admin/carmodel'));
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
                'car_brand_id' => 'required|integer|not_in:0',
                'car_model_name' => 'required|max:255'
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

            if(isset($data['car_model_active'])){
                $data['car_model_active'] = 1;
            } else {
                $data['car_model_active'] = 0;
            }

            /**
             * save or update
             */
            if(!isset($modelData->car_model_id)){
                CarModel::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', 'Car Model saved');
            return redirect(url('admin/carmodel'));
        }

        return view('admin.car_model.car_model_edit', ['modelData' => $modelData, 'car_brand_id' => $car_brand_id]);
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
            $data = $request->input('car_model_id');
        }

        //delete
        if(!empty($data)){
            CarModel::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', 'Car Model deleted');
            return redirect(url('admin/carmodel'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', 'Nothing for deletion');
        return redirect(url('admin/carmodel'));
    }

    public function import(Request $request)
    {
        $car_brand_id = CarBrand::all();
        /**
         * form is submitted check values and save if needed
         */
        if ($request->isMethod('post')) {

            /**
             * validate data
             */
            $rules = ['car_brand_id' => 'required|integer|not_in:0',
                'csv_file' => 'required'];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }

            /**
             * save data if validated
             */
            if ($request->file('csv_file')->isValid()) {

                //rename and move uploaded file
                $csv_file = Input::file('csv_file');
                $tmp_import_name = time() . '_car_model_import_.' . $csv_file->getClientOriginalExtension();
                $csv_file->move(storage_path() . '/app', $tmp_import_name);

                //read csv
                $csv_data = [];
                if (($handle = fopen(storage_path() . '/app/' . $tmp_import_name, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
                        $csv_data[] = $data;
                    }
                    fclose($handle);
                }

                if(!empty($csv_data)){

                    $car_brand_id = $request->input('car_brand_id');

                    //import erros holder
                    $import_error_array = [];

                    foreach ($csv_data as $k => $v){
                        if(is_array($v)){
                            $data_to_save = [];

                            //set fields to be imported
                            if(isset($v[0]) && !empty($v[0])){
                                $data_to_save['car_model_name'] = trim($v[0]);
                            }
                            if(isset($v[1]) && !empty($v[1])){
                                $data_to_save['car_model_active'] = trim($v[1]);
                            }
                            $data_to_save['car_brand_id'] = $car_brand_id;

                            //check if all fields are here
                            if(count($data_to_save) == 3){
                                try{
                                    CarModel::create($data_to_save);
                                } catch (\Exception $e){
                                    $import_error_array[] = 'Error on line: ' . join(',', $v) . ' <br />Error Message: ' . $e->getMessage();
                                }
                            } else {
                                $import_error_array[] = 'Missing data line: ' . join(',', $v);
                            }
                        }
                    }
                } else {
                    session()->flash('message', 'Can\'t read the csv file.');
                    return redirect( url('admin/carmodel') );
                }
            }

            /**
             * delete temp file, clear cache, set message, redirect to list
             */
            @unlink(storage_path() . '/app/' . $tmp_import_name);
            Cache::flush();
            if(!empty($import_error_array)){
                session()->flash('message', 'Car Models imported with the following errors: <br />' . join('<br />', $import_error_array));
            } else {
                session()->flash('message', 'Car Models imported');
            }
            return redirect(url('admin/carmodel'));
        }

        return view('admin.car_model.car_model_import', ['car_brand_id' => $car_brand_id]);
    }
}
