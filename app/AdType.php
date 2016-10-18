<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class AdType extends Model
{
    use ModelTrait;

    protected $table        = 'ad_type';
    protected $primaryKey   = 'ad_type_id';
    protected $fillable     = ['ad_type_name'];
    public $timestamps      = false;
}
