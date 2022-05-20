<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guard extends Model
{
    use HasFactory;
    //public $guard_type;
    public $appends = ['type_of_guard','original_driving_license_image','original_photo_id_image'];

    public function user(){
        return $this->belongsTo(User::class);
    }

//    public function mobilePatrol(){
//        return $this->hasMany(MobilePatrol::class);
//    }

    public function getDrivingLicenseImageAttribute($value){
        if($value == null){
            return "";
        }
        return env("IMAGE_PATH").$value;
    }
    public function getPhotoIdImageAttribute($value){
        if($value == null){
            return "";
        }
        return env("IMAGE_PATH").$value;
    }

    public function getOriginalDrivingLicenseImageAttribute(){
        return str_replace(env("IMAGE_PATH"),'',$this->driving_license_image);
    }
    public function getOriginalPhotoIdImageAttribute(){
        return str_replace(env("IMAGE_PATH"),'',$this->photo_id_image);
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function guard_available(){
        return $this->hasMany(GuardAvailable::class);
    }

    public function isAvailable($type,$day){
        return $this->guard_available()->where('guard_availables.shift_type', $type)
            ->where('guard_availables.shift_day',$day)->exists();
    }

    public function getTypeOfGuardAttribute(){
        return $this->guard_type == 1 ? "Regular Guard" : "Dispatch Guard";
    }

    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
    public function attendance(){
        return $this->hasMany(Attendance::class);
    }
}
