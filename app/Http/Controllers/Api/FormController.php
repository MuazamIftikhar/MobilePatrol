<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\FormValuePicture;
use App\Models\SaveForm;
use Illuminate\Http\Request;

class FormController extends Controller
{
    use PhpFunctionsTrait,ResponseTrait,ImageUplaodTrait;
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
        $save_form=new FormValue();
        $save_form->user_id=$request->user()->id;
        $save_form->form_id=$request->form_id;
        $save_form->form_element=$request->form_element;
        $save_form->save();
        if($request->hasFile('photos')){
            foreach ($request->photos as $photo){
                $image = $this->uploadImage($photo);
                $form_images=new FormValuePicture();
                $form_images->form_value_id=$save_form->id;
                $form_images->images=$image;
                $form_images->save();
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
