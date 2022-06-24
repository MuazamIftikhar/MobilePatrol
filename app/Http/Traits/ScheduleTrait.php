<?php

namespace App\Http\Traits;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait ScheduleTrait {
    use PhpFunctionsTrait, CompanySettingTrait;
    public function create_schedule($admin_id,$client_id,$guard_id,$from_date_time,$to_date_time,$instructions){
        $save = new Schedule();
        $save->admin_id = $admin_id;
        $save->client_id = $client_id;
        $save->guard_id = $guard_id;
        $save->from_date_time = $from_date_time;
        $save->to_date_time = $to_date_time;
        $save->instructions = $instructions;
        $save->save();
        return $save;
    }

    public function updates_schedule($id,$admin_id,$client_id,$guard_id,$from_date_time,$to_date_time,$instructions){
        $update = Schedule::where('id',$id)->update([
            "from_date_time" => $from_date_time,
        "to_date_time" => $to_date_time,
        "instructions" => $instructions
        ]);
    }

    public function checkIfDateAndTimeAlreadyExists($guard_id,$from_date_time,$to_date_time){
        $from_date_time = $this->convertDateTimeToDbFormatPlus1($from_date_time);
        $to_date_time = $this->convertDateTimeToDbFormatPlus1($to_date_time);
        $check =Schedule::whereBetween('from_date_time', [$from_date_time, $to_date_time])
            ->orWhereBetween('to_date_time', [$from_date_time, $to_date_time])
            ->where('guard_id',$guard_id)->get();
        if(count($check) > 0){
            return false;
        }else{
            return true;
        }
    }

    public function checkIfDateAndTimeAlreadyExistsUpdate($id,$guard_id,$from_date_time,$to_date_time){
        $from_date_time = $this->convertDateTimeToDbFormatPlus1($from_date_time);
        $to_date_time = $this->convertDateTimeToDbFormatPlus1($to_date_time);
        $check =Schedule::whereBetween('from_date_time', [$from_date_time, $to_date_time])
            ->orWhereBetween('to_date_time', [$from_date_time, $to_date_time])
            ->where('guard_id',$guard_id)->get()->except($id);
        if(count($check) > 0){
            return false;
        }else{
            return true;
        }
    }

    public function checkIfSameDateToRepeat($from_date,$to_date){
        $convertoCarbonDayNameFromDate = Carbon::parse($from_date)->format('l');
        $convertoCarbonDayNameToDate = Carbon::parse($to_date)->format('l');
        if($convertoCarbonDayNameFromDate == $convertoCarbonDayNameToDate){
            return 'sameDay';
        }else{
            return "nextDay";
        }
    }

    public function getDayName($date){
        $convertoCarbonDayNameFromDate = substr(Carbon::parse($date)->format('l'),0,3);
        return $convertoCarbonDayNameFromDate;
    }

    public function makeCalenderClassColors($start_limit,$end_limit,$status){
        if($status == 0){
            return "fc-event-danger";
        }else {
            $datetime = Carbon::parse(Carbon::now())->toDateTimeString();
            if ((strtotime($datetime) >= strtotime($start_limit)) && (strtotime($datetime) <= strtotime($end_limit))) {
                return "fc-event-primary";
            }
            if ((strtotime($datetime) > strtotime($start_limit)) && (strtotime($datetime) > strtotime($end_limit))) {
                return "fc-event-warning";
            }
            if ((strtotime($datetime) < strtotime($start_limit)) && (strtotime($datetime) < strtotime($end_limit))) {
                return "fc-event-success";
            }
        }
    }

    public function convertWithRespectToTimeZone($date_time,$id){
        $company_details = $this->getAdminCompanyDetails($id);
        $datetime = Carbon::createFromFormat('Y-m-d H:i:s', $date_time,'UTC');
        $datetime->setTimezone($company_details->company_time_zone);
        return $datetime;
    }
    public function convertDateToHtmlFormat($date){
        $date=Carbon::parse($date)->format('m/d/Y');
        return $date;
    }

    public function get_schedule_detail_by_id_trait($id){
        $schedule = Schedule::where('id',$id)->first();
        return $schedule;
    }

    public function showGuardSchedule($guard_id,$from_date_time,$to_date_time){
        $schedule=Schedule::where('guard_id',$guard_id)
            ->where(function($q) use ($from_date_time, $to_date_time) {
                $q->where(function($query) use ($from_date_time,$to_date_time){
                    $query->whereDate('from_date_time', '>=', $from_date_time)
                        ->whereDate('to_date_time', '<=', $to_date_time);
                });
                $q->orWhere(function($query) use ($from_date_time, $to_date_time) {
                 $query->whereDate('from_date_time', '>=', $from_date_time)
                        ->whereDate('to_date_time', '<=', $to_date_time);
                    });
            }) ->with(array('client','guards'))->paginate(5);
        return $schedule;
    }
    public function showAllGuardSchedule(){
        $schedule=Schedule::with(array('client','guards'))->paginate(5);
        return $schedule;
    }

    public function getFirstSchedule($schedule_id){
        $schedule=Schedule::where('id',$schedule_id)->first();
        return $schedule;
    }
}
