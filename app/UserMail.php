<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cache;
use DB;
use Mail;
use App\Http\Dc\Util;

class UserMail extends Model
{
    protected $table = 'user_mail';
    protected $primaryKey = 'mail_id';
    public $timestamps = false;
    
    public function getMailList($_current_user_id, $_where = [], $_order = [], $_limit = 0, $_orderRaw = '', $_whereIn = [], $_whereRaw = [], $_paginate = 0, $_page = 1)
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, new Collection());
        if($ret->isEmpty()){
            $q = $this->newQuery();
            
            $q->select('user_mail.*', 'UMS.*', 'U.name', 'U.user_id', 'U.avatar', 'U.email');
            
            if(!empty($_where)){
                foreach ($_where as $k => $v){
                    if(is_array($v)){
                        $q->where($k, $v[0], $v[1]);
                    } else {
                        $q->where($k, $v);
                    }
                }
            }
            
            if(!empty($_whereIn)){
                foreach ($_whereIn as $k => $v){
                    if(is_array($v)){
                        $q->whereIn($k, $v);
                    }
                }
            }
            
            if(!empty($_whereRaw)){
                foreach ($_whereRaw as $k => $v){
                    if(is_array($v)){
                        $q->whereRaw($k, $v);
                    }
                }
            }
            
            if(!empty($_order)){
                foreach($_order as $k => $v){
                    $q->orderBy($k, $v);
                }
            }
            
            if(!empty($_orderRaw)){
                $q->orderByRaw($_orderRaw);
            }
            
            if($_limit > 0){
                $q->take($_limit);
            }
            
            $q->leftJoin('user_mail_status AS UMS', function($join) use ($_current_user_id){
                $join->on('UMS.mail_id', '=', 'user_mail.mail_id');
                $join->on('UMS.user_id', '=', DB::raw($_current_user_id));
            });
            
            $q->leftJoin('user AS U', 'U.user_id' , '=', 'user_mail.user_id_from');
            
            if($_paginate > 0){
                $res = $q->paginate($_paginate);
            } else {
                $res = $q->get();
            }
            if(!$res->isEmpty()){
                $ret = $res;
                Cache::put($cache_key, $ret, config('dc.cache_expire'));
            }
            
            //show generated query
            //dd(DB::getQueryLog());
        }
        return $ret;
    }
    
    public function saveMailToDbAndSendMail($_current_user_id, $_ad_user_id, $_ad_id, $_text, $_mail_to)
    {
    	//generate conversation hash
    	$hash_array = array($_current_user_id, $_ad_user_id, $_ad_id);
    	sort($hash_array);
    	$hash = md5(join('-', $hash_array));
    	
    	//save message
    	$userMail = new UserMail();
    	$userMail->ad_id = $_ad_id;
    	$userMail->user_id_from = $_current_user_id;
    	$userMail->user_id_to = $_ad_user_id;
    	$userMail->mail_text = Util::nl2br(strip_tags($_text));
    	$userMail->mail_date = date('Y-m-d H:i:s');
    	$userMail->mail_hash = $hash;
    	$userMail->save();
    	
    	//save message status
    	$userMailStatus = new UserMailStatus();
    	$userMailStatus->mail_id = $userMail->mail_id;
    	$userMailStatus->user_id = $_ad_user_id;
    	$userMailStatus->mail_status = UserMailStatus::MAIL_STATUS_UNREAD;
    	$userMailStatus->mail_deleted = UserMailStatus::MAIL_STATUS_NOT_DELETED;
    	$userMailStatus->mail_hash = $hash;
    	$userMailStatus->save();
    	
    	//save status for the other user
    	$userMailStatus = new UserMailStatus();
    	$userMailStatus->mail_id = $userMail->mail_id;
    	$userMailStatus->user_id = $_current_user_id;
    	$userMailStatus->mail_status = UserMailStatus::MAIL_STATUS_SEND;
    	$userMailStatus->mail_deleted = UserMailStatus::MAIL_STATUS_NOT_DELETED;
    	$userMailStatus->mail_hash = $hash;
    	$userMailStatus->save();
    	
    	//send mail to ad publisher
    	Mail::send('emails.ad_contact', ['userMail' => $userMail], function ($m) use ($_mail_to) {
    		$m->from('test@mylove.bg', 'dclassifieds ad contact');
    		$m->to($_mail_to)->subject('You have new message in DClassifieds');
    	});
    }
}
