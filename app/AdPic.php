<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdPic extends Model
{
    protected $table = 'ad_pic';
    protected $primaryKey = 'ad_pic_id';
    public $timestamps = false;
    
    public function ad()
    {
        return $this->belongsTo('App\Ad', 'ad_id', 'ad_id');
    }
}
