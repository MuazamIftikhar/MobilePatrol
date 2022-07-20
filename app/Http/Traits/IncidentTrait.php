<?php

namespace App\Http\Traits;

use App\Models\Incident;
use App\Models\IncidentImages;
use Illuminate\Support\Facades\Auth;

trait IncidentTrait
{
    use PhpFunctionsTrait;

    public function save_incident_report_trait($guard_id, $client_id, $schedule_id, $admin_id, $nature_of_complaint,
                                               $police_called, $anyone_interested, $property_damaged, $witness, $information, $date)
    {

        $save = new Incident();
        $save->guard_id = $guard_id;
        $save->client_id = $client_id;
        $save->schedule_id = $schedule_id;
        $save->admin_id = $admin_id;
        $save->nature_of_complaint = $nature_of_complaint;
        $save->police_called = $police_called;
        $save->anyone_interested = $anyone_interested;
        $save->property_damaged = $property_damaged;
        $save->witness = $witness;
        $save->information = $information;
        if ($date != "") {
            $save->created_at = $date;
        }
        $save->save();
        return $save;

    }

    public function save_incident_report_images_trait($report_id, $image)
    {
        $save = new IncidentImages();
        $save->incident_id = $report_id;
        $save->images = $image;
        $save->save();
    }

    public function showAllIncidentByScheduleID($schedule_id)
    {
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin', function ($query) use ($admin_id) {
            $query->where('id', $admin_id);
        })->with(array('admin', 'incident_report_images'))->where('schedule_id', $schedule_id)->where('status', 1)->paginate(10);
        return $incident;
    }

    public function showAllIncidentByClientID($client_id)
    {
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin', function ($query) use ($admin_id) {
            $query->where('id', $admin_id);
        })->with(array('admin'))->where('client_id', $client_id)->where('status', 1)->paginate(10);
        return $incident;
    }

    public function showAllIncidentByClientAndGuardID($guard_id, $from, $to, $client_id)
    {
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin', function ($query) use ($admin_id) {
            $query->where('id', $admin_id);
        })->with(array('admin'))->where('guard_id', $guard_id)->where('client_id', $client_id)
            ->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->where('status', 1)->paginate(10);
        return $incident;
    }

    public function getAllIncidentByScheduleID($schedule_id)
    {
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin', function ($query) use ($admin_id) {
            $query->where('id', $admin_id);
        })->with(array('admin'))->where('schedule_id', $schedule_id)->where('status', 1)->get();
        return $incident;
    }

    public function getAllIncidentByClientID($client_id)
    {
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin', function ($query) use ($admin_id) {
            $query->where('id', $admin_id);
        })->with(array('admin', 'incident_report_images'))->where('client_id', $client_id)->where('status', 1)->get();
        return $incident;
    }

    public function getAllIncidentByClientAndGuardID($guard_id, $from, $to, $client_id)
    {
        $admin_id = $this->getAdminID(Auth::user()->id);
        $incident = Incident::whereHas('admin', function ($query) use ($admin_id) {
            $query->where('id', $admin_id);
        })->with(array('admin', 'incident_report_images'))->where('guard_id', $guard_id)->where('client_id', $client_id)
            ->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->where('status', 1)->get();
        return $incident;
    }

    public function update_incident($incident_id, $police_called, $anyone_arrested, $property_damaged,
                                                $witness, $nature_of_complaint, $information, $date){
             $incident = Incident::where('id', $incident_id)->update(['police_called' => $police_called,
                 'anyone_interested' => $anyone_arrested, 'property_damaged' => $property_damaged, 'witness' => $witness,
                 'nature_of_complaint' => $nature_of_complaint, 'information' => $information,'created_at' => $date]);
        return $incident;
    }

    public function update_incident_report_images_trait($report_id, $image)
    {
        $save = new IncidentImages();
        $save->incident_id = $report_id;
        $save->images = $image;
        $save->save();
        return $save;
    }

}
