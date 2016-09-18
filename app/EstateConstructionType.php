<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstateConstructionType extends Model
{
    protected $table = 'estate_construction_type';
    protected $primaryKey = 'estate_construction_type_id';

    protected $fillable = ['estate_construction_type_name'];

    public $timestamps = false;
}
