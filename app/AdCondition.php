<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdCondition extends Model
{
    protected $table = 'ad_condition';
    protected $primaryKey = 'ad_condition_id';

    protected $fillable = ['ad_condition_name'];

    public $timestamps = false;
}
