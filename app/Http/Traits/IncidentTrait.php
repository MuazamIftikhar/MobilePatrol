<?php

namespace App\Http\Traits;

use App\Models\Incident;
use App\Models\IncidentImages;
use Carbon\Carbon;

trait IncidentTrait {
    use PhpFunctionsTrait;
    
    public function save_incident_report_trait($guard_id, $client_id, $schedule_id, $admin_id, $nature_of_complaint,
                    $police_called, $anyone_interested, $property_damaged, $witness,$information){

        $save=new Incident();
        $save->guard_id=$guard_id;
        $save->client_id=$client_id;
        $save->schedule_id=$schedule_id;
        $save->admin_id=$admin_id;
        $save->nature_of_complaint=$nature_of_complaint;
        $save->police_called=$police_called;
        $save->anyone_interested=$anyone_interested;
        $save->property_damaged=$property_damaged;
        $save->witness=$witness;
        $save->infomation=$information;
        $save->date=$this->convertHtmlDateToDbFormat(Carbon::now(),Carbon::now()->timezone);
        $save->save();
        return $save;

    }

    public function save_incident_report_images_trait($report_id,$image){
        $save = new IncidentImages();
        $save->incident_id = $report_id;
        $save->images = $image;
        $save->save();
    }

}
