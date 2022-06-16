<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\DailyReportTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\VisitorTrait;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitorController extends Controller
{

    use VisitorTrait, AccountsTrait, ImageUplaodTrait, ResponseTrait, PhpFunctionsTrait;

    public function save_visitor_report(Request $request)
    {
        try {
            $guard = $this->get_guard_table_row($request->user()->id);
            $report = $this->save_visitor_report_trait($guard->id, $request->client_id, $request->schedule_id, $guard->admin_id,
                $request->visitor_name, $request->purpose, $request->company, $request->time_in, $request->time_out);
            if ($request->has_photos == true) {
                foreach ($request->photos as $photo) {
                    $image = $this->uploadImage($photo);
                    $this->save_visitor_report_images_trait($report->id, $image);
                }
            }
            return $this->returnApiResponse(200, 'success', array('response' => 'Visitor Report Saved Successfully'));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }
    }

    public function get_visitor_report_by_schedule(Request $request)
    {
        try {
            $guard = $this->get_guard_table_row($request->user()->id);
            $daily = Visitor::where('schedule_id', $request->schedule_id)
                ->with(array('visitor_report_images', 'admin', 'guards', 'client'))->get();
            return $this->returnApiResponse(200, 'success', array('response' => 'Visitor Report fetched Successfully', 'reports' => $daily));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }
    }

    public function visitor_time_out(Request $request)
    {
        try {
            $guard = $this->get_guard_table_row($request->user()->id);
            $time_out = $this->convertHtmlDateTimeToDbFormat(Carbon::now(), Carbon::now()->timezone);
            $this->visitor_time_out_trait($request->id, $time_out);
            $visitor = Visitor::where('id', $request->id)->first();
            return $this->returnApiResponse(200, 'success', array('response' => 'Visitor Timed-out Successfully', 'time_out' => $visitor->local_time_out));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }
    }
}
