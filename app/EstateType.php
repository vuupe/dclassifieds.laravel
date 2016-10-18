<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class EstateType extends Model
{
    use ModelTrait;

    protected $table        = 'estate_type';
    protected $primaryKey   = 'estate_type_id';
    protected $fillable     = ['estate_type_name'];
    public $timestamps      = false;
}
