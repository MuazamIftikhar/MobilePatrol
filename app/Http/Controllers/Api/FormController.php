<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\FormTrait;
use App\Http\Traits\GuardTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\FormValuePicture;
use App\Models\SaveForm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FormController extends Controller
{
    use PhpFunctionsTrait , ResponseTrait , ImageUplaodTrait , AccountsTrait , FormTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $form=Form::all();
            return $this->returnApiResponse(200, 'success', array('response' => 'Form Fetched Successfully','form' => $form));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save_forms_value(Request $request)
    {
        try{
            $guard=$this->get_guard_table_row($request->user()->id);
            $save_form=$this->save_forms_value_trait($guard->id,$request->form_id,$request->form_element);
            if($request->hasFile('photos')){
                foreach ($request->photos as $photo){
                    $image = $this->uploadImage($photo);
                    $save_image=$this->save_forms_value_image_trait($save_form->id,$image);
                }
            }
            return $this->returnApiResponse(200, 'success', array('response' => 'Form Value saved Successfully'));
        } catch (\Exception $e) {
            return $this->returnApiResponse(401, 'danger', array('error' => $e->getMessage()));
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
