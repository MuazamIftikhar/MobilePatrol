<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ScheduleTrait;
use App\Models\Client;
use App\Models\Guard;
use App\Models\Schedule;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    //
    use CompanySettingTrait, ScheduleTrait, ResponseTrait, PhpFunctionsTrait;

    public function index(){
        $admin_id = $this->getAdminID(Auth::user()->id);

        $clients = Client::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->whereHas('user',function ($query){
            $query->where('status',1);
        })->with(array('admin','user'))->get();

        $guards = Guard::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->whereHas('user',function ($query){
            $query->where('status',1);
        })->with(array('admin','user'))->get();

        $company_details = $this->getCompanyDetails(Auth::user()->id);
        return view('manager.schedule.index',compact('clients','guards','company_details'))->with('title','Create Schedule');
    }

    public function save_schedule(Request $request){
        try{
            $admin_id = $this->getAdminID(Auth::user()->id);
            $from_date_time = $this->convertDateTimeToDbFormat($request->from_date_time);
            //dd($request->from_date_time."  ". $from_date_time);
            $to_date_time = $this->convertDateTimeToDbFormat($request->to_date_time);
            if($request->repeat == 'false'){
                //Check 1 Same Date
                $checkDuplication = $this->checkIfDateAndTimeAlreadyExists($request->guard_id,$from_date_time,$to_date_time);
                if($checkDuplication == true) {
                    $this->create_schedule($admin_id, $request->client_id, $request->guard_id, $from_date_time, $to_date_time, $request->instructions);
                    return $this->returnApiResponse(200, 'success', array('response' => 'Shift Created Successfully'));
                }else{
                    return $this->returnApiResponse(200, 'warning', array('response' => 'Unable to create shift from '.$from_date_time.' to '.$to_date_time));
                }
            }else{
                $arr = array();
//Create Period From "From" "TO"
                $period = CarbonPeriod::create(Carbon::parse($from_date_time)->toDateString(),
                    Carbon::parse($request->date_limit)->toDateString());
                foreach ($period->toArray() as $key => $date) {
                    $periodDate =  $date->format('Y-m-d');
                    if($this->checkIfSameDateToRepeat($request->from_time,$request->to_time) == 'sameDay'){
                        if(in_array($this->getDayName($periodDate),$request->days)){
                            //Make Date Time
                            $from_Time = $this->convertDateTimeToDbFormat($periodDate." ".Carbon::parse($request->from_date_time)
                                    ->format('H:i'));
                            $to_Time = $this->convertDateTimeToDbFormat($periodDate." ".Carbon::parse($request->to_date_time)
                                    ->format('H:i'));
                            $checkDuplication = $this->checkIfDateAndTimeAlreadyExists($request->guard_id,$from_Time,$to_Time);
                            if($checkDuplication == false) {
                                array_push($arr,'From: '.$from_Time." To: ".$to_Time);
                            } else {
                                $this->create_schedule($admin_id, $request->client_id, $request->guard_id, $from_Time, $to_Time, $request->instructions);
                            }
                        }
                    }else{
                        //If day not same
                        if(in_array($this->getDayName($periodDate),$request->days)) {
                            $from_Time = $this->convertDateTimeToDbFormat($periodDate." ".Carbon::parse($request->from_date_time)
                                    ->format('H:i'));
                            $to_Time = $this->convertDateTimeToDbFormat($periodDate." ".Carbon::parse($request->to_date_time)
                                    ->format('H:i'));
                            $checkDuplication = $this->checkIfDateAndTimeAlreadyExists($request->guard_id,$from_Time,$to_Time);
                            if($checkDuplication == false) {
                                array_push($arr,'From: '.$from_Time." To: ".$to_Time);
                            } else {
                                $this->create_schedule($admin_id, $request->client_id, $request->guard_id, $from_Time, $to_Time, $request->instructions);
                            }
                        }
                    }
                }
                return $this->returnApiResponse(200, 'success', array('response' => 'Shifts Created Successfully','issues' => $arr));
            }
        }catch (\Exception $e){
            return $this->returnApiResponse(404, 'error', array());
        }
    }

    public function get_schedules_for_guard(Request $request){
        $schedules = Schedule::where('client_id',$request->client_id)->with(array('client','guards'))->get();
        return $this->returnApiResponse(200, 'success', array('response' => 'Schedule fetched Successfully','schedules' => $schedules));
    }

    public function update_schedule(Request $request){
        try{
            $admin_id = $this->getAdminID(Auth::user()->id);
            $from_date_time = $this->convertDateTimeToDbFormat($request->from_date_time);
            $to_date_time = $this->convertDateTimeToDbFormat($request->to_date_time);

                //Check 1 Same Date
                $checkDuplication = $this->checkIfDateAndTimeAlreadyExistsUpdate($request->id,$request->guard_id,$from_date_time,$to_date_time);
                if($checkDuplication == true) {
                    $this->updates_schedule($request->id,$admin_id, $request->client_id, $request->guard_id, $from_date_time, $to_date_time, $request->instructions);
                    return $this->returnApiResponse(200, 'success', array('response' => 'Shift Updated Successfully'));
                }else{
                    return $this->returnApiResponse(200, 'warning', array('response' => 'Unable to create shift from '.$from_date_time.' to '.$to_date_time));
                }

        }catch (\Exception $e){
            return $this->returnApiResponse(404, 'error', array());
        }
    }
}
