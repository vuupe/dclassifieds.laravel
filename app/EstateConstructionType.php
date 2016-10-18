<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class EstateConstructionType extends Model
{
    use ModelTrait;

    protected $table        = 'estate_construction_type';
    protected $primaryKey   = 'estate_construction_type_id';
    protected $fillable     = ['estate_construction_type_name'];
    public $timestamps      = false;
}
