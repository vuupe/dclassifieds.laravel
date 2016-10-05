<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Page;

use Cache;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $page_slug = trim($request->page_slug);
        $pageData = Cache::rememberForever('pageData_' . $page_slug , function() use ($page_slug) {
            return Page::where('page_slug', $page_slug)->firstOrFail();
        });
        return view('page.page', ['pageData' => $pageData]);
    }
}
