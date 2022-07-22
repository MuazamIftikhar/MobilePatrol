<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\DailyReportTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ScheduleTrait;
use App\Models\DailyReport;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyController extends Controller
{
    use ScheduleTrait, DailyReportTrait, ResponseTrait, ImageUplaodTrait, CompanySettingTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function create_daily_report(Request $request)
    {
        $schedule = $this->getFirstSchedule($request->schedule_id);
        $timezone = $this->getCompanyDetails(Auth::user()->id)->company_time_zone;
        return view('manager.report.custom.daily.create', ['schedule' => $schedule, 'timezone' => $timezone])->with('title', 'Create Daily Report');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save_daily_report(Request $request)
    {
        try {
            $schedule = $this->getFirstSchedule($request->schedule_id);
            $date = $this->convertHtmlDateTimeToDbFormat($request->date, $request->timezone);
            $report = $this->save_daily_report_trait($schedule->guard_id, $schedule->client_id, $schedule->id,
                $schedule->admin_id, $request->description, $date);
            if ($request->hasFile('photos')) {
                foreach ($request->photos as $photo) {
                    $image = $this->uploadImage($photo);
                    $this->save_daily_report_images_trait($report->id, $image);
                }
            }
            return $this->returnWebResponse('Report created successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }


    public function update_daily_report(Request $request)
    {
        $daily_report = DailyReport::where('id', $request->daily_report_id)->first();
        $timezone = $this->getCompanyDetails(Auth::user()->id)->company_time_zone;
        return view('manager.report.custom.daily.edit', ['daily_report' => $daily_report, 'timezone' => $timezone])->with('title', 'Edit Daily Report');
    }

    public function edit_daily_report(Request $request)
    {
        try {
            $date = $this->convertHtmlDateTimeToDbFormat($request->date, $request->timezone);
            DailyReport::where('id', $request->daily_report_id)->update(['description' => $request->description,'created_at'=>$date]);
            if ($request->hasFile('photos')) {
                foreach ($request->photos as $photo) {
                    $image = $this->uploadImage($photo);
                    $this->update_daily_report_images_trait($request->daily_report_id, $image);
                }
            }
            return $this->returnWebResponse('Report Edit successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }


    }

    public function delete_daily_report(Request $request)
    {
        DailyReport::where('id', $request->daily_report_id)->update(['status' => '0']);
        return back();
    }
}
