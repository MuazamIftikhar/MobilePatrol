<?php

namespace App\Http\Traits;

use App\Models\Visitor;
use App\Models\VisitorImages;

trait VisitorTrait {

    public function save_visitor_report_trait($guard_id,$client_id,$schedule_id,$admin_id,$visitor_name,$purpose,$company,$time_in,$time_out){
        $save = new Visitor();
        $save->guard_id = $guard_id;
        $save->client_id = $client_id;
        $save->schedule_id = $schedule_id;
        $save->admin_id = $admin_id;
        $save->visitor_name = $visitor_name;
        $save->purpose = $purpose;
        $save->company = $company;
        $save->time_in = $time_in;
        $save->time_out = $time_out;
        $save->save();
        return $save;
    }

    public function save_visitor_report_images_trait($report_id,$image){
        $save = new VisitorImages();
        $save->visitor_id = $report_id;
        $save->images = $image;
        $save->save();
    }

    public function visitor_time_out_trait($id,$time_out){
        $update = Visitor::where('id',$id)->update(['time_out' => $time_out]);
    }

}
