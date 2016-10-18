<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;

class CarBrand extends Model
{
    protected $table        = 'car_brand';
    protected $primaryKey   = 'car_brand_id';
    protected $fillable     = ['car_brand_name', 'car_brand_active'];
    public $timestamps      = false;

    public function models()
    {
        return $this->hasMany('App\CarModel', 'car_brand_id', 'car_brand_id');
    }

    public static function allCached($column, $direction = 'asc')
    {
        $cache_key = __CLASS__ . '_' . __LINE__ . '_' . md5(config('dc.site_domain') . serialize(func_get_args()));
        return Cache::rememberForever($cache_key, function() use ($column, $direction) {
            return parent::where('car_brand_active', 1)
                ->orderBy($column, $direction)
                ->get();
        });
    }
}
