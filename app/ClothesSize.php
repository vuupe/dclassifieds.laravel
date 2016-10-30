<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class ClothesSize extends Model
{
    use ModelTrait;

    protected $table        = 'clothes_size';
    protected $primaryKey   = 'clothes_size_id';
    protected $fillable     = ['clothes_size_name', 'clothes_size_ord'];
    public $timestamps      = false;
}
