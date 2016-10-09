<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Banner;

use Validator;
use Cache;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.banner.banner_list', ['modelData' => Banner::all()]);
    }

    public function edit(Request $request)
    {
        $bannerType = [Banner::BANNER_CODE => trans('admin_common.Javascript/HTML Banner'),
            Banner::BANNER_IMAGE => trans('admin_common.Image Banner')];

        $bannerPosition = [Banner::BANNER_POSITION_LIST => trans('admin_common.Ad List Position (728x90px)'),
            Banner::BANNER_POSITION_DETAIL => trans('admin_common.Ad Detail Right Position (300x250px)')];

        $id = 0;
        if(isset($request->id)){
            $id = $request->id;
        }

        $modelData = new \stdClass();
        if($id > 0){
            try{
                $modelData = Banner::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', trans('admin_common.Invalid Banner'));
                return redirect(url('admin/banner'));
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
                'banner_name' => 'required|max:255',
                'banner_position' => 'required|integer|not_in:0',
                'banner_type' => 'required|integer|not_in:0',
                'banner_active_from' => 'required|max:255',
                'banner_active_to' => 'required|max:255'
            ];

            $validator = Validator::make($request->all(), $rules);

            /**
             * dynamic validation rules
             */
            $validator->sometimes(['banner_code'], 'required', function($input){
                if($input->banner_type == Banner::BANNER_CODE){
                    return true;
                }
                return false;
            });

            $validator->sometimes(['banner_link'], 'required|max:255', function($input){
                if($input->banner_type == Banner::BANNER_IMAGE){
                    return true;
                }
                return false;
            });

            $validator->sometimes(['banner_file'], 'required|mimes:jpeg,bmp,png,gif', function($input) use ($modelData){
                if($input->banner_type == Banner::BANNER_IMAGE && !isset($modelData->banner_id)){
                    return true;
                }
                return false;
            });

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
             * check for uploaded banner
             */
            $banner_name = '';
            if ($request->hasFile('banner_file') && $request->file('banner_file')->isValid()) {
                $file = Input::file('banner_file');
                $banner_name = time() . '_banner.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/uf/banner', $banner_name);
                $data['banner_image'] = $banner_name;
            }

            /**
             * save or update
             */
            if(!isset($modelData->banner_id)){
                Banner::create($data);
            } else {
                if(!empty($banner_name) && !empty($modelData->banner_image)){
                    @unlink(public_path() . '/uf/banner/' . $modelData->banner_image);
                }
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.Banner saved'));
            return redirect(url('admin/banner'));
        }

        return view('admin.banner.banner_edit', ['modelData' => $modelData,
            'bannerType' => $bannerType,
            'bannerPosition' => $bannerPosition]);
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
            $data = $request->input('banner_id');
        }

        //delete
        if(!empty($data)){
            foreach ($data as $k => $v){
                $b = Banner::find($v);
                if(!empty($b->banner_image)){
                    @unlink(public_path() . '/uf/banner/' . $b->banner_image);
                }
                $b->delete();
            }
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.Banner deleted'));
            return redirect(url('admin/banner'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/banner'));
    }
}
