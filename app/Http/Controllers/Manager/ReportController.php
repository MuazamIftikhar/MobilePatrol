<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\ClientTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\DailyReportTrait;
use App\Http\Traits\FormTrait;
use App\Http\Traits\GuardTrait;
use App\Http\Traits\ScheduleTrait;
use App\Http\Traits\VisitorTrait;
use App\Models\Client;
use App\Models\Form;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use CompanySettingTrait, AttendanceTrait, GuardTrait, ScheduleTrait, ClientTrait, VisitorTrait,
        DailyReportTrait, FormTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $guard_id = $request->guard_id;
        if ($guard_id != null) {
            $attendance = $this->showGuardAttendance($guard_id, $request->from, $request->to);
        } else {
            $attendance = $this->showAllGuardAttendance();
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.attendance', ['attendance' => $attendance, 'guard' => $guard])->with('title', 'Manage Reports');
    }

    public function shift_report(Request $request)
    {
        $guard_id = $request->guard_id;
        if ($guard_id != null) {
            $shifts = $this->showGuardSchedule($guard_id, $request->from, $request->to);
        } else {
            $shifts = $this->showAllGuardSchedule();
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.shifts', ['shifts' => $shifts, 'guard' => $guard])->with('title', 'Manage Reports');
    }

    public function client_report()
    {
        $clients = $this->showAdminClient();
        $form=Form::all();
        return view('manager.report.clients', ['clients' => $clients,'form'=>$form])->with('title', 'Manage Client  Reports');
    }

    public function reports_by_clients_incident(Request $request)
    {
        $guard_id = $request->guard_id;
        if ($guard_id != null) {
            $shifts = $this->showGuardSchedule($guard_id, $request->from, $request->to);
        } else {
            $shifts = $this->showAllGuardSchedule();
        }
        $guard = $this->getAdminGuard();
    }

    public function reports_by_clients_visitor(Request $request)
    {
        $guard_id = $request->guard_id;
        $client = Client::where('id', $request->client_id)->first();
        if ($guard_id != null) {
            $visitor = $this->showVisitorsByGuardID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $visitor = $this->showAllVisitorsByClientID($request->client_id);
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.clients.visitor', ['visitor' => $visitor, 'guard' => $guard, 'client' => $client])->with('title', 'Manage Visitor Reports');
    }


    public function daily_reports_by_clients(Request $request)
    {
        $guard_id = $request->guard_id;
        $client = Client::where('id', $request->client_id)->first();
        if ($guard_id != null) {
            $daily_report = $this->showDailyReportByGuardID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $daily_report = $this->showAllDailyReportByClientId($request->client_id);
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.clients.daily', ['daily_report' => $daily_report, 'guard' => $guard, 'client' => $client])->with('title', 'Manage Daily Reports');
    }


    public function reports_by_clients_attendance(Request $request)
    {
        $guard_id = $request->guard_id;
        $client = Client::where('id', $request->client_id)->first();
        if ($guard_id != null) {
            $attendance = $this->showAttendanceReportByGuardID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $attendance = $this->showAllAttendanceReportByClientId($request->client_id);
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.clients.attendance', ['attendance' => $attendance, 'guard' => $guard, 'client' => $client])->with('title', 'Manage Daily Reports');
    }

    public function reports_by_clients_forms(Request $request)
    {
        $guard_id = $request->guard_id;
        $client = Client::where('id', $request->client_id)->first();
        if ($guard_id != null) {
            $attendance = $this->showAttendanceReportByGuardID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $form = $this->showAllGuardForm($request->form_id);
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.clients.forms', ['form' => $form, 'guard' => $guard, 'client' => $client])
            ->with('title', 'Manage Daily Reports');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF(Request $request)
    {
        $guard_id = $request->guard_id;
        if ($guard_id != null) {
            $attendance = $this->getGuardAttendance($guard_id, $request->from, $request->to);
        } else {
            $attendance = $this->getAllGuardAttendance();
        }
        $data = [
            'attendance' => $attendance
        ];
        $pdf = PDF::loadView('manager.report.pdf.attendance', $data);
        return $pdf->download('attendance.pdf');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
