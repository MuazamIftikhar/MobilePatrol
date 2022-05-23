<?php

namespace App\Http\Traits;

use App\Models\DailyReport;
use App\Models\DispatchReportImages;

trait DispatchTrait {

    public function create_dispatch_report($inspection,$incident,$person_on_site,$site_secure,
                $inspection_note,$incident_note,$person_on_site_note,$site_secure_note,
                $dispatch_report_note){
        $save_dispatch=new DailyReport();
        $save_dispatch->inspection=$inspection;
        $save_dispatch->incident=$incident;
        $save_dispatch->person_on_site=$person_on_site;
        $save_dispatch->site_secure=$site_secure;
        $save_dispatch->inspection_note=$inspection_note;
        $save_dispatch->incident_note=$incident_note;
        $save_dispatch->person_on_site_note=$person_on_site_note;
        $save_dispatch->site_secure_note=$site_secure_note;
        $save_dispatch->dispatch_report_note=$dispatch_report_note;
        $save_dispatch->save();
        return back();
    }
    
    public function create_dispatch_report_images($dispatch_report_id,$type,$image)
    {
        $save_dispatch_images = new DispatchReportImages();
        $save_dispatch_images->dispatch_report_id = $dispatch_report_id;
        $save_dispatch_images->type = $type;
        $save_dispatch_images->images = $image;
        $save_dispatch_images->save();
    }

}
