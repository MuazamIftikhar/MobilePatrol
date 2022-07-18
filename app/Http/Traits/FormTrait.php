<?php

namespace App\Http\Traits;

use App\Models\Form;
use App\Models\FormValue;
use App\Models\FormValuePicture;
use Carbon\Carbon;

trait FormTrait {

    use PhpFunctionsTrait;

    public function create_form($admin_id,$form_name,$description,$form_type,$form_element){
        $save = new Form();
        $save->admin_id = $admin_id;
        $save->name = $form_name;
        $save->form_type = $form_type;
        $save->slug = \Str::slug($form_name);
        $save->description = $description;
        $save->form_element = json_encode($form_element);
        $save->save();
        return $save;
    }

    public function checkIfFormNameExists($admin_id,$form_name){
        $check = Form::where([['admin_id', $admin_id], ['name',$form_name]])->get();
        if(count($check) > 0){
            return false;
        }else{
            return true;
        }
    }

    public function showAllGuardForm($form_id){
        $form=FormValue::where('form_id',$form_id)->paginate(10);
        return $form;

    }

    public function update_forms($id,$form_name,$description,$form_type,$form_element){
        $update = Form::where('id',$id)->update([
            "name" => $form_name,
            "form_type" => $form_type,
            "description" => $description,
            "form_element" => $form_element
        ]);
        return $update;
    }

    public function change_form_status($form_id,$status){
            if($status == "false"){
                $statuss = 0;
            }
            if($status == "true"){
                $statuss = 1;
            }
            $update = Form::where('id',$form_id)->update(['status' => $statuss]);
            return $status;
    }

    public function save_forms_value_trait($guard_id,$form_id,$form_element){
        $save_form=new FormValue();
        $save_form->guard_id=$guard_id;
        $save_form->form_id=$form_id;
        $save_form->form_element=$form_element;
        $save_form->date=$this->convertHtmlDateTimeToDbFormat(Carbon::now(),Carbon::now()->timezone);;
        $save_form->save();
        return $save_form;

    }

    public function save_forms_value_image_trait($form_id,$image) {
        $form_images=new FormValuePicture();
        $form_images->form_value_id=$form_id;
        $form_images->images=$image;
        $form_images->save();
    }


}
