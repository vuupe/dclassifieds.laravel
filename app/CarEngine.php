<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class CarEngine extends Model
{
    use ModelTrait;

    protected $table        = 'car_engine';
    protected $primaryKey   = 'car_engine_id';
    protected $fillable     = ['car_engine_name'];
    public $timestamps      = false;
}
