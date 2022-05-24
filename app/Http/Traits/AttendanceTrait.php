<?php

namespace App\Http\Traits;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait AttendanceTrait{

    use PhpFunctionsTrait,CompanySettingTrait;
    public function create_guard_attendance($guard_id,$client_id,$schedule_id,$admin_id,$time_in,$time_out,$date,$timezone){
        $attendance=new Attendance();
        $attendance->guard_id=$guard_id;
        $attendance->client_id=$client_id;
        $attendance->schedule_id=$schedule_id;
        $attendance->admin_id=$admin_id;
        $attendance->time_in=$this->convertHtmlDateTimeToDbFormat($time_in,$timezone);
        $attendance->time_out=$this->convertHtmlDateTimeToDbFormat($time_out,$timezone);
        $attendance->date=$this->convertDateToDbFormat($date);
        $attendance->save();
        return back();
    }
    public function update_guard_attendance($id,$client_id, $time_in, $time_out, $date, $timezone){
        Attendance::where('id',$id)->update([
            "client_id"=>$client_id,
            "time_in"=>$this->convertHtmlDateTimeToDbFormat($time_in,$timezone),
            "time_out"=>$this->convertHtmlDateTimeToDbFormat($time_out,$timezone),
            "date"=>$this->convertDateToDbFormat($date),
        ]);
        return back();
    }
    public function calculateTimeAttendance($user_id,$date){
        $attendance=Attendance::select('*', DB::raw("SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(time_out,time_in) )) ) as 'total'"))->where('guard_id',$user_id)->where('date',$date)->where('status',1)->first();
        return $attendance->total;
    }

    public function showGuardAttendance($guard_id,$from,$to){
        $attendance = Attendance::whereHas('guards', function ($query) use ($guard_id) {
            $query->where('id', $guard_id);
        })->with(array('guards'))->whereBetween('date', [$from, $to])->paginate(5);
        return $attendance;
    }
    public function showAllGuardAttendance(){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $attendance = Attendance::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->with(array('admin','guards'))->paginate(15);
        return $attendance;
    }

    public function getGuardAttendance($guard_id,$from,$to){
        $attendance = Attendance::whereHas('guards', function ($query) use ($guard_id) {
            $query->where('id', $guard_id);
        })->with(array('guards'))->whereBetween('date', [$from, $to])->get();
        return $attendance;
    }
    public function getAllGuardAttendance(){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $attendance = Attendance::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->with(array('admin','guards'))->get();
        return $attendance;
    }


    // Function for the Api
    public function check_time_out($guard_id){
        $attendance = Attendance::where('guard_id',$guard_id)->whereDate('date',Carbon::now()->toDateString())->where('schedule_id',null)
            ->where('time_out',null)->get();
        return $attendance;
    }

    public function check_time_out_by_schedule($guard_id,$schedule_id){
        $attendance = Attendance::where('guard_id',$guard_id)->whereDate('date',Carbon::now()->toDateString())->where('schedule_id',$schedule_id)->where('time_out',null)->get();
        return $attendance;
    }
    public function get_attendance_id($guard_id){
       $attendance = Attendance::where('guard_id',$guard_id)->whereDate('date',Carbon::now()->toDateString())->where('time_out',null)->first();
       return $attendance->id;
    }

    public function create_guard_attendance_api($guard_id, $client_id, $schedule_id, $admin_id){
        $attendance=new Attendance();
        $attendance->guard_id=$guard_id;
        $attendance->client_id=$client_id;
        $attendance->schedule_id=$schedule_id;
        $attendance->admin_id=$admin_id;
        $attendance->time_in=$this->convertHtmlDateTimeToDbFormat(Carbon::now(),Carbon::now()->timezone);
        $attendance->date=$this->convertDateToDbFormat(Carbon::now());
        $attendance->save();
        return back();

    }

    public function edit_guard_attendance_api($attendance_id){
        Attendance::where('id',$attendance_id)->update([
            "time_out"=>$this->convertHtmlDateTimeToDbFormat(Carbon::now(),Carbon::now()->timezone),
        ]);
        return back();
    }

    public function guard_attendance($guard_id,$date){
        $attendance=Attendance::where('guard_id',$guard_id)
            ->with('client')
            ->whereDate('date',$date)->get();
        return $attendance;

    }
}
