<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstateHeatingType extends Model
{
    protected $table = 'estate_heating_type';
    protected $primaryKey = 'estate_heating_type_id';

    protected $fillable = ['estate_heating_type_name'];

    public $timestamps = false;
}
