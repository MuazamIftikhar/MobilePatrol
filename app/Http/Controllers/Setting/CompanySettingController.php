<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\TimeFormatsTrait;
use App\Models\Admin;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    //
    use TimeFormatsTrait, CompanySettingTrait, ResponseTrait, PhpFunctionsTrait, ImageUplaodTrait;

    public function manager_company_setting()
    {
        $admin_id = $this->returnAuthUserAdminID(Auth::user()->id);
        $company_details = CompanySetting::where('admin_id', $admin_id)->first();
        $timezones = $this->timeZonesList();
        return view('manager.setting.create', compact('timezones', 'company_details'))->with('title', 'Company Profile Setting');
    }

    public function save_company_details(Request $request)
    {
        $admin_id = $this->getAdminID(Auth::user()->id);
        //Saving Company Information Block
        if ($request->form_type == "company_details_saved") {
            $this->validate($request, [
                'company_name' => ['required'],
                'company_address' => ['required'],
                'company_phone' => ['required'],
                'company_fax' => ['required'],
                'company_email' => ['required'],
                'company_website' => ['required'],
            ]);
            try {
                $this->save_company_company_details($admin_id, $request->company_name,
                    $request->company_address, $request->company_phone, $request->company_fax, $request->company_email, $request->company_website);
                return $this->returnWebResponse($this->removeSlashAndUpperCaseFirstLetter($request->form_type) . " successfully", 'success');
            } catch (\Exception $e) {
                return $this->returnWebResponse($e->getMessage(), 'danger');
            }
        }

        if($request->form_type == "clock_in_and_out_message"){
            $this->validate($request, [
                'company_clock_in_message' => ['required'],
                'company_clock_out_message' => ['required'],
            ]);
            try {
                $this->save_company_clock_in_out_message($admin_id, $request->company_clock_in_message,$request->company_clock_out_message);
                return $this->returnWebResponse($this->removeSlashAndUpperCaseFirstLetter($request->form_type) . " successfully", 'success');
            } catch (\Exception $e) {
                return $this->returnWebResponse($e->getMessage(), 'danger');
            }
        }

        if($request->form_type == "time_zone_updated"){
            $this->validate($request, [
                'company_time_zone' => ['required'],
            ]);
            try {
                $this->save_company_time_zone($admin_id, $request->company_time_zone);
                return $this->returnWebResponse($this->removeSlashAndUpperCaseFirstLetter($request->form_type) . " successfully", 'success');
            } catch (\Exception $e) {
                return $this->returnWebResponse($e->getMessage(), 'danger');
            }
        }

        if($request->form_type == "phone_number_for_sms_updated"){
            $this->validate($request, [
                'company_phone_number_for_sms' => ['required'],
            ]);
            try {
                $this->save_company_phone_number_for_sms($admin_id, $request->company_phone_number_for_sms);
                return $this->returnWebResponse($this->removeSlashAndUpperCaseFirstLetter($request->form_type) . " successfully", 'success');
            } catch (\Exception $e) {
                return $this->returnWebResponse($e->getMessage(), 'danger');
            }
        }

        if($request->form_type == "logo_added"){
            $this->validate($request, [
                'company_logo' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            try {
                $image_file_name = $this->uploadImage($request->company_logo);
                if($image_file_name == "error"){
                    return $this->returnWebResponse($this->ResponseVariables()->ERROR_IMAGE_RESPONSE, 'danger');
                }
                $this->save_company_logo($admin_id,$image_file_name);
                return $this->returnWebResponse($this->removeSlashAndUpperCaseFirstLetter($request->form_type) . " successfully", 'success');
            } catch (\Exception $e) {
                return $this->returnWebResponse($e->getMessage(), 'danger');
            }
        }
    }
}
