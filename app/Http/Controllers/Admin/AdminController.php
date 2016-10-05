<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ad;
use App\User;
use App\AdReport;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
    }
    
    public function dashboard(Request $request)
    {
        $stat = new \Stdclass();
        $stat->num_ads = Ad::count();
        $stat->num_promo_ads = Ad::where('ad_promo', 1)->count();
        $stat->users = User::count();
        $stat->reports = AdReport::count();
        $ads_by_date = Ad::select(DB::raw("count(ad_id) AS ad_count, DATE_FORMAT(ad_publish_date, '%Y-%m-%d') AS date_formated"))
            ->groupBy('date_formated')
            ->orderBy('date_formated', 'desc')
            ->take(10)
            ->get()
            ->toArray();
        $stat->ads_by_date = [];
        if (!empty($ads_by_date)) {
            $stat->ads_by_date = array_reverse($ads_by_date);
        }
        return view('admin.dashboard.dashboard', ['stat' => $stat]);
    }
}
