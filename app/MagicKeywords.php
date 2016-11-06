<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Cache;

class MagicKeywords extends Model
{
    protected $table        = 'magic_keywords';
    protected $primaryKey   = 'keyword_id';
    public $timestamps      = false;
    protected $fillable     = ['keyword', 'keyword_count', 'keyword_url'];

    public function getList($_order = [], $_limit = 0)
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, new Collection());
        if($ret->isEmpty()){
            $q = $this->newQuery();

            if(!empty($_order)){
                foreach($_order as $k => $v){
                    $q->orderBy($k, $v);
                }
            }

            if($_limit > 0){
                $q->take($_limit);
            }

            $res = $q->get();

            if(!$res->isEmpty()){
                $ret = $res;
                Cache::put($cache_key, $ret, config('dc.cache_expire'));
            }
        }
        return $ret;
    }

    public function getKeywordList($_where = [], $_order = [], $_limit = 0, $_orderRaw = '', $_whereIn = [], $_whereRaw = [], $_paginate = 0, $_page = 1)
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        $ret = Cache::get($cache_key, new Collection());
        if($ret->isEmpty()){
            $q = $this->newQuery();

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
