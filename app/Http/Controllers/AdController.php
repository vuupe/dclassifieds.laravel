<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
//use App\Http\Dc\Util;

class AdController extends Controller
{
	protected $category;
	protected $location;
	
	public function __construct(CategoryRepository $_category, LocationRepository $_location)
	{
		$this->category = $_category;
		$this->location = $_location;
	}
	
    public function index(Request $request)
    {
    	return view('ad.home', ['c' => $this->category->getAllHierarhy(),
    							'l' => $this->location->getAllHierarhy()]);
    }
    
    public function search(Request $request)
    {
//     	print_r(Input::all());
    	return view('ad.search');
    }
    
    public function detail(Request $request)
    {
    	return view('ad.detail');
    }
    
    public function publish(Request $request)
    {
    	return view('ad.publish');
    }
}
