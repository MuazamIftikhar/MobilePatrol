<?php

namespace App\Http\Traits;

use App\Models\Admin;
use App\Models\CompanySetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait CompanySettingTrait {

    public function save_company_company_details($admin_id,$company_name,$company_address,$company_phone,$company_fax,$company_email,$company_website){
        $save = CompanySetting::where('admin_id',$admin_id)->first();
        if($save) {
            $save->admin_id = $admin_id;
            $save->company_name = $company_name;
            $save->company_address = $company_address;
            $save->company_phone = $company_phone;
            $save->company_fax = $company_fax;
            $save->company_email = $company_email;
            $save->company_website = $company_website;
            $save->save();
        }else{
            $save = new CompanySetting();
            $save->admin_id = $admin_id;
            $save->company_name = $company_name;
            $save->company_address = $company_address;
            $save->company_phone = $company_phone;
            $save->company_fax = $company_fax;
            $save->company_email = $company_email;
            $save->company_website = $company_website;
            $save->save();
        }
    }

    public function save_company_clock_in_out_message($admin_id,$clock_in_message,$clock_out_message){
        $save = CompanySetting::where('admin_id',$admin_id)->first();
        if($save) {
            $save->company_clock_in_message = $clock_in_message;
            $save->company_clock_out_message = $clock_out_message;
            $save->save();
        }else{
            $save = new CompanySetting();
            $save->admin_id = $admin_id;
            $save->company_clock_in_message = $clock_in_message;
            $save->company_clock_out_message = $clock_out_message;
            $save->save();
        }
    }

    public function save_company_time_zone($admin_id,$company_time_zone){
        $save = CompanySetting::where('admin_id',$admin_id)->first();
        if($save) {
            $save->company_time_zone = $company_time_zone;
            $save->save();
        }else{
            $save = new CompanySetting();
            $save->admin_id = $admin_id;
            $save->company_time_zone = $company_time_zone;
            $save->save();
        }
    }

    public function save_company_phone_number_for_sms($admin_id,$company_phone_number_for_sms){
        $save = CompanySetting::where('admin_id',$admin_id)->first();
        if($save) {
            $save->company_phone_number_for_sms = $company_phone_number_for_sms;
            $save->save();
        }else{
            $save = new CompanySetting();
            $save->admin_id = $admin_id;
            $save->company_phone_number_for_sms = $company_phone_number_for_sms;
            $save->save();
        }
    }

    public function save_company_logo($admin_id,$company_logo){
        $save = CompanySetting::where('admin_id',$admin_id)->first();
        if($save) {
            $save->company_logo = $company_logo;
            $save->save();
        }else{
            $save = new CompanySetting();
            $save->admin_id = $admin_id;
            $save->company_logo = $company_logo;
            $save->save();
        }
    }

    public function addDemoCompanyDetails($admin_id){
        $save = new CompanySetting();
        $save->admin_id = $admin_id;
        $save->save();
    }

    public function getAdminID($user_id){
        $user = User::where('id',$user_id)->first();
        $getRoleName = $user->roles()->first()->name;
        if($getRoleName == 'manager'){
            return Admin::where('user_id',$user_id)->first()->id;
        }
    }

    public function getCompanyDetails($user_id){
        $admin_id = $this->getAdminID($user_id);
        return CompanySetting::where('admin_id',$admin_id)->first();
    }

    public function getAdminCompanyDetails($admin_id){
        return CompanySetting::where('admin_id',$admin_id)->first();
    }

}
