<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarEngine extends Model
{
    protected $table = 'car_engine';
    protected $primaryKey = 'car_engine_id';

    protected $fillable = ['car_engine_name'];

    public $timestamps = false;
}
