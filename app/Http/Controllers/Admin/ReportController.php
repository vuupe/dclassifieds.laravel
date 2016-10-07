<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdReport;

use Validator;
use Cache;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportTypes = [AdReport::REPORT_TYPE_1 => trans('admin_common.Spam'),
            AdReport::REPORT_TYPE_2 => trans('admin_common.Scam'),
            AdReport::REPORT_TYPE_3 => trans('admin_common.Wrong category'),
            AdReport::REPORT_TYPE_4 => trans('admin_common.Prohibited goods or services'),
            AdReport::REPORT_TYPE_5 => trans('admin_common.Ad outdated'),
            AdReport::REPORT_TYPE_6 => trans('admin_common.Other'),
        ];
        return view('admin.report.report_list', ['modelData' => AdReport::orderBy('report_id', 'DESC')->get(),
            'reportTypes' => $reportTypes]);
    }

    public function delete(Request $request)
    {
        //locations to be deleted
        $data = [];

        //check for single delete
        if(isset($request->id)){
            $data[] = $request->id;
        }

        //check for mass delete if no single delete
        if(empty($data)){
            $data = $request->input('report_id');
        }

        //delete
        if(!empty($data)){
            AdReport::destroy($data);
            //clear cache, set message, redirect to list
            Cache::flush();
            session()->flash('message', trans('admin_common.Report deleted'));
            return redirect(url('admin/report'));
        }

        //nothing for deletion set message and redirect
        session()->flash('message', trans('admin_common.Nothing for deletion'));
        return redirect(url('admin/report'));
    }
}
