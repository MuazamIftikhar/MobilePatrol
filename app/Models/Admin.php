<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    //Casting Columns
    public $admin_id;
    public $company_name;
    public $company_address;
    public $company_phone;
    public $company_fax;
    public $company_email;
    public $company_website;
    public $company_logo;
    public $company_clock_in_message;
    public $company_clock_out_message;
    public $company_time_zone;
    public $company_phone_number_for_sms;

    public function isUser(){
        return $this->belongsTo(User::class);
    }

    public function company_setting(){
        return $this->hasOne(CompanySetting::class);
    }

    public function guards(){
        return $this->hasMany(Guard::class);
    }

    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
}
