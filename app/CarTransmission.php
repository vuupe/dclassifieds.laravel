<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarTransmission extends Model
{
    protected $table = 'car_transmission';
    protected $primaryKey = 'car_transmission_id';

    protected $fillable = ['car_transmission_name'];

    public $timestamps = false;
}
