<?php

namespace App\Http\Traits;

use App\Models\DailyReport;
use App\Models\DailyReportImages;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait DailyReportTrait {

    use PhpFunctionsTrait;
    public function save_daily_report_trait($guard_id,$client_id,$schedule_id,$admin_id,$description){
        $save = new DailyReport();
        $save->guard_id = $guard_id;
        $save->client_id = $client_id;
        $save->schedule_id = $schedule_id;
        $save->admin_id = $admin_id;
        $save->description = $description;
        $save->date=$this->convertHtmlDateTimeToDbFormat(Carbon::now(),Carbon::now()->timezone);
        $save->save();
        return $save;
    }

    public function save_daily_report_images_trait($report_id,$image){
        $save = new DailyReportImages();
        $save->daily_report_id = $report_id;
        $save->images = $image;
        $save->save();
    }

    public function showAllDailyReportByClientId($client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $daily_report=DailyReport::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->with(array('admin','guards'))->where('client_id',$client_id)->paginate(10);
        return $daily_report;
    }

    public function showDailyReportByGuardID($guard_id,$from,$to,$client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $daily_report=DailyReport::whereHas('admin',function ($query) use ($admin_id,$guard_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->with(array('admin','guards'))->where('guard_id',$guard_id)
            ->whereBetween('date', [$from, $to])->where('client_id',$client_id)->paginate(10);
        return $daily_report;
    }

    public function showAllDailyReportByScheduleId($schedule_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $daily_report=DailyReport::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->with(array('admin','guards'))
        ->where('schedule_id',$schedule_id)->where('status',1)->paginate(10);
        return $daily_report;
    }

    public function getAllDailyReportByScheduleId($schedule_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $daily_report=DailyReport::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->with(array('admin','guards','daily_report_images'))
            ->where('schedule_id',$schedule_id)->where('status',1)->get();
        return $daily_report;
    }

    public function getDailyReportByGuardID($guard_id,$from,$to,$client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $daily_report=DailyReport::whereHas('admin',function ($query) use ($admin_id,$guard_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->with(array('admin','guards','daily_report_images'))->where('guard_id',$guard_id)
            ->whereBetween('date', [$from, $to])->where('client_id',$client_id)->where('status',1)->get();
        return $daily_report;
    }

    public function getAllDailyReportByClientId($client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $daily_report=DailyReport::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->with(array('admin','guards','daily_report_images'))->where('client_id',$client_id)
            ->where('status',1)->get();
        return $daily_report;
    }

    public function update_daily_report_images_trait($report_id,$image){
        DailyReportImages::where('daily_report_id',$report_id)->delete();
        $save = new DailyReportImages();
        $save->daily_report_id = $report_id;
        $save->images = $image;
        $save->save();
    }
}
