<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ScheduleTrait;
use App\Http\Traits\VisitorTrait;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    use ScheduleTrait,ResponseTrait,VisitorTrait,ImageUplaodTrait ,PhpFunctionsTrait;

    public function create_visitor_report(Request $request)
    {
        $schedule = $this->getFirstSchedule($request->schedule_id);
        return view('manager.report.custom.visitor.create', ['schedule' => $schedule])->with('title', 'Create Visitor Report');
    }

    public function save_visitor_report(Request $request)
    {
        try {
            $schedule = $this->getFirstSchedule($request->schedule_id);
            $admin_info =$this->getAdminCompanyDetails($schedule->admin_id);
            $report = $this->save_visitor_report_trait($schedule->guard_id, $schedule->client_id, $schedule->id, $schedule->admin_id,
                $request->visitor_name, $request->purpose, $request->company, $request->time_in, $request->time_out,$admin_info->company_time_zone);
            if ($request->hasFile('photos')) {
                foreach ($request->photos as $photo) {
                    $image = $this->uploadImage($photo);
                    $this->save_visitor_report_images_trait($report->id, $image);
                }
            }
            return $this->returnWebResponse('Report created successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function update_visitor_report(Request $request)
    {
        $visitor=Visitor::where('id',$request->visitor_report_id)->first();
        return view('manager.report.custom.visitor.edit', ['visitor' => $visitor])->with('title', 'Edit Visitor Report');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_visitor_report(Request $request)
    {
        try {
            $admin_info =$this->getAdminCompanyDetails($request->admin_id);
            Visitor::where('id',$request->visitor_report_id)->update([
                'visitor_name' => $request->visitor_name,
                'purpose' => $request->purpose,
                'company' => $request->company,
                'time_in' => $this->convertHtmlDateTimeToDbFormat($request->time_in,$admin_info->timezone),
                'time_out' => $this->convertHtmlDateTimeToDbFormat($request->time_out,$admin_info->timezone),
            ]);
            if ($request->hasFile('photos')) {
                foreach ($request->photos as $photo) {
                    $image = $this->uploadImage($photo);
                    $this->update_visior_report_images_trait($request->visitor_report_id, $image);
                }
            }
            return $this->returnWebResponse('Report Edit Successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function delete_visitor_report(Request $request)
    {
        Visitor::where('id',$request->visitor_report_id)->update([
            'status' => 0]);
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
