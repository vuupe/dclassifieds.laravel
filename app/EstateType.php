<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstateType extends Model
{
    protected $table = 'estate_type';
    protected $primaryKey = 'estate_type_id';

    protected $fillable = ['estate_type_name'];

    public $timestamps = false;
}
