<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\AttendanceTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\GuardTrait;
use App\Models\Attendance;
use App\Models\Guard;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use CompanySettingTrait,AttendanceTrait,GuardTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $guard_id = $request->guard_id;
        if ($guard_id != null){
            $attendance=$this->showGuardAttendance($guard_id,$request->from,$request->to);
        }else{
            $attendance=$this->showAllGuardAttendance();
        }
        $guard = $this->showAdminGuard();
        return view('manager.report.attendance', ['attendance'=>$attendance,'guard' =>$guard])->with('title', 'Manage Reports');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF(Request $request)
    {
        $user_id=$request->guard_id;
        if ($user_id != null){
            dd($user_id);
            $attendance=$this->showGuardAttendance($user_id,$request->from,$request->to);
        }else{
            $attendance=$this->showAllGuardAttendance($user_id);
        }
        $data = [

            'attendance' => $attendance
        ];

        $pdf = PDF::loadView('manager.report.pdf.attendance', $data);

        return $pdf->download('attendance.pdf');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
