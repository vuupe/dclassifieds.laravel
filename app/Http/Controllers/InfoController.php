<?php

namespace App\Http\Controllers;
class InfoController extends Controller
{
    public function index()
    {
        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('info.For Your Information');

        return view('common.info_page', ['title' => $title]);
    }
}