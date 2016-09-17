<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdType extends Model
{
    protected $table = 'ad_type';
    protected $primaryKey = 'ad_type_id';

    protected $fillable = ['ad_type_name'];

    public $timestamps = false;
}
