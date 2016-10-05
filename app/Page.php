<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    const HEADER_MENU = 1;
    const FOOTER_MENU = 2;

    protected $table        = 'page';
    protected $primaryKey   = 'page_id';
    protected $fillable     = ['page_position', 'page_slug', 'page_title', 'page_description', 'page_keywords', 'page_content',
        'page_active', 'page_ord', 'page_readonly'];
    public $timestamps      = false;
}