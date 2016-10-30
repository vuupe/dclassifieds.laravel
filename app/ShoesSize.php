<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelTrait;

class ShoesSize extends Model
{
    use ModelTrait;

    protected $table        = 'shoes_size';
    protected $primaryKey   = 'shoes_size_id';
    protected $fillable     = ['shoes_size_name', 'shoes_size_ord'];
    public $timestamps      = false;
}
