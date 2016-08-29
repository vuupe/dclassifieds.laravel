<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cache;

class AdminMenu extends Model
{
    protected $table = 'admin_menu';
    protected $primaryKey = 'menu_id';
    
    public function getMenu()
    {
    	$cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
    	$ret = Cache::get($cache_key, new Collection());
    	if($ret->isEmpty()){
    		$ret = $this->where('menu_active', 1)
    			->orderBy('menu_ord', 'asc')
    			->get();
    		Cache::put($cache_key, $ret, config('dc.cache_expire'));
    	}
    	return $ret;
    }
}
