<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    protected $table = 'car_brand';
    protected $primaryKey = 'car_brand_id';

    protected $fillable = ['car_brand_name', 'car_brand_active'];

    public $timestamps = false;

    public function models()
    {
        return $this->hasMany('App\CarModel', 'car_brand_id', 'car_brand_id');
    }
}
