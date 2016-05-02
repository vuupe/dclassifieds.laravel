<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdReport extends Model
{
    protected $table = 'ad_report';
    protected $primaryKey = 'report_id';
    public $timestamps = false;
}
