<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdReport extends Model
{
    const REPORT_TYPE_1 = 1; //Spam
    const REPORT_TYPE_2 = 2; //Scam
    const REPORT_TYPE_3 = 3; //Wrong category
    const REPORT_TYPE_4 = 4; //Prohibited goods or services
    const REPORT_TYPE_5 = 5; //Ad outdated
    const REPORT_TYPE_6 = 6; //Other

    protected $table        = 'ad_report';
    protected $primaryKey   = 'report_id';
    public $timestamps      = false;
}
