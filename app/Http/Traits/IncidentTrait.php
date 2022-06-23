<?php

namespace App\Http\Traits;

use App\Models\Incident;
use App\Models\IncidentImages;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $save->information=$information;
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

    public function showAllIncidentByScheduleID($schedule_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->where('schedule_id',$schedule_id)->paginate(10);
        return $incident;
    }

//    public function showAllIncidentByScheduleAndGuardID($guard_id,$from,$to,$schedule_id){
//        $admin_id = $this->getAdminID(Auth::user()->id);
//        $incident = Incident::whereHas('admin',function ($query) use ($admin_id){
//            $query->where('id',$admin_id);
//        })->with(array('admin'))->where('guard_id',$guard_id)->whereBetween('date', [$from, $to])
//            ->where('schedule_id',$schedule_id)->paginate(10);
//        return $incident;
//    }

    public function showAllIncidentByClientID($client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->where('client_id',$client_id)->paginate(10);
        return $incident;
    }

    public function showAllIncidentByClientAndGuardID($guard_id,$from,$to,$client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->where('guard_id',$guard_id)->whereBetween('date', [$from, $to])
            ->where('client_id',$client_id)->paginate(10);
        return $incident;
    }

    public function getAllIncidentByScheduleID($schedule_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin'))->where('schedule_id',$schedule_id)->get();
        return $incident;
    }

    public function getAllIncidentByClientID($client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin','incident_report_images'))->where('client_id',$client_id)->get();
        return $incident;
    }

    public function getAllIncidentByClientAndGuardID($guard_id,$from,$to,$client_id){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin',function ($query) use ($admin_id){
            $query->where('id',$admin_id);
        })->with(array('admin','incident_report_images'))->where('guard_id',$guard_id)->whereBetween('date', [$from, $to])
            ->where('client_id',$client_id)->get();
        return $incident;
    }

    public function update_incident($incident_id,$police_called,$anyone_arrested,$property_damaged,
        $witness,$nature_of_complaint,$information){
        $incident=Incident::where('id',$incident_id)->update(['police_called'=>$police_called,'anyone_interested'=>$anyone_arrested,
            'property_damaged'=>$property_damaged,'witness'=>$witness,'nature_of_complaint'=>$nature_of_complaint,'information'=>$information]);
        return $incident;
    }

}
