<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdCondition;

class AdConditionController extends Controller
{
    protected $ad_condition;

    public function __construct(AdCondition $_ad_condition)
    {
        $this->ad_condition = $_ad_condition;
    }
    
    public function index(Request $request)
    {
        return view('admin.adcondition.adcondition_list');
    }
}
