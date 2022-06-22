<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\ClientTrait;
use App\Http\Traits\GuardTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\IncidentTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Guard;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    use ClientTrait,GuardTrait,AccountsTrait,IncidentTrait,ImageUplaodTrait,ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_incident_report()
    {
        $client=$this->showAdminClient();
        $guard=$this->showAdminGuard();
        return view('manager.incident.create',['clients'=>$client,'guards'=>$guard])->with('title','Create Incident Report');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_incident_report(Request $request)
    {
        try {
            $guard = Guard::where('id',$request->guard_id)->first();
            $report = $this->save_incident_report_trait($guard->id, $request->client_id, $request->schedule_id, $guard->admin_id,
                $request->nature_of_complaint, $request->police_called, $request->anyone_arrested, $request->property_damaged,
                $request->witness,$request->information);
            if ($request->hasFile('photos')) {
                foreach ($request->photos as $photo) {
                    $image = $this->uploadImage($photo);
                    $this->save_incident_report_images_trait($report->id, $image);
                }
            }
            return $this->returnWebResponse('Report created successfully', 'success');
        } catch (\Exception $e) {
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
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
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function show(Incident $incident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function edit(Incident $incident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incident $incident)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incident $incident)
    {
        //
    }
}
