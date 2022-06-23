<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\ClientTrait;
use App\Http\Traits\GuardTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\IncidentTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Incident;
use App\Models\Schedule;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    use ClientTrait,GuardTrait,AccountsTrait,IncidentTrait,ImageUplaodTrait,ResponseTrait;


    public function create_incident_report(Request $request)
    {
        $schedule=Schedule::where('id',$request->schedule_id)->first();
        return view('manager.incident.create',['schedule'=>$schedule])->with('title','Create Incident Report');
    }

    public function save_incident_report(Request $request)
    {
        try {
            $schedule = Schedule::where('id',$request->schedule_id)->first();
            $report = $this->save_incident_report_trait($schedule->guard_id, $schedule->client_id, $schedule->id, $schedule->admin_id,
                $request->nature_of_complaint, $request->police_called, $request->anyone_arrested, $request->property_damaged,
                $request->witness,$request->information);
            if ($request->hasFile('photos')) {
                foreach ($request->photos as $photo) {
                    $image = $this->uploadImage($photo);
                    $this->save_incident_report_images_trait($report->id, $image);
                }
            }
            return $this->returnWebResponse('Report created successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function update_incident_report(Request $request){
        $incident = Incident::where('id',$request->incident_id)->first();
        return view('manager.incident.edit',['incident'=>$incident])->with('title','Edit Incident Report');
    }

    public function edit_incident_report(Request $request){
       try{
        $this->update_incident($request->incident_id,$request->police_called,$request->anyone_arrested,$request->property_damaged,
        $request->witness,$request->nature_of_complaint,$request->information);
//        if ($request->hasFile('photos')) {
//            foreach ($request->photos as $photo) {
//                $image = $this->uploadImage($photo);
//                $this->save_incident_report_images_trait($report->id, $image);
//            }
//        }
        return $this->returnWebResponse('Report Edit Successfully', 'success');
       } catch (\Exception $e) {
        return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

}
