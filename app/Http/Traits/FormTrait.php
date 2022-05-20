<?php

namespace App\Http\Traits;

use App\Models\Form;

trait FormTrait {

    use PhpFunctionsTrait;

    public function create_form($user_id,$form_name,$description,$form_element){
        $save = new Form();
        $save->user_id = $user_id;
        $save->name = $form_name;
        $save->slug = \Str::slug($form_name);
        $save->description = $description;
        $save->form_element = json_encode($form_element);
        $save->save();
        return $save;
    }

    public function checkIfFormNameExists($user_id,$form_name){
        $check = Form::where([['user_id', $user_id], ['name',$form_name]])->get();
        if(count($check) > 0){
            return false;
        }else{
            return true;
        }
    }

    public function update_forms($id,$form_name,$description,$form_element){
        $update = Form::where('id',$id)->update([
            "name" => $form_name,
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



}
