<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    public function index(Request $request)
    {
    	return view('ad.home');
    }
    
    public function search(Request $request)
    {
    	return view('ad.search');
    }
    
    public function detail(Request $request)
    {
    	return view('ad.detail');
    }
}
