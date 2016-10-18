<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class CarTransmission extends Model
{
    use ModelTrait;

    protected $table        = 'car_transmission';
    protected $primaryKey   = 'car_transmission_id';
    protected $fillable     = ['car_transmission_name'];
    public $timestamps      = false;
}
