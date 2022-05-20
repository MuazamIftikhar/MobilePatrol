<?php

namespace App\Http\Traits;

use App\Models\Admin;
use App\Models\CompanySetting;
use App\Models\Guard;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\s;

trait AccountsTrait {

    public function create_account_in_user($name,$email,$password) {
        $save = new User();
        $save->name = $name;
        $save->email = $email;
        $save->password = md5($password);
        $save->save();
        return $save;
    }

    public function update_account_in_user($user_id,$name,$email) {
        $update = User::where('id',$user_id)->update([
            'name' => $name,
            'email' => $email
        ]);
    }

    public function check_email_duplication_for_save_in_user_table($email){
        $userCheckEmail = User::where('email',$email)->get();
        if(count($userCheckEmail) > 0){
            return false;
        }else{
            return true;
        }
    }

    public function check_email_duplication_for_update_in_user_table($email,$id){
        $userCheckEmail = User::where('email',$email)->get()->except($id);
        if(count($userCheckEmail) > 0){
            return false;
        }else{
            return true;
        }
    }

    public function change_account_status($user_id,$status){
        if($status == "false"){
            $statuss = 0;
        }
        if($status == "true"){
            $statuss = 1;
        }
        $update = User::where('id',$user_id)->update(['status' => $statuss]);
        return $status;
    }

    public function save_as_admin($user_id,$name,$email){
        $save = new Admin();
        $save->user_id = $user_id;
        $save->name = $name;
        $save->email = $email;
        $save->save();
        return $save;
    }

    public function attach_role_to_user($user,$role_name){
        $user->assignRole($role_name);
    }

    public function get_guard_table_row($user_id){
        $guard = Guard::where('user_id',$user_id)->first();
        return $guard;
    }
}