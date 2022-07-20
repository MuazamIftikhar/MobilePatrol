<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\DailyReportTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\DailyReport;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    //
    use DailyReportTrait, AccountsTrait, ImageUplaodTrait, ResponseTrait;
    public function save_daily_report(Request $request){
        try{
        $guard=$this->get_guard_table_row($request->user()->id);
        $report = $this->save_daily_report_trait($guard->id,$request->client_id,$request->schedule_id,$guard->admin_id,$request->description,$request->date);
        if($request->hasFile('photos')){
            foreach ($request->photos as $photo){
                $image = $this->uploadImage($photo);
                $this->save_daily_report_images_trait($report->id,$image);
            }
        }
        return $this->returnApiResponse(200, 'success', array('response' => 'Daily Report Saved Successfully'));
        }catch(\Exception $e){
            return $this->returnApiResponse(401,'danger',array('error'=>$e->getMessage()));
        }
    }

    public function get_daily_reports_by_schedule(Request $request){
        try{
            $guard=$this->get_guard_table_row($request->user()->id);
            $daily = DailyReport::where('schedule_id',$request->schedule_id)
                ->with(array('daily_report_images','admin','guards','client'))->get();
            return $this->returnApiResponse(200, 'success', array('response' => 'Daily Report fetched Successfully','reports' => $daily));
        }catch(\Exception $e){
            return $this->returnApiResponse(401,'danger',array('error'=>$e->getMessage()));
        }
    }
}
