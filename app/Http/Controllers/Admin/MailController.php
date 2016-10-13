<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\UserMail;
use App\User;

use Validator;
use Cache;


class MailController extends Controller
{
    protected $mail;

    public function __construct(UserMail $_mail)
    {
        $this->mail       = $_mail;
    }

    public function index(Request $request)
    {
        $params     = Input::all();
        $where      = [];
        $order      = ['mail_id' => 'desc'];
        $limit      = 0;
        $orderRaw   = '';
        $whereIn    = [];
        $whereRaw   = [];
        $paginate   = config('dc.admin_list_num_items');
        $page       = 1;

        if(isset($params['mail_id_search']) && !empty($params['mail_id_search'])){
            $where['mail_id'] = ['=', $params['mail_id_search']];
        }

        if(isset($params['ad_id']) && !empty($params['ad_id'])){
            $where['ad_id'] = ['=', $params['ad_id']];
        }

        if(isset($params['user_id_from']) && !empty($params['user_id_from'])){
            $where['user_id_from'] = ['=', $params['user_id_from']];
        }

        if(isset($params['user_id_to']) && !empty($params['user_id_to'])){
            $where['user_id_to'] = ['=', $params['user_id_to']];
        }

        if(isset($params['mail_text']) && !empty($params['mail_text'])){
            $where['mail_text'] = ['like', '%' . $params['mail_text'] . '%'];
        }

        if(isset($params['mail_hash']) && !empty($params['mail_hash'])){
            $where['mail_hash'] = ['=', $params['mail_hash']];
        }

        if (isset($params['page']) && is_numeric($params['page'])) {
            $page = $params['page'];
        }

        $mailList = $this->mail->getList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate, $page);
        return view('admin.mail.mail_list', ['mailList' => $mailList, 'params' => $params]);
    }

    public function edit(Request $request)
    {
        $modelData = new \stdClass();

        /**
         * form is submitted check values and save if needed
         */
        if ($request->isMethod('post')) {

            /**
             * validate data
             */
            $rules = [
                'user_id_to' => 'required|integer|not_in:0',
                'ad_id' => 'required|integer|not_in:0',
                'mail_text' => 'required',
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
             * save and send mail
             */
            $current_user_id    = Auth::user()->user_id;
            $mail_to            = User::where('user_id', $data['user_id_to'])->firstOrFail()->email;
            $this->mail->saveMailToDbAndSendMail($current_user_id, $data['user_id_to'], $data['ad_id'], $data['mail_text'], $mail_to);

            /**
             * clear cache, set message, redirect to list
             */
            Cache::flush();
            session()->flash('message', trans('admin_common.Mail saved'));
            return redirect(url('admin/mail'));
        }

        return view('admin.mail.mail_edit', ['modelData' => $modelData]);
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
            $data = $request->input('mail_id');
        }

        //delete
        if(!empty($data)){
            UserMail::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.User Mail deleted'));
            return redirect(url('admin/mail'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/mail'));
    }
}
