<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Collection;
use Cache;
use DB;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    
    public function ad()
    {
        return $this->hasMany('App\Ad', 'user_id', 'user_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'avatar', 'email', 'password', 'user_activation_token', 'user_location_id', 'user_phone', 
        'user_skype', 'user_address', 'user_lat_lng', 'user_site', 'user_activated', 'is_admin'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    /**
     * Confirm the user.
     *
     * @return void
     */
    public function confirmEmail()
    {
        $this->user_activated = 1;
        $this->user_activation_token = null;
        $this->save();
    }
    
    public function getUserById($_user_id)
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, '');
        if(empty($ret)){
            $q = $this->newQuery();
            $ret = $q->findOrFail($_user_id);
            Cache::put($cache_key, $ret, config('dc.cache_expire'));
        }
        return $ret;
    }
    
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function getUserList($_where = [], $_order = [], $_limit = 0, $_orderRaw = '', $_whereIn = [], $_whereRaw = [], $_paginate = 0, $_page = 1)
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, new Collection());
        if($ret->isEmpty()){
            $q = $this->newQuery();

            $q->select('user.*', 'L.location_name', DB::raw('(SELECT count(ad_id) FROM ad WHERE ad.user_id = user.user_id) AS user_ad_count'));

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

            $q->leftJoin('location AS L', 'L.location_id' , '=', 'user.user_location_id');

            if($_paginate > 0){
                $res = $q->paginate($_paginate);
            } else {
                $res = $q->get();
            }
            if(!$res->isEmpty()){
                $ret = $res;
                Cache::put($cache_key, $ret, config('dc.cache_expire'));
            }
        }
        return $ret;
    }
}
