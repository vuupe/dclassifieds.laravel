<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Cache;

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
    protected $fillable = ['name', 'avatar', 'email', 'password', 'user_activation_token'];

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
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_name') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, '');
        if(empty($ret)){
            $q = $this->newQuery();
            $ret = $q->findOrFail($_user_id);
            Cache::put($cache_key, $ret, config('dc.cache_expire'));
        }
        return $ret;
    }
}
