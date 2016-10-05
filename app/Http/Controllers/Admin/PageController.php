<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Page;

use Validator;
use Cache;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $page_menu_position = [Page::HEADER_MENU => trans('admin_common.Header Menu'),
            Page::FOOTER_MENU => trans('admin_common.Footer Menu')];
        return view('admin.page.page_list', ['modelData' => Page::all(), 'page_menu_position' => $page_menu_position]);
    }

    public function edit(Request $request)
    {
        $page_menu_position = [Page::HEADER_MENU => trans('admin_common.Header Menu'),
            Page::FOOTER_MENU => trans('admin_common.Footer Menu')];

        $id = 0;
        if(isset($request->id)){
            $id = $request->id;
        }

        $modelData = new \stdClass();
        if($id > 0){
            try{
                $modelData = Page::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', trans('admin_common.Invalid Page'));
                return redirect(url('admin/page'));
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
                'page_position' => 'required|integer|not_in:0',
                'page_slug' => 'required|max:255|unique:page,page_slug',
                'page_title' => 'required|max:255',
                'page_content' => 'required',
                'page_ord' => 'required|integer'
            ];

            if(isset($modelData->page_id)){
                $rules['page_slug'] = 'required|max:255|unique:page,page_slug,' . $modelData->page_id  . ',page_id';
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

            if(isset($data['page_active'])){
                $data['page_active'] = 1;
            } else {
                $data['page_active'] = 0;
            }

            /**
             * save or update
             */
            if(!isset($modelData->page_id)){
               Page::create($data);
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.Page saved'));
            return redirect(url('admin/page'));
        }

        return view('admin.page.page_edit', ['modelData' => $modelData, 'page_menu_position' => $page_menu_position]);
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
            $data = $request->input('page_id');
        }

        //delete
        if(!empty($data)){
            Page::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.Page deleted'));
            return redirect(url('admin/page'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/page'));
    }
}
