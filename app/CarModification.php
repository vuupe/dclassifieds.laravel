<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarModification extends Model
{
    protected $table = 'car_modification';
    protected $primaryKey = 'car_modification_id';

    protected $fillable = ['car_modification_name'];

    public $timestamps = false;
}
