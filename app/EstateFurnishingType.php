<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class EstateFurnishingType extends Model
{
    use ModelTrait;

    protected $table        = 'estate_furnishing_type';
    protected $primaryKey   = 'estate_furnishing_type_id';
    protected $fillable     = ['estate_furnishing_type_name'];
    public $timestamps      = false;
}
