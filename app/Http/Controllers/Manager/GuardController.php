<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Traits\AccountsTrait;
use App\Http\Traits\CompanySettingTrait;
use App\Http\Traits\GuardTrait;
use App\Http\Traits\ImageUplaodTrait;
use App\Http\Traits\PhpFunctionsTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Admin;
use App\Models\Guard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardController extends Controller
{
    use AccountsTrait,ResponseTrait, GuardTrait, CompanySettingTrait, ImageUplaodTrait, PhpFunctionsTrait;
    //

    public function create_guard(Request $request){
        $days = $this->availableDays();
        $work_available = $this->work_available();
        return view('manager.guard.create',compact('days','work_available'))->with('title','Create Guard');
    }

    public function save_guard(Request $request){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $this->validate($request, [
            'guard_name' => ['required', 'string', 'max:255'],
            'guard_email' => 'required|string|email|max:255',
            'guard_phone' => ['required', 'string','unique:guards'],
            'guard_license_id' => ['required', 'string'],
            'guard_license_expiry' => ['required', 'string','date'],
            'guard_type' => ['required', 'string'],
            'per_hour' => ['required', 'string'],
            'driving_license_image' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_id_image' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->driving_license == 'yes'){
            $this->validate($request, [
                'driving_license_id' => ['required', 'string'],
                'driving_license_expiry' => ['required', 'string','date'],
            ]);
        }
        try{
            if($this->check_email_duplication_for_save_in_user_table($request->guard_email)) {
                $photo_id_image = $this->uploadImage($request->photo_id_image);
                $driving_license_image = $this->uploadImage($request->driving_license_image);
                //dd($driving_license_image.$photo_id_image);
                    if ($photo_id_image != 'error' && $driving_license_image != 'error') {
                        $user = $this->create_account_in_user($request->guard_name, $request->guard_email, $request->guard_phone);
                        $this->attach_role_to_user($user, 3);
                        $guard = $this->save_as_guard($admin_id, $user->id, $request->guard_name, $request->guard_email, $request->guard_license_id, $request->guard_phone,
                            $request->guard_type, $request->per_hour, $request->work_availability, $request->available_start_date,
                            $request->guard_license_expiry, $driving_license_image, $photo_id_image, $request->driving_license,
                            $request->driving_license_id, $request->driving_license_expiry);
                        if ($request->work_availability != 'Full Time') {
                            $this->save_guard_availablity($guard->id, $request->morning, $request->evening, $request->night);
                        }
                        return $this->returnWebResponse('Guard created successfully', 'success');
                    }else{
                        return $this->returnWebResponse('Something went wrong while uploading images', 'warning');
                    }
                } else {
                    return $this->returnWebResponse('Someone with this email already present', 'warning');
                }

        }catch(\Exception $e){
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function manage_guard(){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $guards = Guard::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->with(array('admin','user'))->paginate(15);
        return view('manager.guard.manage',compact('guards'))->with('title','Manage Guard');
    }

    public function edit_guard(Request $request){

        $days = $this->availableDays();
        $work_available = $this->work_available();
        if($this->checkHash($request->guard_id,$request->hash)) {
            $guard = Guard::with('guard_available')->where('id', $request->guard_id)->first();
            //dd($guard->original_driving_license_image);
            return view('manager.guard.edit',compact('guard','work_available','days'))->with('title','Edit Guard');
        }else{
            return $this->returnWebResponse('Something went wrong', 'warning');
        }
    }

    public function update_guard(Request $request){
       // dd($request->all());
        $admin_id = $this->getAdminID(Auth::user()->id);
        $guard = Guard::where('id',$request->guard_id)->first();
        $this->validate($request, [
            'guard_name' => ['required', 'string', 'max:255'],
            'guard_email' => 'required|string|email|max:255',
            'guard_phone' => ['required', 'string'],
            'guard_license_id' => ['required', 'string'],
            'guard_license_expiry' => ['required', 'string','date'],
            'guard_type' => ['required', 'string'],
            'per_hour' => ['required', 'string'],
            //'driving_license_image' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            //'photo_id_image' =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->driving_license == 'yes'){
            $this->validate($request, [
                'driving_license_id' => ['required', 'string'],
                'driving_license_expiry' => ['required', 'string','date'],
            ]);
        }
        try{
            if($this->check_email_duplication_for_update_in_user_table($request->guard_email,$guard->user_id)) {
                if($request->hasFile('photo_id_image')) {
                    $photo_id_image = $this->uploadImage($request->photo_id_image);
                }else{
                    $photo_id_image = $guard->original_photo_id_image;
                }
                if($request->hasFile('driving_license_image')) {
                    $driving_license_image = $this->uploadImage($request->driving_license_image);
                }else{
                    $driving_license_image = $guard->original_driving_license_image;
                }
                if ($photo_id_image != 'error' && $driving_license_image != 'error') {
                    $this->update_account_in_user($guard->user_id,$request->guard_name, $request->guard_email);
                    $this->update_as_guard($guard->id, $request->guard_name, $request->guard_email, $request->guard_license_id, $request->guard_phone,
                        $request->guard_type, $request->per_hour, $request->work_availability, $request->available_start_date,
                        $request->guard_license_expiry, $driving_license_image, $photo_id_image, $request->driving_license,
                        $request->driving_license_id, $request->driving_license_expiry);
                    if ($request->work_availability != 'Full Time') {
                      $this->save_guard_availablity($guard->id, $request->morning, $request->evening, $request->night);
                    }
                    return $this->returnWebResponse('Guard updated successfully', 'success');
                }else{
                    return $this->returnWebResponse('Something went wrong while uploading images', 'warning');
                }
            } else {
                return $this->returnWebResponse('Someone with this email already present', 'warning');
            }

        }catch(\Exception $e){
            return $this->returnWebResponse($e->getMessage(), 'danger');
        }
    }

    public function change_status(Request $request){
        try {
            $response = $this->change_account_status($request->user_id, $request->status);
            return $this->returnApiResponse('200','Account Status Changed Successfully',$response);
        }catch(\Exception $e){
            return $this->returnApiResponse('404',$e->getMessage(),'');
        }
    }
}
