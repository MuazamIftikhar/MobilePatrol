<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class CompanySetting extends Model
{
    use HasFactory;
    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function getCompanyLogoAttribute($value)
    {
        return $value != null ? config("app.image_domain").$value : '';
    }
}
