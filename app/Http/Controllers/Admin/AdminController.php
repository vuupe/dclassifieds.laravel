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

        //get last 10 days ads
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

        //get last 10 promo days ads
        $promo_ads_by_date = Ad::select(DB::raw("count(ad_id) AS ad_count, DATE_FORMAT(ad_publish_date, '%Y-%m-%d') AS date_formated"))
            ->where('ad_promo', 1)
            ->groupBy('date_formated')
            ->orderBy('date_formated', 'desc')
            ->take(10)
            ->get()
            ->toArray();
        $stat->promo_ads_by_date = [];
        if (!empty($promo_ads_by_date)) {
            $stat->promo_ads_by_date = array_reverse($promo_ads_by_date);
        }

        //get last 10 months ads
        $ads_by_month = Ad::select(DB::raw("count(ad_id) AS ad_count, DATE_FORMAT(ad_publish_date, '%Y-%m') AS date_formated"))
            ->groupBy('date_formated')
            ->orderBy('date_formated', 'desc')
            ->take(10)
            ->get()
            ->toArray();
        $stat->ads_by_month = [];
        if (!empty($ads_by_month)) {
            $stat->ads_by_month = array_reverse($ads_by_month);
        }

        //get last 10 years ads
        $ads_by_year = Ad::select(DB::raw("count(ad_id) AS ad_count, DATE_FORMAT(ad_publish_date, '%Y') AS date_formated"))
            ->groupBy('date_formated')
            ->orderBy('date_formated', 'desc')
            ->take(10)
            ->get()
            ->toArray();
        $stat->ads_by_year = [];
        if (!empty($ads_by_year)) {
            $stat->ads_by_year = array_reverse($ads_by_year);
        }
        return view('admin.dashboard.dashboard', ['stat' => $stat]);
    }
}
