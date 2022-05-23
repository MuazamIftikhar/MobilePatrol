<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\DispatchTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DispatchController extends Controller
{
    use ResponseTrait,DispatchTrait,ImageUplaodTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_dispatch_report(Request $request)
    {
        try{
            $dispatch_report=$this->create_dispatch_report($request->inspection,$request->incident,$request->person_on_site,$request->site_secure,
                $request->inspection_note,$request->incident_note,$request->person_on_site_note,$request->site_secure_note,
                $request->dispatch_report_note);
            if($request->hasFile('inspection_images')){
                foreach ($request->inspection_images as $photo){
                    $image = $this->uploadImage($photo);
                    $type="inspection";
                    $this->create_dispatch_report_images($dispatch_report->id,$type,$image);
                }
            }
            if($request->hasFile('incident_images')){
                foreach ($request->incident_images as $photo){
                    $image = $this->uploadImage($photo);
                    $type="incident";
                    $this->create_dispatch_report_images($dispatch_report->id,$type,$image);
                }
            }
            if($request->hasFile('person_on_site_images')){
                foreach ($request->person_on_site_images as $photo){
                    $image = $this->uploadImage($photo);
                    $type="person on site";
                    $this->create_dispatch_report_images($dispatch_report->id,$type,$image);
                }
            }
            if($request->hasFile('site_secure_images')){
                foreach ($request->site_secure_images as $photo){
                    $image = $this->uploadImage($photo);
                    $type="site secure";
                    $this->create_dispatch_report_images($dispatch_report->id,$type,$image);
                }
            }
            if($request->hasFile('dispatch_images')){
                foreach ($request->dispatch_images as $photo){
                    $image = $this->uploadImage($photo);
                    $type="dispatch";
                    $this->create_dispatch_report_images($dispatch_report->id,$type,$image);
                }
            }
            return $this->returnApiResponse(200, 'success', array('response' => 'Dispatch Report Saved Successfully'));
        }catch(\Exception $e){
            return $this->returnApiResponse('401','danger',array('error'=>$e->getMessage()));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
