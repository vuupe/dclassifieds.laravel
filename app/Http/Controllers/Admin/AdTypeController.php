<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdType;

class AdTypeController extends Controller
{
    protected $ad_type;

    public function __construct(AdType $_ad_type)
    {
        $this->ad_type = $_ad_type;
    }
    
    public function index(Request $request)
    {
        return view('admin.adtype.adtype_list');
    }
}
