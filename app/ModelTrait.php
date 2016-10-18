<?php

namespace App;
use Cache;

trait ModelTrait
{
    public static function allCached($column, $direction = 'asc')
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        return Cache::rememberForever($cache_key, function() use ($column, $direction) {
            return parent::orderBy($column, $direction)->get();
        });
    }
}