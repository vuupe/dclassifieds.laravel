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
                ->whereNull('menu_parent_id')
                ->orderBy('menu_ord', 'asc')
                ->get();
            if(!$ret->isEmpty()){
                foreach($ret as $k => &$v){
                    if($v->menu_type_id == 2){
                        $c = $this->where('menu_active', 1)
                            ->where('menu_parent_id', $v->menu_id)
                            ->orderBy('menu_ord', 'asc')
                            ->get();
                        if(!$c->isEmpty()){
                            $v->c = $c;
                        }
                    }
                }
            }
            Cache::put($cache_key, $ret, config('dc.cache_expire'));
        }
        return $ret;
    }

    public function getParent($_controller)
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, 0);
        if(empty($ret)){
            $ret = $this->where('menu_controller', $_controller)->first()->menu_parent_id;
            Cache::put($cache_key, $ret, config('dc.cache_expire'));
        }
        return $ret;
    }
}
