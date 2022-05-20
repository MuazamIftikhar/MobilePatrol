<?php

namespace App\Http\Traits;

use App\Models\DailyReport;
use App\Models\DailyReportImages;

trait DailyReportTrait {

    public function save_daily_report_trait($guard_id,$client_id,$schedule_id,$admin_id,$description){
        $save = new DailyReport();
        $save->guard_id = $guard_id;
        $save->client_id = $client_id;
        $save->schedule_id = $schedule_id;
        $save->admin_id = $admin_id;
        $save->description = $description;
        $save->save();
        return $save;
    }

    public function save_daily_report_images_trait($report_id,$image){
        $save = new DailyReportImages();
        $save->daily_report_id = $report_id;
        $save->images = $image;
        $save->save();
    }
}
