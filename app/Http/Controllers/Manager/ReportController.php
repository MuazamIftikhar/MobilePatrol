<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\CheckpointTrait;
use App\Http\Traits\ClientTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\DailyReportTrait;
use App\Http\Traits\FormTrait;
use App\Http\Traits\GuardTrait;
use App\Http\Traits\IncidentTrait;
use App\Http\Traits\ScheduleTrait;
use App\Http\Traits\VisitorTrait;
use App\Models\Client;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use CompanySettingTrait, AttendanceTrait, GuardTrait, ScheduleTrait, ClientTrait, VisitorTrait,
        DailyReportTrait, FormTrait, CheckpointTrait, IncidentTrait;

    public function shift_report(Request $request)
    {
        $guard_id = $request->guard_id;
        if ($guard_id != null) {
            $shifts = $this->showGuardSchedule($guard_id, $request->from, $request->to);
        } else {
            $shifts = $this->showAllGuardSchedule();
        }
        $guard = $this->getAdminGuard();
        $form = Form::where('form_type','shift')->get();
        return view('manager.report.shifts', ['shifts' => $shifts, 'guard' => $guard, 'form' => $form])->with('title', 'Manage Reports');
    }

    public function client_report()
    {
        $clients = $this->showAdminClient();
        $form = Form::all();
        return view('manager.report.clients', ['clients' => $clients, 'form' => $form])->with('title', 'Manage Client  Reports');
    }

    public function reports_by_clients_incident(Request $request)
    {
        $co = rand(1000, 9999);
        $guard_id = $request->guard_id;
        $client = Client::where('id', $request->client_id)->first();
        if ($guard_id != null) {
            $incident = $this->showAllIncidentByClientAndGuardID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $incident = $this->showAllIncidentByClientID($request->client_id);
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.clients.incident', ['incident' => $incident, 'guard' => $guard, 'client' => $client])
            ->with('title', 'Manage Incident Reports');
    }

    public function reports_by_schedule_incident(Request $request)
    {
        $schedule = Schedule::where('id', $request->schedule_id)->first();
        $incident = $this->showAllIncidentByScheduleID($request->schedule_id);
        return view('manager.report.shifts.incident', ['incident' => $incident, 'schedule' => $schedule])
            ->with('title', 'Manage Incident Reports');
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
        return view('manager.report.clients.visitor', ['visitor' => $visitor, 'guard' => $guard, 'client' => $client])
            ->with('title', 'Manage Visitor Reports');
    }

    public function reports_by_schedule_visitor(Request $request)
    {
        $guard_id = $request->guard_id;
        $schedule = Schedule::where('id', $request->schedule_id)->first();
        if ($guard_id != null) {
            $visitor = $this->showVisitorsByScheduleAndGuardID($guard_id, $request->from, $request->to, $request->schedule_id);
        } else {
            $visitor = $this->showAllVisitorsByScheduleID($request->schedule_id);
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.shifts.visitor', ['visitor' => $visitor, 'guard' => $guard, 'schedule' => $schedule])->with('title', 'Manage Visitor Reports');
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

    public function daily_reports_by_schedule(Request $request)
    {
        $schedule = Schedule::where('id', $request->schedule_id)->first();
        $daily_report = $this->showAllDailyReportByScheduleId($request->schedule_id);
        $guard = $this->getAdminGuard();
        return view('manager.report.shifts.daily', ['daily_report' => $daily_report, 'guard' => $guard, 'schedule' => $schedule])->with('title', 'Manage Daily Reports');
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
        return view('manager.report.clients.attendance', ['attendance' => $attendance, 'guard' => $guard, 'client' => $client])->with('title', 'Manage Attendance Reports');
    }

    public function reports_by_schedule_attendance(Request $request)
    {
        $schedule = Schedule::where('id', $request->schedule_id)->first();
        $attendance = $this->showAllAttendanceReportByScheduleId($request->schedule_id);
        $guard = $this->getAdminGuard();
        return view('manager.report.shifts.attendance', ['attendance' => $attendance, 'guard' => $guard, 'schedule' => $schedule])->with('title', 'Manage Attendance Reports');
    }

    public function reports_by_clients_forms(Request $request)
    {
        $guard_id = $request->guard_id;
        $form_input = Form::where('id', $request->form_id)->first();
        if ($guard_id != null) {
            $form = $this->showAttendanceReportByGuardID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $form = $this->showAllGuardForm($request->form_id);
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.clients.forms', ['form_input' => $form_input, 'form' => $form, 'guard' => $guard])
            ->with('title', 'Manage Reports');
    }
    public function reports_by_schedule_forms(Request $request)
    {
        $form_input = Form::where('id', $request->form_id)->first();
        $form = FormValue::where('form_id',$request->form_id)->where('schedule_id',$request->schedule_id)->paginate(10);
        return view('manager.report.shifts.forms', ['form_input' => $form_input, 'form' => $form])
            ->with('title', 'Manage Reports');
    }

    public function qr_reports_by_schedule(Request $request)
    {
        $schedule = Schedule::where('id', $request->schedule_id)->first();
        $check_point = $this->showAllQrReportByScheduleId($request->schedule_id);
        $guard = $this->getAdminGuard();
        return view('manager.report.shifts.checkPoint', ['check_point' => $check_point, 'guard' => $guard, 'schedule' => $schedule])->with('title', 'Manage Qr Reports');
    }

    public function qr_reports_by_clients(Request $request)
    {
        $guard_id = $request->guard_id;
        $client = Client::where('id', $request->client_id)->first();
        if ($guard_id != null) {
            $check_point = $this->showQrReportByGuardAndClientID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $check_point = $this->showAllQrReportByClientId($request->client_id);
        }
        $guard = $this->getAdminGuard();
        return view('manager.report.clients.checkPoint', ['check_point' => $check_point, 'guard' => $guard, 'client' => $client])->with('title', 'Manage Qr Reports');
    }

    public function generate_client_attendance_pdf(Request $request)
    {
        $guard_id = $request->guard_id;
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        if ($guard_id != null) {
            $attendance = $this->getAttendanceReportByGuardAndClientID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $attendance = $this->getAllAttendanceReportByClientId($request->client_id);
        }
        $data = [
            'attendance' => $attendance,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.attendance', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-AttendanceReport.pdf');
    }

    public function generate_schedule_attendance_pdf(Request $request)
    {
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        $attendance = $this->getAllAttendanceReportByScheduleId($request->schedule_id);
        $data = [
            'attendance' => $attendance,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.attendance', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-AttendanceReport.pdf');
    }

    public function generate_schedule_daily_report_pdf(Request $request)
    {
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        $daily_report = $this->getAllDailyReportByScheduleId($request->schedule_id);
        $data = [
            'daily_report' => $daily_report,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.daily_report', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-DailyReport.pdf');
    }

    public function generate_client_daily_report_pdf(Request $request)
    {
        $guard_id = $request->guard_id;
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        if ($guard_id != null) {
            $daily_report = $this->getDailyReportByGuardID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $daily_report = $this->showAllDailyReportByClientId($request->client_id);
        }
        $data = [
            'daily_report' => $daily_report,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.daily_report', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-DailyReport.pdf');
    }

    public function generate_schedule_visitor_report_pdf(Request $request)
    {
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        $visitor = $this->getAllVisitorsByScheduleID($request->schedule_id);
        $data = [
            'visitor' => $visitor,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.visitor', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-VisitorReport.pdf');
    }

    public function generate_client_visitor_report_pdf(Request $request)
    {
        $guard_id = $request->guard_id;
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        if ($guard_id != null) {
            $visitor = $this->getVisitorsByGuardID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $visitor = $this->getAllVisitorsByClientID($request->client_id);
        }
        $data = [
            'visitor' => $visitor,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.visitor', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-VisitorReport.pdf');
    }

    public function generate_schedule_qr_report_pdf(Request $request)
    {
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        $check_point = $this->getAllQrReportByScheduleId($request->schedule_id);

        $data = [
            'check_point' => $check_point,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.check_point', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-QrReport.pdf');
    }

    public function generate_client_qr_report_pdf(Request $request)
    {
        $guard_id = $request->guard_id;
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        if ($guard_id != null) {
            $check_point = $this->showQrReportByGuardAndClientID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $check_point = $this->showAllQrReportByClientId($request->client_id);
        }
        $data = [
            'check_point' => $check_point,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.check_point', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-QrReport.pdf');
    }

    public function generate_schedule_incident_report_pdf(Request $request)
    {
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        $incident = $this->getAllIncidentByScheduleID($request->schedule_id);
        $data = [
            'incident' => $incident,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.incident', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-IncidentReport.pdf');
    }

    public function generate_client_incident_report_pdf(Request $request)
    {
        $guard_id = $request->guard_id;
        $company_setting = $this->getCompanyDetails(Auth::user()->id);
        if ($guard_id != null) {
            $incident = $this->getAllIncidentByClientAndGuardID($guard_id, $request->from, $request->to, $request->client_id);
        } else {
            $incident = $this->getAllIncidentByClientID($request->client_id);
        }
        $data = [
            'incident' => $incident,
            'company_setting' => $company_setting
        ];
        $pdf = PDF::loadView('manager.report.pdf.incident', $data);
        return $pdf->download(Carbon::now()->toFormattedDateString() . '-IncidentReport.pdf');
    }
}
