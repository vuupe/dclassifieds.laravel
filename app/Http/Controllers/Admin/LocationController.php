<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Location;

class LocationController extends Controller
{
	protected $location;
	
	public function __construct(Location $_location)
    {
    	$this->location = $_location;
    }
    
	public function index(Request $request)
    {
    	return view('admin.pages.location_list', ['location_list' => $this->location->getAllHierarhy()]);
    }
}
