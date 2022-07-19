<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\GuardTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Attendance;
use App\Models\Form;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    use ResponseTrait, AccountsTrait;

    public function index(Request $request)
    {
        if (auth()->attempt($request->all())) {
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return $this->returnApiResponse('200', 'success', array('user' => auth()->user(), 'access_token' => $accessToken));
        } else {

            return $this->returnApiResponse('401', 'warning', 'Login failed');
        }
    }

    public function check_token(Request $request)
    {
        if (auth()->user()) {
            return $this->returnApiResponse('200', 'success', array('user' => auth()->user()));
        } else {
            return $this->returnApiResponse('401', 'warning', 'Login failed');
        }
    }

    public function dashboard_values(Request $request)
    {
        try {
            $today = Carbon::now()->format('Y-m-d h:m:s');
            $guard = $this->get_guard_table_row($request->user()->id);
            $attendance = Attendance::select('*', DB::raw("HOUR(SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF(time_out,time_in)))) ) as 'total'"))
                ->where('guard_id', $guard->id)->where('status', 1)->get();
            $hours = $attendance->first->total;
            $schedul = Schedule::where('guard', $guard->id)->get();
            $total_schedule = count($schedul);
            $total_time_in = count($attendance);
            $next_schedule = Schedule::where('guard_id', 1)->where('from_date_time', '>=', $today)->first();
            return $this->returnApiResponse(200, 'success', array('hours' => $hours, 'total_schedule' => $total_schedule, 'total_tim_in' => $total_time_in,
                'next_schedule' => $next_schedule));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }

    }
}
