<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\GuardTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Attendance;
use App\Models\Form;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;

class LoginController extends Controller
{
    use ResponseTrait, AccountsTrait, CompanySettingTrait;

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
                ->where('guard_id', 1)->where('status', 1)->get();
            $hours = $attendance->first()->total;
            $schedul = Schedule::where('guard_id', $guard->id)->get();
            $total_schedule = count($schedul);
            $total_time_in = count($attendance);
            $next_schedule = Schedule::where('guard_id', 1)->where('from_date_time', '>=', $today)
                ->with(array('client'))->first();
            return $this->returnApiResponse(200, 'success', array('hours' => $hours, 'total_schedule' => $total_schedule, 'total_tim_in' => $total_time_in,
                'next_schedule' => $next_schedule));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }
    }

    public function sos(Request $request){
        $sid = "ACde8d20059d3698903fa6ba4f4bae5302";
        $token = "971691d53b01a7f7b5835be32706a687";
        $twilio = new Client($sid, $token);
        $user_id=$request->user()->id;
        $company_phone=$this->getCompanyDetails($user_id)->company_phone_number_for_sms;
        $guard_name=$request->user()->name;
        $string = "$guard_name has an emergency.";
        $message = $twilio->messages->create("$company_phone",
                ["body" => $string, "from" => "+15874053478"]
            );
    }
}
