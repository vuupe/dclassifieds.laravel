<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Settings;

use Validator;
use Cache;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.settings.settings_list', ['modelData' => Settings::where('setting_show_in_admin', 1)->get()]);
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
                $modelData = Settings::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', trans('admin_common.Invalid Setting'));
                return redirect(url('admin/settings'));
            }
        }

        /**
         * form is submitted check values and save if needed
         */
        if ($request->isMethod('post')) {

            /**
             * validate data
             */
            $rules = [];
            if($modelData->setting_required) {
                $rules = ['setting_value' => 'required'];
            }

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
             * check for uploaded file
             */
            $old_file_name = $modelData->setting_value;
            if($modelData->setting_field_type == 'file') {
                if ($request->hasFile('setting_value') && $request->file('setting_value')->isValid()) {
                    $file = Input::file('setting_value');
                    $name = mb_substr(time(), -3) . '_' . $file->getClientOriginalName();
                    $file->move(public_path() . '/uf/settings', $name);
                    $data['setting_value'] = $name;
                }
            }

            //check if the value must be cleared
            if(isset($data['clear_value'])){
                $data['setting_value'] = '';
            }

            /**
             * update
             */
            $modelData->update($data);
            if(!empty($old_file_name)){
                @unlink(public_path() . '/uf/settings/' . $old_file_name);
            }


            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.Setting saved'));
            return redirect(url('admin/settings'));
        }

        return view('admin.settings.settings_edit', ['modelData' => $modelData]);
    }
}
