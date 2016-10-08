<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdBanEmail;

use Validator;
use Cache;
use Mail;

class MailBanController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.mail_ban.mail_ban_list', ['modelData' => AdBanEmail::all()]);
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
                $modelData = AdBanEmail::findOrFail($id);
            } catch (ModelNotFoundException $e){
                session()->flash('message', trans('admin_common.Invalid Mail ID'));
                return redirect(url('admin/mailban'));
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
                'ban_email' => 'required|email|unique:ad_ban_email,ban_email',
                'ban_reason' => 'required|max:255'
            ];

            if(isset($modelData->ban_email_id)){
                $rules['ban_email'] = 'required|email|unique:ad_ban_email,ban_email,' . $modelData->ban_email_id  . ',ban_email_id';
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
             * save or update
             */
            if(!isset($modelData->ban_email_id)){
                AdBanEmail::create($data);
                //send email to inform the user
                Mail::send('emails.user_ban_email', ['data' => $data], function ($m) use ($data) {
                    $m->from('test@mylove.bg', 'dclassifieds banned');
                    $m->to($data['ban_email'])->subject('You are banner in DClassifieds');
                });
            } else {
                $modelData->update($data);
            }

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.Banned Mail saved'));
            return redirect(url('admin/mailban'));
        }

        return view('admin.mail_ban.mail_ban_edit', ['modelData' => $modelData]);
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
            $data = $request->input('ban_email_id');
        }

        //delete
        if(!empty($data)){
            AdBanEmail::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.Banned Mail deleted'));
            return redirect(url('admin/mailban'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/mailban'));
    }
}
