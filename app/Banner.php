<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    const BANNER_IMAGE = 1; //image banner
    const BANNER_CODE = 2; //javascript code/html banner (adsense etc.)

    const BANNER_POSITION_LIST = 1; //home page, ad list, end etc.
    const BANNER_POSITION_DETAIL = 2; //ad detail
    const BANNER_POSITION_FOOTER = 3; //home page footer, ad list footer, end etc. footer

    protected $table = 'banner';
    protected $primaryKey = 'banner_id';

    protected $fillable = ['banner_position', 'banner_type', 'banner_name', 'banner_link', 'banner_code', 'banner_image',
        'banner_active_from', 'banner_active_to', 'banner_num_views'];

    public $timestamps = false;
}
