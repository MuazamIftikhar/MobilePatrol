<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\CheckpointTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\ScheduleTrait;
use App\Models\Checkpoint;
use App\Models\CheckpointHistory;
use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckpointController extends Controller
{
    //
    use CompanySettingTrait, ResponseTrait, CheckpointTrait, ScheduleTrait;

    public function client_checkpoints(Request $request)
    {
        $checkpoints = Checkpoint::with(array('client'))->where('client_id', $request->client_id)->paginate(15);
        return view('manager.client.checkpoint.index', compact('checkpoints'))->with('title', 'Manage Checkpoints');
    }

    public function create_qr_checkpoint(Request $request)
    {
        $admin_id = $this->getAdminID(Auth::user()->id);
        $this->validate($request, [
            'qr_code' => ['required', 'string', 'max:255'],
        ]);
        try {
            $save_checkpoint = $this->save_qr_checkpoint($admin_id, $request->client_id, $request->qr_code);
            return $this->returnWebResponse('Checkpoint QR created successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function print_qr_single(Request $request)
    {
        $checkpoint = Checkpoint::where('id', '=', $request->id)->first();

        $fileName = $checkpoint->checkpoint_name;

        $pdf = PDF::loadView('manager.client.QR.single_qr_print', compact('checkpoint'));
        return $pdf->download($fileName . '.pdf');
    }

    public function create_qr_report(Request $request)
    {
        $schedule = $this->getFirstSchedule($request->schedule_id);
        $admin_id = $this->getAdminID(Auth::user()->id);
        $checkpoint = Checkpoint::where('admin_id', $admin_id)->where('client_id', $schedule->client_id)->get();
        return view('manager.report.custom.checkpoint.create', ['schedule' => $schedule, 'checkpoint' => $checkpoint])->with('title', 'Create QR Report');
    }

    public function save_qr_report(Request $request)
    {
        try {
            $schedule = $this->getFirstSchedule($request->schedule_id);
            $timezone = $this->getCompanyDetails(Auth::user()->id)->company_time_zone;
            $date = $this->convertHtmlDateTimeToDbFormat($request->date, $timezone);
            $this->save_check_point_history($schedule->admin_id, $schedule->client_id, $schedule->id, $schedule->guard_id,$request->checkpoint_id,$request->type,$date);
            return $this->returnWebResponse('Report created successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function update_qr_report(Request $request){
        try {
            $checkpoint_history = CheckpointHistory::where('id', $request->checkpoint_hitory_id)
                ->with(array('schedule'))->first();
            $admin_id = $this->getAdminID(Auth::user()->id);
            $checkpoint = Checkpoint::where('admin_id', $admin_id)->where('client_id', $checkpoint_history->client_id)->get();
            $timezone = $this->getCompanyDetails(Auth::user()->id)->company_time_zone;
            return view('manager.report.custom.checkpoint.edit', ['checkpoint_history' => $checkpoint_history,'checkpoint'=>$checkpoint,'timezone'=>$timezone])->with('title', 'Edit QR Report');
        } catch (\Exception $e) {
        return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function edit_qr_report(Request $request){
        try {
            $date = $this->convertHtmlDateTimeToDbFormat($request->date, $request->timezone);
            $this->update_check_point_history($request->checkpoint_history_id,$request->checkpoint_id,$request->type,$date);
            return $this->returnWebResponse('Report created successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function delete_qr_report(Request $request){
        try {
            $this->delete_qr_report_trait($request->checkpoint_hitory_id);
            return back();
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }
}
