<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Client;
use App\Models\Guard;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use AttendanceTrait,ResponseTrait,AccountsTrait;

    public function save_guard_attendance(Request $request){
        try{
            $guard_id=Guard::where('user_id',$request->user()->id)->first()->id;
            if ($request->schedule_id == null){
                $attendance=$this->check_time_out($guard_id);
                if (count($attendance) > 0){
                    $attendance_id=$this->get_attendance_id($guard_id);
                    $this->edit_guard_attendance_api($attendance_id);
                    return $this->returnApiResponse(201, 'success', array('response' => 'Guard Time Out Successfully'));
                }else {
                    $admin_id = Guard::where('id',$guard_id)->first()->admin_id;
                    $this->create_guard_attendance_api($guard_id, null, null, $admin_id);
                    return $this->returnApiResponse(200, 'success', array('response' => 'Guard Time In Successfully'));
                }
            }else{
                $attendance=$this->check_time_out($guard_id);
                if (count($attendance) > 0){
                    $attendance_id=$this->get_attendance_id($guard_id);
                    $this->edit_guard_attendance_api($attendance_id);
                    return $this->returnApiResponse(201, 'success', array('response' => 'Guard Time Out Successfully'));
                }else{
                    $schedule= Schedule::where('id',$request->schedule_id)->first();
                    $guard_id=$schedule->guard_id;$client_id=$schedule->client_id;$schedule_id=$schedule->id;$admin_id=$schedule->admin_id;
                    $this->create_guard_attendance_api($guard_id, $client_id, $schedule_id, $admin_id);
                    return $this->returnApiResponse(200, 'success', array('response' => 'Guard Time In Successfully'));
                }
            }
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }

    public function check_guard_time_out(Request $request){
        try{
            $attendance=$this->check_time_out($request->schedule_id);
            if (count($attendance) > 0){
                return $this->returnApiResponse(200, 'success', array('check_time_out' => true));
            }else{
                return $this->returnApiResponse(200, 'success', array('check_time_out' => false));
            }
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }

    public function get_guard_attendance(Request $request){
        try{
            $date = Carbon::parse($request->date)->toDateString();
            $guard=$this->get_guard_table_row($request->user()->id);
            $attendance=$this->guard_attendance($guard->id,$date);
            //return $this->returnApiResponse(200, 'success', array('attendance' => $guard));
            return $this->returnApiResponse(200, 'success', array('attendance' => $attendance));
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }

    public function get_admin_clients(Request $request){
        try{
            $admin_id=Guard::where('user_id',$request->user()->id)->first()->admin_id;
            $clients = Client::whereHas('admin',function ($query) use ($admin_id){
                $query->where('admin_id',$admin_id);
            })->with(array('admin','user'))->get();
            return $this->returnApiResponse(200, 'success', array('clients' => $clients));
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }
}
