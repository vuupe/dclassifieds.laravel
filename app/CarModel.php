<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'car_model';
    protected $primaryKey = 'car_model_id';

    protected $fillable = ['car_brand_id', 'car_model_name', 'car_model_active'];

    public $timestamps = false;

    public function brand()
    {
        return $this->belongsTo('App\CarBrand', 'car_brand_id', 'car_brand_id');
    }
}
