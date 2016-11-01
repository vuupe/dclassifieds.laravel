<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Ad;
use App\UserMail;
use App\UserMailStatus;
use App\Location;
use App\Wallet;
use App\Pay;
use App\Http\Dc\Util;

use Validator;
use Image;
use Cache;
use Mail;
use Auth;

class UserController extends Controller
{
    protected $user;
    protected $mail;
    protected $location;
    protected $wallet;
    
    public function __construct(User $_user, UserMail $_mail, Location $_location, Wallet $_wallet)
    {
        $this->user     = $_user;
        $this->mail     = $_mail;
        $this->location = $_location;
        $this->wallet   = $_wallet;
    }
    
    public function myprofile(Request $request)
    {
        $user = $this->user->find(Auth::user()->user_id);
        $user->password = '';

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('myprofile.My Profile');

        return view('user.myprofile', ['user' => $user,
            'l' => $this->location->getAllHierarhy(),
            'title' => $title]);
    }
    
    public function myprofilesave(Request $request)
    {
        $current_user = Auth::user();
        $rules = [
            'name'          => 'required|max:255',
            'email'         => 'required|email|max:255|unique:user,email,' . $current_user->user_id  . ',user_id',
            'avatar_img'    => 'mimes:jpeg,bmp,png|max:300',
        ];
         
        $validator = Validator::make($request->all(), $rules);
        
        $validator->sometimes(['password'], 'required|confirmed|min:6', function($input){
            return !empty($input->password) ? 1 : 0;
        });
        
        if ($validator->fails()) {
            $this->throwValidationException(
                    $request, $validator
            );
        }
        
        $user_data = $request->all();
        
        if(empty($user_data['password'])){
            unset($user_data['password']);
        } else {
            $user_data['password'] = bcrypt($user_data['password']);
        }
        
        $user = User::find($current_user->user_id);
        $user->update($user_data);
        
        //upload and fix ad images
        $avatar = Input::file('avatar_img');
        if(!empty($avatar)){
            $destination_path = public_path('uf/udata/');
            if($avatar->isValid()){
                @unlink(public_path('uf/udata/') . '100_' . $user->avatar);
                
                $file_name = $user->user_id . '_' .md5(time() + rand(0,9999)) . '.' . $avatar->getClientOriginalExtension();
                $avatar->move($destination_path, $file_name);
                 
                $img = Image::make($destination_path . $file_name);
                $width = $img->width();
                $height = $img->height();
                
                if($width == $height || $width > $height){
                    $img->heighten(100, function ($constraint) {
                        $constraint->upsize();
                    })->save($destination_path . '100_' . $file_name);
                } else {
                    $img->widen(100, function ($constraint) {
                        $constraint->upsize();
                    })->save($destination_path . '100_' . $file_name);
                }
                
                $img->resizeCanvas(100, 100, 'center')->save($destination_path . '100_' . $file_name);
                $user->avatar = $file_name;
                $user->save();
                @unlink($destination_path . $file_name);
            }
        }
        
        //set flash message and return
        session()->flash('message', trans('myprofile.Your profile is updated.'));
        return redirect()->back();
    }
    
    public function mymail(Request $request)
    {
        $current_user_id = Auth::user()->user_id;
        $where = ['user_id_to' => $request->user()->user_id, 'UMS.mail_deleted' => 0];
        $order = ['mail_date' => 'DESC'];
        $mailList = $this->mail->getMailList($current_user_id, $where, $order);

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('mymail.My Messages');

        return view('user.mymail', ['mailList' => $mailList, 'title' => $title]);
    }
    
    public function mailview(Request $request)
    {
        //get params
        $hash = $request->hash;
        $user_id_from = $request->user_id_from;
        $ad_id = $request->ad_id;
        $current_user_id = Auth::user()->user_id;
        
        //calc hash
        $hash_array = array($current_user_id, $user_id_from, $ad_id);
        sort($hash_array);
        $calculated_hash = md5(join('-', $hash_array));
        
        //check hash
        if($calculated_hash != $hash){
            return redirect(url('mymail'));
        }
        
        //mark conversation as read
        UserMailStatus::where('mail_hash', $hash)
            ->where('user_id', $current_user_id)
            ->update(['mail_status' => UserMailStatus::MAIL_STATUS_READ]);
        
        //get conversation
        $where = ['user_mail.mail_hash' => $hash, 'UMS.mail_deleted' => 0];
        $order = ['mail_date' => 'ASC'];
        $mailList = $this->mail->getMailList($current_user_id, $where, $order);
        
        if($mailList->isEmpty()){
            return redirect(route('mymail'));
        }

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('mailview.Mail View');
        
        return view('user.mailview', ['mailList' => $mailList, 'hash' => $hash, 'title' => $title]);
    }
    
    public function mailviewsave(Request $request)
    {
        //get params
        $hash = $request->hash;
        $user_id_from = $request->user_id_from;
        $ad_id = $request->ad_id;
        $current_user_id = Auth::user()->user_id;
    
        //calc hash
        $hash_array = array($current_user_id, $user_id_from, $ad_id);
        sort($hash_array);
        $calculated_hash = md5(join('-', $hash_array));
    
        //check hash
        if($calculated_hash != $hash){
            return redirect(url('mymail'));
        }
        
        //get ad info
        $ad_detail = Ad::where('ad_active', 1)->findOrFail($ad_id);
        
        //validate form
        $rules = ['contact_message' => 'required|min:20'];
         
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        
        //if user save message
        if($current_user_id > 0){

            //get other user info
            $userInfo = $this->user->getUserById($user_id_from);

            //save in db and send mail
            $this->mail->saveMailToDbAndSendMail($current_user_id, $user_id_from, $ad_id, $request->contact_message, $userInfo->email);
        
            //set flash message and return
            session()->flash('message', trans('mailview.Your message was send.'));
            
            //clear the cache
            Cache::flush();
        } else {
            //set error flash message and return
            session()->flash('message', trans('mailview.Ups something is wrong, please try again later or contact our team.'));
        }
        return redirect()->back();
    }
    
    public function maildelete(Request $request)
    {
        //get params
        $mail_id = $request->mail_id;
        $current_user_id = $request->user()->user_id;
        
        //mark mail deleted
        $umStatus = UserMailStatus::where('user_id', $current_user_id);
        if(is_numeric($mail_id)){
            $umStatus->where('mail_id', $mail_id);
        } else {
            $umStatus->where('mail_hash', $mail_id);
        }
        $umStatus->update(['mail_deleted' => UserMailStatus::MAIL_STATUS_DELETED]);
    
        //clear the cache
        Cache::flush();
        
        return redirect()->back();
    }

    public function mywallet(Request $request)
    {
        $user = Auth::user();

        $params     = $request->all();
        $where      = [];
        $order      = ['wallet_id' => 'desc'];
        $limit      = 0;
        $orderRaw   = '';
        $whereIn    = [];
        $whereRaw   = [];
        $paginate   = config('dc.mywallet_num_items');
        $page       = 1;


        $where['wallet.user_id'] = ['=', $user->user_id];
        if (isset($params['page']) && is_numeric($params['page'])) {
            $page = $params['page'];
        }

        $walletList = $this->wallet->getList($where, $order, $limit, $orderRaw, $whereIn, $whereRaw, $paginate, $page);
        $wallet_total = $this->wallet->where('user_id', $user->user_id)->sum('sum');

        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('mywallet.My Wallet Page Title');
        $title[] = trans('mywallet.Page:') . ' ' . $page;

        return view('user.mywallet', ['title' => $title,
            'walletList' => $walletList,
            'wallet_total' => $wallet_total,
            'user' => $user,
            'params' => $params
        ]);
    }

    public function addtowallet(Request $request)
    {
        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('addtowallet.Add Money To Wallet');

        $payment_methods = new Collection();
        if(config('dc.enable_promo_ads')){
            $where['pay_active']    = 1;
            $order['pay_ord']       = 'ASC';
            $payModel               = new Pay();
            $payment_methods        = $payModel->getList($where, $order);
        }

        return view('user.addtowallet', ['title' => $title, 'payment_methods' => $payment_methods]);
    }

    public function postaddtowallet(Request $request)
    {
        $rules = [
            'ad_type_pay' => 'required|integer|not_in:0'
        ];

        $messages = [
            'required' => trans('addtowallet.Please select payment method.'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $params = $request->all();
        $user = Auth::user();

        $where['pay_active'] = 1;
        $order['pay_ord'] = 'ASC';
        $payModel = new Pay();
        $payment_methods = $payModel->getList($where, $order);
        if (!$payment_methods->isEmpty()) {
            foreach ($payment_methods as $k => $v) {
                if($v->pay_id == $params['ad_type_pay']){
                    if(empty($v->pay_page_name)){
                        $message[] = trans('addtowallet.Your money will be added to your wallet automatically when you pay.');
                        $message[] = trans('addtowallet.Send sms to add money to your wallet', [
                            'number' => $v->pay_number,
                            'text' => $v->pay_sms_prefix . ' w' . $user->user_id,
                            'sum' => number_format($v->pay_sum, 2, '.', ''),
                            'cur' => config('dc.site_price_sign')
                        ]);
                    } else {
                        $message[] = trans('addtowallet.Your money will be added to your wallet automatically when you pay.');
                        $message[] = trans('addtowallet.Click the button to pay and add money to your wallet', [
                            'pay' => $v->pay_name,
                            'sum' => number_format($v->pay_sum, 2, '.', ''),
                            'cur' => config('dc.site_price_sign')
                        ]);
                        session()->flash('message', $message);
                        return redirect(url($v->pay_page_name . '/w' . $user->user_id));
                    }
                }
            }
        }

        //set flash message and go to info page
        session()->flash('message', $message);
        return redirect(route('info'));

    }
}
