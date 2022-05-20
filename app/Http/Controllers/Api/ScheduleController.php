<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //

    use AccountsTrait, ResponseTrait;

    public function get_guard_schedules(Request $request){
        try{
        $guard = $this->get_guard_table_row($request->user()->id);
        $schedules = Schedule::whereHas('guards',function ($query) use ($guard){
            $query->where('guard_id',$guard->id);
        })->with(array('client','guards'))->whereDate('from_date_time',$request->date)->get();
        return $this->returnApiResponse(200, 'success', array('response' => 'Schedule fetched Successfully','schedules' => $schedules));
        }catch(\Exception $e){
            return $this->returnApiResponse('301','danger',array('error'=>$e->getMessage()));
        }
    }

    public function index(){

    }
}
