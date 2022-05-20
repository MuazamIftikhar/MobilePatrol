<?php

namespace App\Http\Traits;

use App\Models\Guard;
use App\Models\GuardAvailable;
use Illuminate\Support\Facades\Auth;

trait GuardTrait {

    use CompanySettingTrait;

    public function save_as_guard($admin_id,$user_id,$guard_name,$guard_email,$guard_license_id,$guard_phone,
                                  $guard_type,$per_hour,$work_availability,$available_start_date,$guard_license_expiry,$driving_license_image,$photo_id_image, $driving_license,
                    $driving_license_id,$driving_license_expiry){
        $save = new Guard();
        $save->admin_id = $admin_id;
        $save->user_id = $user_id;
        $save->guard_name = $guard_name;
        $save->guard_email = $guard_email;
        $save->guard_license_id = $guard_license_id;
        $save->guard_license_expiry = $guard_license_expiry;
        $save->guard_phone = $guard_phone;
        $save->guard_type = $guard_type;
        $save->per_hour = $per_hour;
        $save->work_availability = $work_availability;
        $save->available_start_date = $available_start_date;
        $save->driving_license = $driving_license;
        $save->driving_license_id = $driving_license_id;
        $save->driving_license_expiry = $driving_license_expiry;
        $save->driving_license_image = $driving_license_image;
        $save->photo_id_image = $photo_id_image;
        $save->save();
        return $save;
    }

    public function update_as_guard($guard_id,$guard_name,$guard_email,$guard_license_id,$guard_phone,
                                  $guard_type,$per_hour,$work_availability,$available_start_date,$guard_license_expiry,$driving_license_image,$photo_id_image, $driving_license,
                                  $driving_license_id,$driving_license_expiry){
        $save = Guard::where('id',$guard_id)->update([
        "guard_name" => $guard_name,
        "guard_email" => $guard_email,
        "guard_license_id" => $guard_license_id,
        "guard_license_expiry" => $guard_license_expiry,
        "guard_phone" => $guard_phone,
        "guard_type" => $guard_type,
        "per_hour" => $per_hour,
        "work_availability" => $work_availability,
        "available_start_date" => $available_start_date,
        "driving_license" => $driving_license,
        "driving_license_id" => $driving_license_id,
        "driving_license_expiry" => $driving_license_expiry,
        "driving_license_image" => $driving_license_image,
        "photo_id_image" => $photo_id_image
        ]);
    }

    public function save_guard_availablity($guard_id,$morning,$evening,$night){
        $delete = GuardAvailable::where('guard_id',$guard_id)->delete();

        foreach($morning as $m){
            $save = new GuardAvailable();
            $save->shift_type = 'Morning';
            $save->shift_day = $m;
            $save->guard_id = $guard_id;
            $save->save();
        }
        foreach($evening as $m){
            $save = new GuardAvailable();
            $save->shift_type = 'Evening';
            $save->shift_day = $m;
            $save->guard_id = $guard_id;
            $save->save();
        }
        foreach($night as $m){
            $save = new GuardAvailable();
            $save->shift_type = 'Night';
            $save->shift_day = $m;
            $save->guard_id = $guard_id;
            $save->save();
        }
    }

    public function availableDays(){
        $days = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
        $morning = array('Morning','Mon','Tue','Wed','Thu','Fri','Sat','Sun');
        $afternoon = array('Afternoon','Mon','Tue','Wed','Thu','Fri','Sat','Sun');
        $night = array('Night','Mon','Tue','Wed','Thu','Fri','Sat','Sun');
        return array('morning' => $morning,'afternoon' => $afternoon,'night' => $night,'days' =>$days);
    }

    public function work_available(){
        $available = array('Full Time','Part Time','Temporary');
        return $available;
    }

    public function showAdminGuard(){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $guards = Guard::whereHas('admin',function ($query) use ($admin_id){
            $query->where('admin_id',$admin_id);
        })->whereHas('user',function ($query) {
            $query->where('status',1);
        })->with(array('admin','user'))->paginate(15);
        return $guards;
    }

    //Get admin guard without pagination.
    public function getAdminGuard(){
        $admin_id = $this->getAdminID(Auth::user()->id);
        $guards = Guard::where('admin_id',$admin_id)->get();
        return $guards;
    }
}
