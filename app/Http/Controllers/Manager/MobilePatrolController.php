<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\ClientTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\GuardTrait;
use App\Http\Traits\MobilePatrolTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Guard;
use App\Models\MobilePatrol;
use App\Models\MobilePatrolReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MobilePatrolController extends Controller
{
    use CompanySettingTrait,MobilePatrolTrait,ResponseTrait,GuardTrait,ClientTrait,PhpFunctionsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title="Mobile Patrol";
        $guards = $this->getAdminGuard();
        $clients=$this->getAdminClient();
        return view('manager.mobilepatrol.create',['guards'=>$guards,'clients'=>$clients])->with('title',$title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_mobile_patrol(Request $request)
    {
        try {
            $guard=Guard::where("id",$request->guard_id)->first();
            $this->save_mobile_patrol($guard->admin_id, $request->guard_id, $request->client_id, $request->instructions);
            return $this->returnWebResponse("Mobile Patrols saved Successfully", 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(),'danger');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function manage_mobile_patrol(Request $request)
    {
        $title="Manage Mobile Patrol";
        $mobile_patrol=$this->showFilterMobilePatrol($request->client_id,$request->from_date,$request->to_date);
        $guard = $this->showAdminGuard();
        $client= $this->showAdminClient();
        return view('manager.mobilepatrol.manage',compact('mobile_patrol','guard','client'))->with('title',$title);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_mobile_patrol(Request $request)
    {
        $title="Edit Mobile Patrol";
        $guards = $this->getAdminGuard();
        $clients= $this->getAdminClient();
        $mobile_patrol=MobilePatrol::where('id',$request->mobile_patrol_id)->get();
        return view('manager.mobilepatrol.edit',['mobile_patrol'=>$mobile_patrol,'guards'=>$guards,'clients'=>$clients])->with('title',$title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_mobile_patrol(Request $request)
    {
       try{
            $this->update_mobile_guard_trait($request->mobile_patrol_id,$request->guard_id,$request->client_id,$request->instructions);
            return $this->returnWebResponse("Mobile Patrols Update Successfully", 'success');
       }catch (\Exception $e){
            return $this->returnWebResponse($e->getMessage(),'danger');
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_mobile_patrol(Request $request)
    {
        MobilePatrol::where('id',$request->mobile_patrol_id)->update(['status'=>0]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view_mobile_patrol_report(Request $request)
    {
        $title="Manage Mobile Patrol Report";
        $mobile_patrol_report=MobilePatrolReport::where('mobile_patrol_id',$request->mobile_patrol_id)->with(array('guards'))->paginate(5);
        return view('manager.mobilepatrol.report',['mobile_patrol_report'=>$mobile_patrol_report,'mobile_patrol_id'=>$request->mobile_patrol_id])
            ->with('title',$title);
    }

    public function create_mobile_patrol_report(Request $request){
        $title="Mobile Patrol Report";
        $guards = $this->getAdminGuard();
        $time_zone = Session::get('timezone');
        return view('manager.mobilepatrol.report.create',['guards'=>$guards,'timezone'=>$time_zone,'mobile_patrol_id'=>$request->mobile_patrol_id])->with('title',$title);
    }

    public function save_mobile_patrol_report(Request $request){
        try {
           $date= $this->convertHtmlDateTimeToDbFormat($request->date,$request->timezone);
            $guard = Guard::where("id", $request->guard_id)->first();
            $this->save_mobile_patrol_report_trait($guard->admin_id, $request->guard_id, $request->mobile_patrol_id,
                $request->information, $date);
            return $this->returnWebResponse("Mobile Patrols Report saved Successfully", 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(),'danger');
        }
    }
}