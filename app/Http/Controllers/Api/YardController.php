<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\YardTrait;
use Illuminate\Http\Request;

class YardController extends Controller
{
    use ResponseTrait,AccountsTrait,YardTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_yard_report(Request $request)
    {
        try {
            $guard = $this->get_guard_table_row($request->user()->id);
            $report = $this->save_yard_report_trait($guard->id, $request->client_id, $request->schedule_id, $guard->admin_id,
                $request->yard_name, $request->yard_number);
            return $this->returnApiResponse(200, 'success', array('response' => 'Incident Report Saved Successfully'));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
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
