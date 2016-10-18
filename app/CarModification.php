<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class CarModification extends Model
{
    use ModelTrait;

    protected $table        = 'car_modification';
    protected $primaryKey   = 'car_modification_id';
    protected $fillable     = ['car_modification_name'];
    public $timestamps      = false;
}
