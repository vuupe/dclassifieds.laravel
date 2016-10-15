<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;

class ClearCacheController extends Controller
{
    public function index(Request $request)
    {
        Cache::flush();
        return view('admin.clear_cache.clear_cache_list', ['message' => trans('admin_common.Cache Cleared')]);
    }
}
