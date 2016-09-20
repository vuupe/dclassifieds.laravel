<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarCondition extends Model
{
    protected $table = 'car_condition';
    protected $primaryKey = 'car_condition_id';

    protected $fillable = ['car_condition_name'];

    public $timestamps = false;
}
