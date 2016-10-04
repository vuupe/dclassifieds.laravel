<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
    }
    
    public function dashboard(Request $request)
    {
        //echo 'admin dashboard';
        return view('admin.pages.dashboard');
    }
}
