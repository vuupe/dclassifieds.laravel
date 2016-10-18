<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class AdCondition extends Model
{
    use ModelTrait;

    protected $table        = 'ad_condition';
    protected $primaryKey   = 'ad_condition_id';
    protected $fillable     = ['ad_condition_name'];
    public $timestamps      = false;
}
