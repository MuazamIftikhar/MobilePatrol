<?php

namespace App\Http\Controllers;

use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\FormTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Form;
use App\Models\FormValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    use FormTrait,ResponseTrait,CompanySettingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manager.form.index')->with('title','Create form');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_form(Request $request)
    {

        try {
            $form_element_array = array();
            $admin_id=$this->getAdminID(Auth::user()->id);
            for ($i = 0; $i < count($request->form_element); $i++) {
                $decode_data = json_decode($request->form_element[$i]);
                array_push($form_element_array, $decode_data);
            }
            $checkDuplication = $this->checkIfFormNameExists($admin_id,$request->form_name);
            if($checkDuplication == true) {
            $this->create_form($admin_id, $request->form_name, $request->description,$request->form_type, $form_element_array);
            return $this->returnApiResponse(200, 'success', array('response' => 'Form Created Successfully'));
            }else{
            return $this->returnApiResponse(200, 'warning', array('response' => 'Form Name Already Present.'));
            }
        } catch (\Exception $e) {
            return $this->returnApiResponse(404, 'error', array('response' => $e->getMessage()));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function manage_form()
    {
        $admin_id=$this->getAdminID(Auth::user()->id);
        $form=Form::where('admin_id',$admin_id)->paginate(5);
        return view('manager.form.manage',compact('form'))->with('title','Manage Form');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_form($id)
    {
        $form=Form::where('id',$id)->first();
        return $form;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_form(Request $request)
    {
        try {
            $form_element_array = array();
            for ($i = 0; $i < count($request->form_element); $i++) {
                $decode_data = json_decode($request->form_element[$i]);
                array_push($form_element_array, $decode_data);
            }
            $this->update_forms($request->id, $request->form_name, $request->description,$request->form_type, $form_element_array);
            return $this->returnApiResponse(200, 'success', array('response' => 'Form Updated Successfully'));
        } catch (\Exception $e) {
            return $this->returnApiResponse(404, 'error', array());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_status(Request $request){
        try {
            $response = $this->change_form_status($request->form_id, $request->status);
            return $this->returnApiResponse('200','Form Status Changed Successfully',$response);
        }catch(\Exception $e){
            return $this->returnApiResponse('404',$e->getMessage(),'');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_form_report(Request $request){
        FormValue::where('id',$request->form_id)->update(['status'=>0]);
        return back();
    }
}
