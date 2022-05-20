<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;
    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function getCompanyLogoAttribute($value)
    {
        return $value != null ? env("IMAGE_PATH").$value : '';
        //return $value;
    }
}
