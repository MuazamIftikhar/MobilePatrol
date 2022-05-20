<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\MobilePatrolTrait;
use App\Http\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MobilePatrolController extends Controller
{
    //

    use  AccountsTrait, ImageUplaodTrait, ResponseTrait, MobilePatrolTrait;

    public function get_all_mobile_patrols(Request $request)
    {
        try {
            $guard = $this->get_guard_table_row($request->user()->id);
            $mobile_patrols = $this->get_all_mobile_patrols_trait($guard->id, $guard->admin_id);
            return $this->returnApiResponse(200, 'success', array('response' => 'Mobile Patrols fetched Successfully', 'mobile_patrols' => $mobile_patrols));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }
    }

    public function get_all_mobile_patrols_reports_by_id(Request $request)
    {
        try {
            $guard = $this->get_guard_table_row($request->user()->id);
            $mobile_patrols = $this->get_all_mobile_patrols_reports_by_id_trait($guard->admin_id, $request->id);
            return $this->returnApiResponse(200, 'success', array('response' => 'Mobile Patrols Reports fetched Successfully', 'mobile_patrols' => $mobile_patrols));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }
    }

    public function save_mobile_patrol_report(Request $request)
    {
        try {
            $guard = $this->get_guard_table_row($request->user()->id);
            $date = Carbon::parse($request->date)->toDateTimeString();
            $report = $this->save_mobile_patrol_report_trait($guard->admin_id, $guard->id, $request->id, $request->information, $date);
            if($request->has_photos == true){
                foreach ($request->photos as $photo){
                    $image = $this->uploadImage($photo);
                    $this->save_mobile_patrol_report_images_trait($report->id,$image);
                }
            }
            return $this->returnApiResponse(200, 'success', array('response' => 'Mobile Patrols Report saved Successfully'));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }
    }
    public function change_mobile_patrol_status(Request $request)
    {
        try {
            $this->mobile_patrol_status_change($request->id);
            return $this->returnApiResponse(200, 'success', array('response' => 'Mobile Patrols Status Change Successfully'));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }
    }
}
